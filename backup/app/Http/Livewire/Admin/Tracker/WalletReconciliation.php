<?php

namespace App\Http\Livewire\Admin\Tracker;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class WalletReconciliation extends Component {


    use WithPagination;



    /**
     * Listening for events
     * @var array
     */
    protected $listeners = [];




    /**
     * Pagination: Page nuber
     * @var int
     */
    public $page = 1;




    /**
     * Pagination: Per page
     * @var int
     */
    public $perPage = 10;




    /**
     * searching for something
     * @var
     */
    public $filtering = false;





    /**
     * What are you looking for?
     * @var string
     */
    public $searchingFor = 'combined';





    /**
     * Default data for brands
     * @var array
     */
    public $brands = [];





    /**
     * Defualt data for search
     * @var array
     */
    public $store = [];





    /**
     * Default  value for Deposit date
     * @var array
     */
    public $deptDt = [];




    /**
     * Default value for banks
     * @var array
     */
    public $bank = [];






    /**
     * Data renderign ti the view
     * @var
     */
    public $dates;





    /**
     * Store UID to PASS
     * @var
     */
    public $storeUID;




    /**
     * User UID to pass
     * @var
     */
    public $userUID;





    /**
     * Get active tab
     * @var string
     */
    public $activeTab = 'store2wallet';






    /**
     * Pagination appears only to tabs inside this array
     * @var array
     */
    public $hasPagination = ['store2wallet', 'wallet2bank'];





    /**
     * Quering the search url
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 'tab'],
        'searchString' => ['as' => 's', 'except' => ''],
        'startDate' => ['as' => 'from', 'except' => ''],
        'endDate' => ['as' => 'to', 'except' => ''],
        'brand' => ['as' => 'brand', 'except' => ''],
        'mainStore' => ['as' => 'store', 'except' => ''],
    ];





    /**
     * Searhc by brand
     * @var
     */
    public $brand = '';






    /**
     * Search for Store
     * @var
     */
    public $mainStore = '';





    /**
     * Filter by deposit date
     * @var
     */
    public $mainDeptDT = '';





    /**
     * bank Mane to search for
     * @var
     */
    public $mainBank = '';




    /**
     * Search keyword
     * @var
     */
    public $searchString = '';




    /**
     * Start Date to search for
     * @var
     */
    public $startDate = null;




    /**
     * End Date to search for
     * @var
     */
    public $endDate = null;






    /**
     * Loading bank Names
     * @var array
     */
    public $bankNames = [];



    public $mainBankNames = [];



    public $selectedBank = '';




    public $matchStatus = '';




    public $searchBankName = '';




    /**
     * Resets the search whenever
     * the values oof the proterties changes
     * @var array
     */
    protected $resetSearchFilterFor = ['brand', 'mainStore', 'startDate', 'endDate', 'mainDeptDT', 'selectedBankName'];






    /**
     * Initializ the component
     * @return void
     */
    public function mount() {

        // Assign value for store UID and UserUID
        $this->storeUID = 57109;
        $this->userUID = auth()->user()->userUID;


        $this->resetExcept('activeTab');
        $this->resetPage();


        $this->deptDt = collect(DB::select('PaymentMIS_PROC_SELECT_ADMIN_WalletReconciliation :procType, :tab, :startDate, :endDate, :brand, :store, :depositDate, :searchString, :matchStatus, :bankName, :PageNumber, :mainBank', [
            'procType' => 'depositDate',
            'tab' => 'store2wallet',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'brand' => $this->brand,
            'store' => $this->mainStore,
            'depositDate' => '',
            'searchString' => '',
            'matchStatus' => '',
            'bankName' => $this->selectedBank,
            'PageNumber' => $this->page,
            'mainBank' => ''
        ]));




        $this->mainBankNames = collect(DB::select('PaymentMIS_PROC_SELECT_ADMIN_WalletReconciliation :procType, :tab, :startDate, :endDate, :brand, :store, :depositDate, :searchString, :matchStatus, :bankName, :PageNumber, :mainBank', [
            'procType' => 'mainBankNames',
            'tab' => 'store2wallet',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'brand' => $this->brand,
            'store' => $this->mainStore,
            'depositDate' => '',
            'searchString' => '',
            'matchStatus' => '',
            'bankName' => $this->selectedBank,
            'PageNumber' => $this->page,
            'mainBank' => ''
        ]));



        // Getting the starting data for brands
        $this->brands = DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => $this->storeUID,
            'userId' => $this->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'brands'
        ]);



        // Defualt data for Store
        $this->store = DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => $this->storeUID,
            'userId' => $this->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'stores'
        ]);



        $this->bankNames = $this->bankNames();
    }







    /**
     * Render the page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $cashRecon = $this->getData();

        return view('livewire.admin.tracker.wallet-reconciliation', [
            'cashRecons' => $cashRecon,
        ]);
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
    }







    /**
     * Dinstint selected bank names
     * @return array
     */
    protected function bankNames(): array {
        return DB::select('PaymentMIS_PROC_SELECT_ADMIN_WalletReconciliation :procType, :tab, :startDate, :endDate, :brand, :store, :depositDate, :searchString, :matchStatus, :bankName, :PageNumber, :mainBank', [
            'procType' => 'banks',
            'tab' => 'wallet2bank',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'brand' => $this->brand,
            'store' => $this->mainStore,
            'depositDate' => $this->mainDeptDT,
            'searchString' => $this->searchString,
            'matchStatus' => '',
            'bankName' => $this->selectedBank,
            'PageNumber' => $this->page,
            'mainBank' => ''
        ]);
    }






    /**
     * Summary of searchFilter
     * @param mixed $item
     * @return void
     */
    public function searchFilter($item) {

        $this->filtering = true;
        $this->searchString = $item;
        $this->resetPage();

    }





    /**
     * Reload the filters
     * @return void
     */
    public function back() {
        $this->emit('resetAll');
        $this->resetExcept('activeTab');
    }






    /**
     * Side effects
     * @param mixed $item
     * @return void
     */
    public function updated($item) {

        if (in_array($item, $this->resetSearchFilterFor)) {
            $this->page = 1;
            $this->searchString = '';
            $this->filtering = true;
        }
    }




    /**
     *Filters
     */
    public function filterDate($request) {
        $this->resetPage();
        $this->startDate = $request['start'];
        $this->endDate = $request['end'];
        $this->filtering = true;
    }






    /**
     * Data source
     * @return LengthAwarePaginator
     */
    public function getData() {

        $params = [
            'procType' => 'combined',
            'tab' => $this->activeTab,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'brand' => $this->brand,
            'store' => $this->mainStore,
            'depositDate' => $this->mainDeptDT,
            'searchString' => $this->searchString,
            'matchStatus' => $this->matchStatus,
            'bankName' => $this->selectedBank,
            'PageNumber' => $this->page,
            'mainBank' => $this->selectedBank
        ];


        return DB::paginate(
            storedProcedure: 'PaymentMIS_PROC_SELECT_ADMIN_WalletReconciliation :procType, :tab, :startDate, :endDate, :brand, :store, :depositDate, :searchString, :matchStatus, :bankName, :PageNumber, :mainBank',
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
