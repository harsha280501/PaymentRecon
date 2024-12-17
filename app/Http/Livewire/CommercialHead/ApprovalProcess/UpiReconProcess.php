<?php

namespace App\Http\Livewire\CommercialHead\ApprovalProcess;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Interface\UseTabs;
use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use App\Traits\UseDefaults;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;



class UpiReconProcess extends Component implements UseExcelDataset {

    use HasInfinityScroll, HasTabs, WithExportDate, UseDefaults;


    protected $queryString = [
        'activeTab' => ['as' => 'tab']
    ];



    public $activeTab = 'upi';




    public $status = '';




    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Approved_Process_UPI_Reconciliation';







    /**
     * Store Id filter for card mis
     * @var array
     */
    public $card_stores = [];






    public $store = '';








    public function mount() {
        $this->resetExcept('activeTab');
        $this->card_stores = $this->filters('upi');
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





    public function headers(): array {
        return [
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Brand",
            "Collection Bank",
            "Status",
            "Recon Status",
            "Card Sale",
            "Deposit Amount",
            "Difference",
            "Store Respons Entry"
        ];
    }



  


    public function download($value = ''): Collection|bool {

        // Parameters to pass to the Query
        $params = [
            'procType' => "export",
            'store' => $this->store,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'status' => $this->status
        ];

        // Procedure Instance
        return DB::infinite(
            storedProcedure: 'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_UPI_Reconciliation_Approved_Process :procType, :store, :from, :to, :status',
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
            'procType' => 'sap-' . $tab . '-' . $type,
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
            'store' => $this->store,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'status' => $this->status
        ];

        // Procedure Instance
        return DB::infinite(
            storedProcedure: 'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_UPI_Reconciliation_Approved_Process :procType, :store, :from, :to, :status',
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

        return view('livewire.commercial-head.approval-process.upi-recon-process ', [
            'cashRecons' => $cashRecon
        ]);
    }


    
}
