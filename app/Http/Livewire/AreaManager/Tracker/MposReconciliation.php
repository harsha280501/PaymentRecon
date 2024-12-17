<?php

namespace App\Http\Livewire\AreaManager\Tracker;

use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\HasInfinityScroll;

use Illuminate\Support\Facades\DB;


class MposReconciliation extends Component {

    use HasInfinityScroll, HasTabs;


    public $filtering = false;


    public $searchString = '';


    public $startDate = null;


    public $endDate = null;


    public $activeTab = 'mposbankrecon';

    public $storeUID;

    public $userUID;

    public $matchStatus = '';

    public $bank = '';
    public $bank1 = '';
    public $banks = [];
    public $banks2 = [];
    public $banks3 = [];
    public $mainStore = '';




    /**
     * Pagination appears only to tabs inside this array
     * @var array
     */
    public $hasPagination = ['mposbankrecon', 'mposmisrecon', 'mposcardrecon', 'mposwalletrecon', 'mposaprecon', 'mpossapcardrecon'];


    /**
     * Quering the search url
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 'tab'],
        'searchString' => ['as' => 's', 'except' => ''],
        'startDate' => ['as' => 'from', 'except' => ''],
        'endDate' => ['as' => 'to', 'except' => ''],

    ];


    /**
     * Resets the search whenever
     * the values oof the proterties changes
     * @var array
     */
    protected $resetSearchFilterFor = ['mainStore', 'startDate', 'endDate'];

    public $stores = [];
    public $storesOne = [];
    public $storesTwo = [];
    public $storesThree = [];
    public $storesFour = [];
    public $storesFive = [];

    public $codes = [];
    public $codesOne = [];
    public $codesTwo = [];
    public $codesThree = [];
    public $codesFour = [];
    public $codesFive = [];

    public $store = '';
    public $code = '';



    /**
     * Initializ the component
     * @return void
     */
    public function mount() {

        $this->storeUID = 57109;
        $this->userUID = auth()->user()->userUID;

        $this->resetExcept('activeTab');

        $this->stores = $this->stores('mposbankrecon');
        $this->storesOne = $this->stores('mposmisrecon');
        $this->storesTwo = $this->stores('mposcardrecon');
        $this->storesThree = $this->stores('mposwalletrecon');
        $this->storesFour = $this->stores('mposwalletrecon');
        $this->storesFive = $this->stores('mpossaprecon');

        $this->codes = $this->codes('mposbankrecon');
        $this->codesOne = $this->codes('mposmisrecon');
        $this->codesTwo = $this->codes('mposcardrecon');
        $this->codesThree = $this->codes('mposwalletrecon');
        $this->codesFour = $this->codes('mposwalletrecon');
        $this->codesFive = $this->codes('mpossaprecon');

        $this->banks = $this->banks('mposcardrecon');
        $this->banks2 = $this->banks('mposwalletrecon');
        $this->banks3 = $this->banks('mpossapcardrecon');
    }


    public function render() {
        $cashRecon = $this->getData();

        //dd($this->getData());
        return view('livewire.area-manager.tracker.mpos-reconciliation', [
            'cashRecons' => $cashRecon,
        ]);
    }


    protected function stores($tab) {


        return DB::infinite('PaymentMIS_PROC_SELECT_AREA_MANAGER_MposReconciliation :procType,:startDate, :endDate, :store,:searchString,:retekcode,:matchStatus,:bank', [
            'procType' => $tab . '-stores',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'store' => $this->mainStore,
            'searchString' => $this->searchString,
            'retekcode' => $this->code,
            'matchStatus' => '',
            'bank' => ''

        ], perPage: $this->perPage);
    }

    protected function codes($tab) {
        return DB::infinite('PaymentMIS_PROC_SELECT_AREA_MANAGER_MposReconciliation :procType,:startDate, :endDate,:store,:searchString,:retekcode,:matchStatus,:bank', [
            'procType' => $tab . '-codes',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'store' => $this->mainStore,
            'searchString' => $this->searchString,
            'retekcode' => $this->code,
            'matchStatus' => '',
            'bank' => ''

        ], perPage: $this->perPage);
    }


    protected function banks($tab) {

        return DB::infinite('PaymentMIS_PROC_SELECT_AREA_MANAGER_MposReconciliation :procType,:startDate, :endDate,:store,:searchString,:retekcode,:matchStatus,:bank', [
            'procType' => $tab . '-banks',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'store' => $this->mainStore,
            'searchString' => $this->searchString,
            'retekcode' => $this->code,
            'matchStatus' => '',
            'bank' => $this->bank

        ], perPage: $this->perPage);
    }


    /**
     * Summary of searchFilter
     * @param mixed $item
     * @return void
     */
    public function searchFilter($item) {
        $this->filtering = true;
        $this->searchString = $item;
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
            $this->searchString = '';
            $this->filtering = true;
        }
    }




    /**
     *Filters
     */
    public function filterDate($request) {
        $this->startDate = $request['start'];
        $this->endDate = $request['end'];
        $this->filtering = true;
    }



    /**
     * Data source
     * @return array
     */
    public function getData() {

        // dd($this);

        $params = [
            'procType' => $this->activeTab,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'store' => $this->store,
            'searchString' => $this->searchString,
            'retekcode' => $this->code,
            'matchStatus' => $this->matchStatus,
            'bank' => $this->bank

        ];


        return DB::infinite(
            'PaymentMIS_PROC_SELECT_AREA_MANAGER_MposReconciliation :procType,:startDate, :endDate,:store,:searchString,:retekcode,:matchStatus,:bank',
            $params,
            perPage: $this->perPage
        );
    }
}