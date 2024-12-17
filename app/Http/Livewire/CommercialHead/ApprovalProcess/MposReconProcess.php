<?php

namespace App\Http\Livewire\CommercialHead\ApprovalProcess;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Interface\UseTabs;
use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use App\Traits\UseDefaults;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;



class MposReconProcess extends Component implements UseExcelDataset {

    use HasInfinityScroll, HasTabs, WithExportDate, UseDefaults;


    /**
     * Show Query string
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 'tab']
    ];





    public $activeTab = 'main';



    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Approved_Process_Cash_Reconciliation';





    /**
     * Store id filter for cash mis
     * @var array
     */
    public $storesM = [];






    /**
     * Store FIlter Dataset
     * @var string
     */
    public $store = '';






    public $status = '';





    /**
     * Initialize the filters
     * @return void
     */
    public function mount() {
        $this->resetExcept('activeTab');
        $this->storesM = $this->filters('main');
    }








    public function headers(): array {
        return [
            "Sales Date",
            "Desposit Date",
            "Store ID",
            "Retek Code",
            "Brand Name",
            "Collection Bank",
            "Tender to BankMIS Status",
            "Reconciliation Status",
            "Bank Drop ID",
            "Desposit SlipNo",
            "Tender Amount",
            "Deposit Amount",
            "Tender to CashMIS Diff [Tender - Deposit]",
            "Store Response Entry",
        ];
    }





    public function export() {

        $data = $this->download('');
        $headers = $this->headers();


        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }



        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists



        fputcsv($file, $headers); // adding headers to the excel

        foreach ($data as $row) {
            $row = (array) $row;
            fputcsv($file, $row);
        }

        fclose($file);

        return response()->stream(
            function () use ($filePath) {
                echo file_get_contents($filePath);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '"',
            ]
        );
    }









    public function download($value = ''): Collection|bool {

        // Parameters to pass to the Query
        $params = [
            'procType' => 'export',
            'storeId' => $this->store,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'status' => $this->status
        ];

        // Procedure Instance
        return DB::infinite(
            storedProcedure: 'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_MPOS_Reconciliation_Approved_Process :procType, :storeId, :from, :to, :status',
            params: $params,
            perPage: $this->perPage
        );
    }




    /**
     * return filtered datasets
     * @param mixed $type
     * @return mixed
     */
    public function filters(string $tab = 'cash', string $type = 'stores') {
        return DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Tracker_Process_Filters :procType', [
            'procType' => 'mpos-' . $tab . '-' . $type,
        ]);
    }






    /**
     * Data source
     * @return array
     */
    public function getData() {
        // Parameters to pass to the Query
        $params = [
            'procType' => $this->activeTab,
            'storeId' => $this->store,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'status' => $this->status
        ];

        // Procedure Instance
        return DB::infinite(
            storedProcedure: 'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_MPOS_Reconciliation_Approved_Process :procType, :storeId, :from, :to, :status',
            params: $params,
            perPage: $this->perPage
        );
    }




    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $cashRecon = $this->getData();

        return view('livewire.commercial-head.approval-process.mpos-recon-process', [
            'cashRecons' => $cashRecon
        ]);
    }
}
