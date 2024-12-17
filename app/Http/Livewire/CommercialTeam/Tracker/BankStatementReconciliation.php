<?php

namespace App\Http\Livewire\CommercialTeam\Tracker;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasTabs;
use Livewire\Component;
use App\Interface\UseTabs;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\HasInfinityScroll;
use App\Traits\StreamExcelDownload;
use App\Traits\UseLocation;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;



class BankStatementReconciliation extends Component implements UseExcelDataset, WithFormatting, WithHeaders {

    use HasInfinityScroll, HasTabs, UseOrderBy, ParseMonths, WithExportDate, StreamExcelDownload, UseLocation;


    protected $queryString = [
        'activeTab' => ['as' => 'tab'],
        'startDate' => ['as' => 'from', 'except' => ''],
        'endDate' => ['as' => 'to', 'except' => ''],
    ];



    public $activeTab = 'cash';



    public $startDate = null;



    public $endDate = null;










    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Tracker_BankStatement_Reconciliation';





    public $status = '';



    public $banks = [];





    public $cardBanks = [];




    public $bank = '';


    public $Location = '';



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


    public $locations = [];




    public $store = '';





    public $code = '';




    public function mount() {
        $this->resetExcept('activeTab');

        $this->cash_stores = $this->filters();
        $this->card_stores = $this->filters('card');
        $this->wallet_stores = $this->filters('wallet');
        $this->upi_stores = $this->filters('upi');

        $this->cash_codes = $this->filters('cash', 'codes');
        $this->card_codes = $this->filters('card', 'codes');
        $this->wallet_codes = $this->filters('wallet', 'codes');
        $this->upi_codes = $this->filters('upi', 'codes');
        $this->_months = $this->_months()->toArray();
        $this->locations = $this->_location();
    }



    /**
     * return filtered datasets
     * @param mixed $type
     * @return mixed
     */
    public function filters(string $tab = 'cash', string $type = 'stores') {
        return DB::select('PaymentMIS_PROC_COMMERCIALTEAM_SELECT_BankStatement_Reconciliation_Filters :procType', [
            'procType' => $tab . '-' . $type,
        ]);
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
        $this->emitTo($this->getName(), 'tabs');

        return view('livewire.commercial-team.tracker.bank-statement-reconciliation ', [
            'cashRecons' => $cashRecon
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
            'code' => $this->code,
            'status' => $this->status,
            'location' => $this->Location,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        // Procedure Instance
        return DB::withOrderBySelect(
            storedProcedure: 'PaymentMIS_PROC_COMMERCIALTEAM_SELECT_BankStatement_Reconciliation :procType, :store, :code, :status, :location, :from, :to',
            params: $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }




    public function download($value = ''): Collection|bool {

        $params = [
            'procType' => $this->activeTab . '-Export',
            'store' => $this->store,
            'code' => $this->code,
            'status' => $this->status,
            'location' => $this->Location,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_BankStatement_Export_Reconciliation :procType, :store, :code, :status, :location, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );

        // return Excel::download(new \App\Exports\CommercialHead\Tracker\BankstatementExport(collect($main), $this->activeTab), $this->_useToday('Payment_MIS_Tracker_BankStatement_' . $this->activeTab));
    }






    public function headers(): array {
        if ($this->activeTab == 'card') {
            return [
                "Credit Date",
                "Deposit Date",
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status",
                "Bank Deposit Date",
                "Msf Commission",
                "Gst Total",
                "Credit Amount",
                "Deposit Amount",
                "Difference Sales Deposit"
            ];
        }

        if ($this->activeTab == 'wallet') {
            return [

                "Credit Date",
                "Deposit Date",
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status",
                "Depost Slip No",
                "Credit Amount",
                "Deposit Amount",
                "Difference Sale Deposit"
            ];
        }

        if ($this->activeTab == 'upi') {
            return [
                "Credit Date",
                "Deposit Date",
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status	",
                "Bank Deposit Date",
                "Msf Commission",
                "Gst Total",
                "Credit Amount",
                "Net Amount",
                "Difference Sales Deposit",
            ];
        }

        return [
            "Credit Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Location",
            "Col Bank",
            "Status",
            "Depost Slip No",
            "Credit Amount",
            "Deposit Amount",
            "Difference Sale Deposit"
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

}
