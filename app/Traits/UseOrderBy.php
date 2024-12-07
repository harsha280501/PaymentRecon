<?php


namespace App\Traits;

use Carbon\Carbon;
use Closure;

/**
 * Livewire Page with Tabs
 */
trait UseOrderBy {

    public $orderBy = 'desc';


    public function orderBy() {
        // assigning the order
        $this->orderBy = $this->orderBy == 'asc' ? 'desc' : 'asc';
    }

    /**
     * Use Order By to fetch the Data
     * @param \Closure $closure
     * @return mixed
     */
    public function withOrderBy(Closure $closure) {
        return call_user_func($closure, $this->orderBy);
    }

}