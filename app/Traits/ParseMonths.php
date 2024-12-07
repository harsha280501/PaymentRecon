<?php


namespace App\Traits;

use Carbon\Carbon;

/**
 * Livewire Page with Tabs
 */
trait ParseMonths {




    /*
    |--------------------------------------------------------------------------
    | _months Filter for Alpine js
    |--------------------------------------------------------------------------
    |
    | This Property is accessable anywhere in the livewire conponent
    | Provides a more elegant way to reuse the component
    */
    public $_months = [];




    /*
    |--------------------------------------------------------------------------
    | Livewire method
    |--------------------------------------------------------------------------
    |
    | This Property is accessable anywhere in the livewire conponent
    | Provides a more elegant way to reuse the component
    */
    public function mount() {
        $this->_months = $this->_months()->toArray();
    }


    /**
     * Select the Dates from the Database
     * @return mixed
     */
    public function _getMonthsForDateAndMonthFilter() {
        return \App\Models\Masters\DateForMonths::orderBy('order', 'desc')
            ->where('isActive', true)
            ->get();
    }

    /**
     * Select the Dates from the Database
     * @return mixed
     */
    public function _months() {
        return $this->_getMonthsForDateAndMonthFilter();
    }

    public function _end(string $start) {
        $date_ = Carbon::parse($start);
        return $date_->endOfMonth()->format('Y-m-d');
    }
}
