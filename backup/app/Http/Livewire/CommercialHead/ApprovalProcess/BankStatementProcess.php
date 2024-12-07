<?php

namespace App\Http\Livewire\CommercialHead\ApprovalProcess;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\StreamExcelDownload;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;



class BankStatementProcess extends Component implements UseExcelDataset, WithFormatting, WithHeaders {

    use HasInfinityScroll, HasTabs, WithExportDate, ParseMonths;

    protected $queryString = [
        'activeTab' => ['as' => 'tab'],
        'startDate' => ['as' => 'from', 'except' => ''],
        'endDate' => ['as' => 'to', 'except' => ''],
    ];





    public $activeTab = 'cash';






    public $startDate = null;





    public $endDate = null;






    public $filtering = false;





    /**
     * Store id filter for cash mis
     * @var array
     */
    public $cash_stores = [];






    /**
     * Store Id filter for card mis
     * @var array
     */
    public $card_stores = [];






    /**
     * Store Id filter for card mis
     * @var array
     */
    public $wallet_stores = [];






    /**
     * Store Id filter for card mis
     * @var array
     */
    public $upi_stores = [];





    /**
     * Retek code filter for cash mis
     * @var array
     */
    public $cash_codes = [];




    /**
     * Retek code filter for card mis
     * @var array
     */
    public $card_codes = [];






    /**
     * Retek code filter for card mis
     * @var array
     */
    public $wallet_codes = [];






    /**
     * Retek code filter for card mis
     * @var array
     */
    public $upi_codes = [];






    public $store = '';





    public $code = '';






    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Approved_Process_Bank_Statement_Reconciliation';







    public function mount() {
        $this->resetExcept('activeTab');
        $this->cash_stores = $this->filters();
        $this->card_stores = $this->filters('card');
        $this->wallet_stores = $this->filters('wallet');
        $this->upi_stores = $this->filters('upi');
    }





    /**
     * return filtered datasets
     * @param mixed $type
     * @return mixed
     */
    public function filters(string $tab = 'cash') {
        $params = [
            'procType' => $tab . '_stores',
            'store' => $this->store,
            'code' => $this->code,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        return DB::infinite(
            storedProcedure: 'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Approved_Process_Bank_Statement :procType, :store, :code, :from, :to',
            params: $params,
            perPage: $this->perPage
        );
    }






    public function back() {
        $this->filtering = false;
        $this->emit('resetAll');
        $this->resetExcept(['activeTab']);
    }







    /**
     *Filters
     */
    public function filterDate($request) {
        $this->filtering = true;
        $this->startDate = $request['start'];
        $this->endDate = $request['end'];
    }







    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $cashRecon = $this->getData();


        return view('livewire.commercial-head.approval-process.bank-statement-process ', [
            'cashRecons' => $cashRecon
        ]);
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

        $params = [
            'procType' => $this->activeTab . '-export',
            'store' => $this->store,
            'code' => $this->code,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        // Procedure Instance
        return DB::infinite(
            storedProcedure: 'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Approved_Process_Bank_Statement :procType, :store, :code, :from, :to',
            params: $params,
            perPage: $this->perPage
        );
    }






    /**
     * Formatter
     * @param \App\Interface\Excel\SpreadSheet $spreadSheet
     * @param mixed $dataset
     * @return void
     */
    public function formatter(\App\Interface\Excel\SpreadSheet $spreadSheet, $dataset): void {
        $spreadSheet->setStartFrom(1);
        $spreadSheet->setFilename($this->_useToday($this->export_file_name . '_' . ucfirst($this->activeTab), now()->format('d-m-Y')));
    }




    public function headers(): array {
        return [
            "Credit Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Brand",
            "Collection Bank",
            "Status",
            "Credit Amount",
            "Deposit Amount",
            "Difference",
            "Recon Status",
            "Adjusted Amount",
            "Recon Difference",
            "Process Date",
            "Approval Remarks",
        ];
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
            'code' => $this->code,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        // Procedure Instance
        return DB::infinite(
            storedProcedure: 'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Approved_Process_Bank_Statement :procType, :store, :code, :from, :to',
            params: $params,
            perPage: $this->perPage
        );
    }
}
