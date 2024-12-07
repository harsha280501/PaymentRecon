<?php


namespace App\Interface\Excel;

use Closure;

/**
 * Livewire Page with Tabs
 */
interface WithFormatting {

    /**
     * Summary of generateAndDownload
     * @param array $data
     * @return 
     */
    public function formatter(SpreadSheet $workSheet, $spreadSheet): void;
}