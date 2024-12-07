<?php


namespace App\Traits;

use Carbon\Carbon;

/**
 * Livewire Page with Tabs
 */
trait UseLocation {




    /**
     * Cities list
     * @return void
     */
    public $cities = [];





    /**
     * Cities list
     * @return void
     */
    public $brands = [];








    /**
     * Data to store city
     * @var string
     */
    public $_city = '';




    /**
     * Data to store brand
     * @var string
     */
    public $_brand = '';




    /**
     * Data to store Location
     * @var string
     */
    public $_location = '';



    /**
     * Select the Dates from the Database
     * @return mixed
     */
    public function updated($el) {
        if ($el == "_city") {
            $this->brands = $this->_brands($this->_city);
        }
    }




    /**
     * Select the Dates from the Database
     * @return mixed
     */
    public function _cities() {
        return \Illuminate\Support\Facades\DB::select('PaymentMIS_PROC_SELECT_Stores_Dataset :procType, :brand, :city, :location', [
            'procType' => 'cities',
            'brand' => $this->_brand,
            'city' => $this->_city,
            'location' => ''
        ]);
    }


    /**
     * Select the Dates from the Database
     * @return mixed
     */
    public function _brands($city = '') {
        return \Illuminate\Support\Facades\DB::select('PaymentMIS_PROC_SELECT_Stores_Dataset :procType, :brand, :city, :location', [
            'procType' => 'brands',
            'brand' => $this->_brand,
            'city' => $city,
            'location' => ''
        ]);
    }



    /**
     * Select the Dates from the Database
     * @return mixed
     */
    public function _location($city = '') {
        return \Illuminate\Support\Facades\DB::select('PaymentMIS_PROC_SELECT_Stores_Dataset :procType, :brand, :city, :location', [
            'procType' => 'location',
            'brand' => $this->_brand,
            'city' => $city,
            'location' => ''
        ]);
    }


    public function _stores() {
        return \Illuminate\Support\Facades\DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => auth()->user()->storeUID,
            'userId' => auth()->user()->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'users-stores'
        ]);
    }

}