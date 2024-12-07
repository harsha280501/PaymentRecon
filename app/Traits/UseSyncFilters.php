<?php


namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Livewire Page with Tabs
 */
trait UseSyncFilters {


    /**
     * Brands list
     * @return void
     */
    public $_brands = [];







    /**
     * locations list
     * @return void
     */
    public $_locations = [];









    /**
     * Stores list
     * @var string
     */
    public $_stores = [];









    /**
     * Store Filter
     * @var string
     */
    public $_store = '';









    /**
     * Brand Filter
     * @var string
     */
    public $_brand = '';









    /**
     * Location Filter
     * @var string
     */
    public $_location = '';









    public function _get_dataset(string $type) {
        return $this->filtersSyncDataset(type: $type);
    }







    /**
     * Emitting the main dataset
     * @param mixed $item
     * @return void
     */
    public function updated($item) {
        if (in_array($item, ['_store', '_brand', '_location'])) {
            $this->emit('triggered:change');
            $this->filtering = true;
        }
    }
}