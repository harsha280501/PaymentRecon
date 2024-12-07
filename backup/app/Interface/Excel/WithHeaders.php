<?php


namespace App\Interface\Excel;

use Closure;

/**
 * Livewire Page with Tabs
 */
interface WithHeaders {

    /**
     * Summary of generateAndDownload
     * @param array $data
     * @return 
     */
    public function headers(): array;
}