<?php

namespace App\Http\Livewire\AreaManager\Tracker;


use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


/*
|--------------------------------------------------------------------------
| CardReconciliation Livewire Component
|--------------------------------------------------------------------------
|
| Handles card reconciliation data for the commercial head's dashboard.
| This component interacts with the database to fetch card reconciliation data,
| paginates the results, and provides filtering and search functionalities.
|
*/


class CardReconciliation extends Component {

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
     * Resets the search whenever
     * the values oof the proterties changes
     * @var array
     */
    protected $resetSearchFilterFor = ['brand', 'mainStore', 'startDate', 'endDate', 'mainDeptDT', 'selectedBankName'];






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
     * Get active tab, the defualt tab to load
     * @var string
     */
    public $activeTab = 'store2card';






    /**
     * Pagination appears only to tabs inside this array
     * @var array
     */
    public $hasPagination = ['store2card', 'card2bank'];






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
     * Main bank names for Store2Card
     * @var
     */
    public $mainBankNames = [];





    /**
     * Default value for banks
     * @var array
     */
    public $bank = [];






    /**
     * Loading bank Names
     * @var array
     */
    public $bankNames = [];







    /**
     * Data renderign ti the view
     * @var
     */
    public $dates;





    /**
     * Search for specific bank
     * @var string
     */
    public $searchBankName = '';







    /**
     * Matched or notMatched
     * @var
     */
    public $matchStatus = '';






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







    public $selectedBank = null;







    /**
     * Starting
     * @return void
     */
    public function mount() {

        // Assign value for store UID and UserUID
        $this->storeUID = 57109;
        $this->userUID = auth()->user()->userUID;

        // Resetting the values on reload
        // $this->resetExcept('activeTab');

        $this->resetPage();


        // fetching the deposit dates
        $this->deptDt = $this->depositDates();


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


        // getting the bank names
        $this->bankNames = $this->bankNames();

        // get bankNames for main page
        $this->mainBankNames = $this->getMainBankNames();

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
     * Reload the filters
     * @return void
     */
    public function back() {
        $this->emit('resetAll');
        $this->resetExcept('activeTab');
    }






    /**
     * Fetcvvch the deposit dates
     * @return array
     */

    protected function depositDates(): array {

        return DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_CardReconciliation :procType, :tab, :startDate, :endDate, :brand, :store, :depositDate, :searchString, :bank, :matchStatus, :PageNumber, :mainBank', [
            'procType' => 'depositDate',
            'tab' => 'store2card',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'brand' => $this->brand,
            'store' => $this->mainStore,
            'depositDate' => '',
            'searchString' => '',
            'bank' => '',
            'matchStatus' => '',
            'PageNumber' => $this->page,
            'mainBank' => ''
        ]);
    }






    /**
     * Dinstint selected bank names
     * @return array
     */
    protected function bankNames(): array {
        return DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_CardReconciliation :procType, :tab, :startDate, :endDate, :brand, :store, :depositDate, :searchString, :bank, :matchStatus, :PageNumber, :mainBank', [
            'procType' => 'banks',
            'tab' => 'card2bank',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'brand' => $this->brand,
            'store' => $this->mainStore,
            'depositDate' => '',
            'searchString' => '',
            'bank' => $this->selectedBank,
            'matchStatus' => $this->matchStatus,
            'PageNumber' => $this->page,
            'mainBank' => ''
        ]);
    }




    /**
     * Dinstint selected bank names
     * @return array
     */
    protected function getMainBankNames(): array {
        return DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_CardReconciliation :procType, :tab, :startDate, :endDate, :brand, :store, :depositDate, :searchString, :bank, :matchStatus, :PageNumber, :mainBank', [
            'procType' => 'mainBankNames',
            'tab' => 'store2card',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'brand' => $this->brand,
            'store' => $this->mainStore,
            'depositDate' => '',
            'searchString' => '',
            'bank' => $this->selectedBank,
            'matchStatus' => $this->matchStatus,
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
        // resetting the page to 1
        $this->resetPage();
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
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        // fetching the data
        $cashRecon = $this->getData();

        return view('livewire.area-manager.tracker.card-reconciliation', [
            'cashRecons' => $cashRecon,
        ]);
    }







    /**
     * Data source
     * @return LengthAwarePaginator
     */
    public function getData() {

        // values for stored Procedure
        $params = [
            'procType' => 'combined',
            'tab' => $this->activeTab,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'brand' => $this->brand,
            'store' => $this->mainStore,
            'depositDate' => $this->mainDeptDT,
            'searchString' => $this->searchString,
            'bank' => $this->selectedBank,
            'matchStatus' => $this->matchStatus,
            'PageNumber' => $this->page,
            'mainBank' => $this->searchBankName
        ];

        // Paginating the DB Query
        return DB::paginate(
            storedProcedure: 'PaymentMIS_PROC_SELECT_AREAMANAGER_CardReconciliation :procType, :tab, :startDate, :endDate, :brand, :store, :depositDate, :searchString, :bank, :matchStatus, :PageNumber, :mainBank',
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
