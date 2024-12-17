<?php


namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Livewire Page with Tabs
 */
trait UseDefaults {



    public $filtering = false;




    public $startDate = null;




    public $endDate = null;



    /**
     * Reload the filters
     * @return void
     */
    public function back() {
        $this->emit('resetAll');
        $this->reset();
    }




    /**
     *Filters
     */
    public function filterDate($request) {
        $this->startDate = $request['start'];
        $this->endDate = $request['end'];
        $this->filtering = true;
    }


}