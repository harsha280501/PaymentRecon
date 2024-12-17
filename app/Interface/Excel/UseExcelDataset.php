<?php


namespace App\Interface\Excel;


/**
 * Livewire Page with Tabs
 */
interface UseExcelDataset {

    /**
     * Return the array dataset for the trait to work
     * @return int
     */
    public function download(string $value): \Illuminate\Support\Collection|bool;
}