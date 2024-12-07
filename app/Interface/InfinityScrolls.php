<?php


namespace App\Interface;


/**
 * Livewire Page with Tabs
 */
interface InfinityScrolls {

    /**
     * Perpage is required to implement Infinity scroll
     * @return int
     */
    public function perPage(): int;

}