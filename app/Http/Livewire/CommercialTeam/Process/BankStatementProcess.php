<?php

namespace App\Http\Livewire\CommercialTeam\Process;

use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use App\Interface\Excel\WithHeaders;
use Maatwebsite\Excel\Facades\Excel;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;
use App\Exports\CommercialHead\Process\CashReconProcessExport;

class BankStatementProcess extends Component implements UseExcelDataset, WithFormatting, WithHeaders {


    use HasTabs, HasInfinityScroll, UseOrderBy, ParseMonths, StreamExcelDownload, WithExportDate;




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
        // sotre ids
        $this->cash_stores = $this->filters();
        $this->card_stores = $this->filters('card');
        $this->wallet_stores = $this->filters('wallet');
        $this->upi_stores = $this->filters('upi');
        // retek codes
        $this->cash_codes = $this->filters('cash', 'codes');
        $this->wallet_codes = $this->filters('wallet', 'codes');
        $this->card_codes = $this->filters('card', 'codes');
        $this->upi_codes = $this->filters('upi', 'codes');
    }



    /**
     * Getting the filter dataset
     * @param string $data
     * @return array
     */
    protected function filters(string $tab = 'cash', string $data = 'stores') {
        return DB::select('PaymentMIS_PROC_COMMERCIALTEAM_SELECT_BankStatementProcess_Filters :procType', [
            'procType' => $tab . '-' . $data
        ]);
    }



    /**
     * Render the main content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->getData();

        return view('livewire.commercial-team.process.bank-statement-process', [
            'dataset' => $dataset
        ]);
    }





    /**
     * Get the main data
     * @return array
     */
    public function getData() {
        $params = [
            'procType' => $this->activeTab,
            'from' => $this->startdate,
            'to' => $this->enddate,
            'storeId' => $this->store,
            'retekCode' => $this->code
        ];

        // main call
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALTEAM_SELECT_BankStatementProcess :procType, :from, :to, :storeId, :retekCode',
            $params,
            $this->perPage,
            $this->orderBy
        );
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





    /**
     * Download excel files
     * @param mixed $value
     * @return \Illuminate\Support\Collection|bool
     */
    public function download($value = ''): Collection|bool {
        // main call
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Process_Bank_Statement :procType, :from, :to, :storeId, :retekCode',
            [
                'procType' => $this->activeTab . '-export',
                'from' => $this->startdate,
                'to' => $this->enddate,
                'storeId' => $this->store,
                'retekCode' => $this->code
            ],
            $this->perPage,
            $this->orderBy
        );
    }
}
