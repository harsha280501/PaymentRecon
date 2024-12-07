<?php

namespace App\Http\Livewire\Admin\Tracker;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CashReconciliation extends Component {

    use WithPagination;

    public $page = 1;
    public $perPage = 10;


    public $activeTab = 'store2cash';




    public $searchBankName = '';




    public $mainBankNames = [];



    public $hasPagination = ['store2cash', 'cash2bank'];



    protected $queryString = [
        'activeTab' => ['as' => 'tab'],
        'searchString' => ['as' => 's', 'except' => ''],
        'startDate' => ['as' => 'from', 'except' => ''],
        'endDate' => ['as' => 'to', 'except' => ''],
        'brand' => ['as' => 'brand', 'except' => ''],
        'mainStore' => ['as' => 'store', 'except' => ''],
    ];



    public $dateError = false;

    public $searchingFor = 'all';

    public $startDate = null;
    public $endDate = null;


    public $selectedBank = null;


    public $matchStatus = '';



    public $searchString = '';




    public $brands = [];




    public $store = [];


    public $bankNames = [];


    public $filtering = false;


    public $dates;


    public $storeUID;




    public $userUID;




    public $brand = '';



    public $mainStore = '';

    public $search = false;

    public function mount() {
        $this->storeUID = 57109;
        $this->userUID = auth()->user()->userUID;


        $this->resetExcept('activeTab');

        // getting the brand names
        $mainProcType = 'bankNames';
        $mainTab = 'store2cash';
        $mainStartDate = null;
        $mainEndDate = null;
        $mainBrand = '';
        $mainStore = '';
        $mainSearchString = '';
        $mainBank = '';
        $mainMatchStatus = '';
        $mainPageNumber = '';

        $this->mainBankNames = DB::select('EXEC PaymentMIS_PROC_SELECT_ADMIN_CashReconsiliation ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', [
            $mainProcType,
            $mainTab,
            $mainStartDate,
            $mainEndDate,
            $mainBrand,
            $mainStore,
            $mainSearchString,
            $mainBank,
            $mainMatchStatus,
            $mainPageNumber,
            ''
        ]);


        $this->brands = DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => $this->storeUID,
            'userId' => $this->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'brands'
        ]);


        $this->store = DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => $this->storeUID,
            'userId' => $this->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'stores'
        ]);


        // getting the brand names
        $procType = 'banks';
        $tab = 'cash2bank';
        $startDate = null;
        $endDate = null;
        $brand = '';
        $store = '';
        $searchString = '';
        $bank = '';
        $matchStatus = '';
        $pageNumber = '';

        $this->bankNames = DB::select('EXEC PaymentMIS_PROC_SELECT_ADMIN_CashReconsiliation ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', [
            $procType,
            $tab,
            $startDate,
            $endDate,
            $brand,
            $store,
            $searchString,
            $bank,
            $matchStatus,
            $pageNumber,
            ''
        ]);
    }






    public function updated($item) {
        if ($item == 'brand' || $item == 'mainStore' || $item == 'startDate' || $item == 'endDate' || $item == 'selectedBank' || $item == 'matchStatus' || $item == 'searchBankName') {
            $this->searchString = '';
            $this->page = 1;
        }
    }



    public function back() {
        $this->filtering = false;
        $this->emit('resetAll');
        $this->resetExcept(['activeTab']);
    }



    /**
     * Switching between tabs
     * @param mixed $tab
     * @return void
     */
    public function switchTab($tab) {

        $this->page = 1;
        $this->activeTab = $tab;
        $this->resetExcept('activeTab');
        $this->resetPage();
    }



    public function searchFilter($item) {
        $this->filtering = true;
        $this->page = 1;
        $this->searchString = $item;
    }




    /**
     *Filters
     */
    public function filterDate($request) {

        $this->filtering = true;
        $this->page = 1;

        if ($request['start'] == "" || $request['end'] == "") {
            $this->dateError = true;
            return false;
        }

        $this->search = true;
        $this->startDate = $request['start'];
        $this->endDate = $request['end'];

        $this->searchingFor = 'DateRange';
    }



    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        // default data
        $cashRecon = $this->getData();

        return view('livewire.admin.tracker.cash-reconciliation', [
            'cashRecons' => $cashRecon
        ]);
    }






    /**
     * Data source
     * @return LengthAwarePaginator
     */
    public function getData() {
        // Parameters to pass to the Query
        $params = [
            'procType' => 'combined',
            'tab' => $this->activeTab,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'brand' => $this->brand,
            'store' => $this->mainStore,
            'searchString' => $this->searchString,
            'bank' => $this->selectedBank,
            'matchStatus' => $this->matchStatus,
            'pageNumber' => $this->page,
            'bankName' => $this->searchBankName
        ];



        // Procedure Instance
        return DB::paginate(
            storedProcedure: 'PaymentMIS_PROC_SELECT_ADMIN_CashReconsiliation :procType, :tab, :startDate, :endDate, :brand, :store, :searchString, :bank, :matchStatus, :pageNumber, :bankName',
            params: $params,
            pageNumber: $this->page
        );

    }






    /**
     * Render pagination
     * @return string
     */
    public function paginationView() {
        return 'vendor.livewire.bootstrap';
    }
}
