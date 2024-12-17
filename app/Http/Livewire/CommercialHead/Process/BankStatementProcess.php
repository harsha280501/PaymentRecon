<?php

namespace App\Http\Livewire\CommercialHead\Process;

use App\Exports\CommercialHead\Process\CashReconProcessExport;
use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;
use App\Traits\ParseMonths;
use App\Traits\StreamExcelDownload;
use App\Traits\UseLocation;
use App\Traits\UseOrderBy;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class BankStatementProcess extends Component implements UseExcelDataset, WithFormatting, WithHeaders {

    use HasTabs, HasInfinityScroll, UseOrderBy, ParseMonths, WithExportDate, UseLocation;




    /**
     * Active tab
     * @var string
     */
    public $activeTab = 'cash';





    /**
     * Find if the filtering is active (to render a back icon)
     * @var
     */
    public $filtering = false;






    /**
     * Start date for the filter
     * @var
     */
    public $startdate = null;


    public $locations = [];
    public $Location = '';



    /**
     * End date for the filter
     * @var
     */
    public $enddate = null;








    /**
     * Show the active tab on the url
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];



    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Recon_Bank_Statement_Reconciliation';







    /**
     * Store id filters
     * @var array
     */
    public $cash_stores = [];




    /**
     * Store id filters
     * @var array
     */
    public $card_stores = [];



    /**
     * Store id filters
     * @var array
     */
    public $wallet_stores = [];




    /**
     * Store id filters
     * @var array
     */
    public $upi_stores = [];






    /**
     * Retek code filters
     * @var array
     */
    public $cash_codes = [];






    /**
     * Retek code filters
     * @var array
     */
    public $card_codes = [];







    /**
     * Retek code filters
     * @var array
     */
    public $wallet_codes = [];





    /**
     * Retek code filters
     * @var array
     */
    public $upi_codes = [];







    /**
     * Assigned filters
     * @var string
     */
    public $store = '';






    /**
     * Assigned retek code
     * @var string
     */
    public $code = '';







    /**
     * Initialize stores
     * @return void
     */
    public function mount() {
        $this->resetExcept('activeTab');
        $this->_months = $this->_months()->toArray();
        // store ids
        $this->cash_stores = $this->filters();
        $this->card_stores = $this->filters('card');
        $this->wallet_stores = $this->filters('wallet');
        $this->upi_stores = $this->filters('upi');
        // retek codes
        $this->cash_codes = $this->filters('cash', 'codes');
        $this->wallet_codes = $this->filters('wallet', 'codes');
        $this->card_codes = $this->filters('card', 'codes');
        $this->upi_codes = $this->filters('upi', 'codes');
        $this->locations = $this->_location();
    }





    /**
     * Getting the filter dataset
     * @param string $data
     * @return array
     */
    protected function filters(string $tab = 'cash', string $data = 'stores') {
        return DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_BankStatementProcess_Filters :procType', [
            'procType' => $tab . '-' . $data
        ]);
    }







    /**
     * Clear all the filters
     * @return void
     */
    public function back() {
        $this->resetExcept('activeTab');
        $this->emit('resetAll');
    }






    /**
     * Date filter that assignes value to the start and end date
     * @param mixed $data
     * @return void
     */
    public function filterDate($data) {
        $this->filtering = true;
        $this->startdate = $data['start'];
        $this->enddate = $data['end'];
    }






    /**
     * Render the main content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->getData();

        return view('livewire.commercial-head.process.bank-statement-process', [
            'dataset' => $dataset
        ]);
    }





    public function headers(): array {

        if ($this->activeTab == 'cash') {
            return [
                "Credit Date",
                "Deposit Date",
                "Store ID",
                "Retek Code",
                "Brand",
                "Location",
                "Collection Bank",
                "Status",
                "Ref no.",
                "Slip No.",
                "Credit Amount",
                "Deposit Amount",
                "Difference Amount",
                "Recon Status"
            ];
        }

        return [
            "Credit Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Brand",
            "Location",
            "Collection Bank",
            "Status",
            "TID/MID",
            "Credit Amount",
            "Deposit Amount",
            "Difference Amount",
            "Recon Status",
        ];
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



    /**
     * Download excel files
     * @param mixed $value
     * @return \Illuminate\Support\Collection|bool
     */
    public function download($value = ''): Collection|bool {
        // main call
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Process_Bank_Statement :procType, :location,:from, :to, :storeId, :retekCode', [
                'procType' => $this->activeTab . '-export',
                'location' => $this->Location,

                'from' => $this->startdate,
                'to' => $this->enddate,
                'storeId' => $this->store,
                'retekCode' => $this->code
            ], $this->perPage, $this->orderBy
        );
    }




    /**
     * Get the main data
     * @return array
     */
    public function getData() {

        $params = [
            'procType' => $this->activeTab,
            'location' => $this->Location,

            'from' => $this->startdate,
            'to' => $this->enddate,
            'storeId' => $this->store,
            'retekCode' => $this->code
        ];

        // main call
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Process_Bank_Statement :procType, :location, :from, :to, :storeId, :retekCode',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }

}
