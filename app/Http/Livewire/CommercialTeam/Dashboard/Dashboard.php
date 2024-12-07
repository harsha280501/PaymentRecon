<?php

namespace App\Http\Livewire\CommercialTeam\Dashboard;

use App\Models\Store;
use App\Traits\UseSyncFilters;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component {


    use UseSyncFilters;


    /**
     * isFiltered 
     * @var 
     */
    public $filtering = false;



    /**
     * TenderSelect 
     * @var string
     */
    public $tender_ = 'all';



    /**
     * TimelineSelect
     * @var string
     */
    public $timeline_ = 'ThisYear';




    public $store = '';


    public $brand = '';


    public $location = '';




    /**
     * Startfrom Date
     * @var 
     */
    public $from = null;




    /**
     * End from Date
     * @var 
     */
    public $to = null;







    /**
     * Get the main brand and store
     * @return void
     */
    public $showFullStatsFor = ["Yesterday", "LastWeek"];






    /**
     * Go back
     * @return void
     */
    public function back() {
        $this->reset();
        $this->emit('resetAll');
    }






    /**
     * Summary of _search
     * @param string $storeId
     * @return mixed
     */
    public function _search(string $storeId) {
        return Store::where('Store ID', $storeId)
                ?->first()
                ?->toArray();
    }



    /**
     * FIlter dataset
     *
     * @param array $dataset
     * @return void
     */
    public function filter(array $dataset) {
        $this->timeline_ = $dataset['timeline_'];
        $this->store = $this->_store;
        $this->brand = $this->_brand;
        $this->location = $this->_location;
        $this->tender_ = $dataset['tender_'];
        $this->from = $dataset['from'];
        $this->to = $dataset['to'];
    }





    /**
     * Render the main function
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        return view('livewire.commercial-team.dashboard.dashboard', [
            'dataset_initial' => $this->changeMainStats(),
            's_store' => $this->store ? $this->_search($this->store) : []
        ]);
    }





    public function filtersSyncDataset(string $type) {
        $params = [
            "procType" => $type,
            "store" => $this->_store,
            "brand" => $this->_brand,
            "location" => $this->_location
        ];

        return DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Dashboard_Filters :procType, :store, :brand, :location',
            $params
        );
    }




    /**
     * Fetch main Dataset
     * @param string $procType
     * @return mixed
     */
    public function changeMainStats() {
        return DB::select('PaymentMIS_PROC_COMMERCIALTEAM_SELECT_Dashboard_Summary_Dataset :procType, :storeId, :brand, :location, :timeline, :from, :to', [
            'procType' => $this->tender_,
            'storeId' => $this->store,
            'brand' => $this->brand,
            'location' => $this->location,
            'timeline' => $this->timeline_,
            'from' => $this->from,
            'to' => $this->to,
        ]);
    }
}
