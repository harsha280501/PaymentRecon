<?php

namespace App\Http\Livewire\CommercialTeam;

use App\Traits\HasTabs;
use Livewire\Component;

use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use Livewire\WithPagination;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use App\Interface\Excel\SpreadSheet;
use App\Interface\Excel\WithHeaders;
use Maatwebsite\Excel\Facades\Excel;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;
use App\Exports\CommercialTeam\Reports\BankMISExport;
use App\Exports\CommercialHead\Reports\BankMISExport as ReportsBankMISExport;

class BankMIS extends Component implements UseExcelDataset, WithFormatting, WithHeaders {

    use UseOrderBy, HasInfinityScroll, HasTabs, ParseMonths, StreamExcelDownload, WithExportDate;




    /**
     * Select the Payment Type
     * @var 
     */
    protected $bankTypes;





    public $filtering = false;




    /**
     * Filter dates (start)
     * @var 
     */
    public $from = null;






    /**
     * Filter dates (end)
     * @var 
     */
    public $to = null;





    /**
     * search by bank
     */
    public $bankName = '';





    public $store = '';






    public $stores = [];







    /**
     * Active Tab
     * @var string
     */
    public $activeTab = "all-cash-mis";






    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Bank_MIS';




    public $sync_file_name = [
        'all-cash-mis' => 'All_Cash_MIS',
        'all-card-mis' => 'All_Card_MIS',
        'all-wallet-mis' => 'All_Wallet_MIS'
    ];




    /**
     * Single Type
     * @var 
     */
    public $bankType;



    public $cash_banks = [];
    public $card_banks = [];
    public $wallet_banks = [];


    public $cash_stores = [];
    public $card_stores = [];
    public $wallet_stores = [];







    /**
     * Switch Tab 2 main
     * @return void
     */
    public function mount() {
        $this->_months = $this->_months()->toArray();
        $this->cash_stores = $this->stores('all-cash-mis');
        $this->card_stores = $this->stores('all-card-mis');
        $this->wallet_stores = $this->stores('all-wallet-mis');

        $this->cash_banks = $this->banks('all-cash-mis');
        $this->card_banks = $this->banks('all-card-mis');
        $this->wallet_banks = $this->banks('all-wallet-mis');
    }



    public function stores($tab) {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALTEAM_BankMIS_All_Bank_Reports_MIS :procType, :storeId,:bankName, :from, :to', [
            'procType' => $tab . '-stores',
            'storeId' => $this->store,
            'bankName' => $this->bankName,
            'from' => $this->from,
            'to' => $this->to
        ]);
    }



    public function banks(string $tab = 'all-cash-mis') {
        // returns data
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALTEAM_BankMIS_All_Bank_Reports_MIS :procType, :storeId,:bankName, :from, :to', [
            'procType' => $tab . '-banks',
            'storeId' => $this->store,
            'bankName' => $this->bankName,
            'from' => $this->from,
            'to' => $this->to
        ]);
    }





    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $bankMIS = $this->allBankMIS();
        // main view
        return view('livewire.commercial-team.bank-m-i-s', [
            'mis' => $bankMIS
        ]);
    }


    /**
     * Date filter
     * @param mixed $obj
     * @return void
     */
    public function filterDate($obj) {
        $this->filtering = true;
        $this->from = $obj['start'];
        $this->to = $obj['end'];
    }




    /**
     * Export the filtered dataset
     */
    public function download(string $value = ''): Collection|bool {

        // Main Params to the query
        $params = [
            'procType' => $this->activeTab . '-export',
            'storeId' => $this->store,
            'bankName' => $this->bankName,
            'from' => $this->from,
            'to' => $this->to
        ];

        // Paginating the Query
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_BankMIS_All_Bank_Reports_MIS :procType, :storeId, :bankName, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }




    public function headers(): array {
        if ($this->activeTab === "all-wallet-mis") {
            return [
                'Sales Date',
                'Deposit Date',
                'Store ID',
                'Retek Code',
                'Collection Bank',
                'Terminal ID',
                'Merchant ID',
                'Deposit Amount',


            ];
        }


        if ($this->activeTab === 'all-card-mis') {
            return [
                'Sales Date',
                'Deposit Date',
                'Store ID',
                'Retek Code',
                'Collection Bank',
                // 'Account No',
                'Merchant Code',
                'Terminal Number',
                'Deposit Amount',

            ];
        }

        return [
            'Sales Date',
            'Deposit Date',
            'Store ID',
            'Retek Code',
            'Pick Up Location',
            'Collection Bank',
            'Slip Number',
            'Deposit Amount'
        ];
    }






    public function formatter(SpreadSheet $spreadSheet, $dataset): void {
        $spreadSheet->setStartFrom(1);
        $spreadSheet->setFilename($this->_useToday($this->export_file_name . '_' . $this->sync_file_name[$this->activeTab], now()->format('d-m-Y')));
    }







    /**
     * Get the main data
     * @return mixed
     */
    public function allBankMIS() {

        // Main Params to the query
        $params = [
            'procType' => $this->activeTab,
            'storeId' => $this->store,
            'bankName' => $this->bankName,
            'from' => $this->from,
            'to' => $this->to
        ];

        // Paginating the Query
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_BankMIS_All_Bank_Reports_MIS :procType, :storeId, :bankName, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }


    /**
     * Updating the bank name triggers the back button
     * @param mixed $item
     * @return void
     */
    public function updated($item) {
        if ($item === 'bankName') {
            $this->filtering = true;
        }
    }


    /**
     * Reset all the filters
     * @return void
     */
    public function back() {
        $this->filtering = false;
        $this->resetExcept('activeTab');
        $this->emit('resetall');
        $this->emit('resetAll');
    }
}
