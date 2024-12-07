<?php

namespace App\Http\Livewire\CommercialHead\Exceptions;

use App\Exports\CommercialHead\Reports\BankMISExport;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class BankMIS extends Component {

    use WithPagination;




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





    /**
     * Contains main Types
     * @var array
     */
    public $mainTypes = [
        'cash',
        'card',
        'upi',
        'wallet',
        'phonepay',
        'paytm',
    ];





    /**
     * Temp: Has Filters for the current Tab
     * @var array
     */
    public $implementedFilters = [
        'all-cash-mis',
        'all-card-mis',
        'all-wallet-mis',
    ];





    /**
     * Active Tab
     * @var string
     */
    public $activeTab = "hdfc";



    /**
     * Single Type
     * @var 
     */
    public $bankType;





    /**
     * Pagination
     * @var int
     */
    public $page = 1;



    /**
     * Pagination
     * @var int
     */
    public $perPage = 10;






    /**
     * Switch Tab 2 main
     * @return void
     */
    public function mount() {
        $this->switchTab("all-cash-mis");
    }





    /**
     * Switching between tabs
     * @param mixed $tab
     * @return void
     */
    public function switchTab($tab) {

        $this->activeTab = $tab;
        // resetting all varaibles
        $this->resetExcept('activeTab');
        $this->resetPage();
    }



    public function banks(string $tab = 'all-cash-mis') {
        // Main Params to the query
        // Main Params to the query
        $params = [
            'procType' => $tab . '-banks',
            'bankName' => $this->bankName,
            'from' => $this->from,
            'to' => $this->to,
            'page' => $this->page,
            'perpage' => $this->perPage
        ];


        // returns data
        return DB::select('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS :procType, :bankName, :from, :to, :page, :perpage', $params);
    }





    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $bankMIS = $this->allBankMIS();
        $cash_banks = $this->banks('all-cash-mis');
        $card_banks = $this->banks('all-card-mis');
        $wallet_banks = $this->banks('all-wallet-mis');

        // main view
        return view('livewire.commercial-head.reports.bank-m-i-s', [
            'mis' => $bankMIS,
            'cash_banks' => $cash_banks,
            'card_banks' => $card_banks,
            'wallet_banks' => $wallet_banks
        ]);
    }


    /**
     * Date filter
     * @param mixed $obj
     * @return void
     */
    public function filterDates($obj) {
        $this->filtering = true;
        $this->from = $obj['start'];
        $this->to = $obj['end'];
        $this->resetPage();
    }




    /**
     * Export the filtered dataset
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export() {

        $params = [
            'procType' => $this->activeTab . '-export',
            'bankName' => $this->bankName,
            'from' => $this->from,
            'to' => $this->to,
            'page' => $this->page
        ];

        // returns data
        $dataset = DB::select('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS :procType, :bankName, :from, :to, :page', $params);
        return Excel::download(new BankMISExport(collect($dataset), $this->activeTab), 'all_banks_mis_export.xlsx');
    }




    /**
     * Get the main data
     * @return mixed
     */
    public function allBankMIS() {

        // Main Params to the query
        $params = [
            'procType' => $this->activeTab,
            'bankName' => $this->bankName,
            'from' => $this->from,
            'to' => $this->to,
            'page' => $this->page,
            'perpage' => $this->perPage
        ];

        // Paginating the Query
        return DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS :procType, :bankName, :from, :to, :page, :perpage',
            $params
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
    }



    public function loadMore() {
        $this->perPage = $this->perPage + 10;
    }


    /**
     * Render pagination
     * @return string
     */
    public function paginationView() {
        return 'vendor.livewire.bootstrap';
    }
}