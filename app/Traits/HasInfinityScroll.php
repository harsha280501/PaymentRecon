<?php


namespace App\Traits;


/**
 * Livewire Page with Tabs
 */
trait HasInfinityScroll {


    public $perPage = 30;


    /**
     * Loads more data to the Page
     * @return void
     */
    public function loadMore(): void {
        $this->perPage += 30;
    }

    /**
     * Returns the perpage count
     * @return int
     */
    public function loads(): int {
        return $this->perPage;
    }

}