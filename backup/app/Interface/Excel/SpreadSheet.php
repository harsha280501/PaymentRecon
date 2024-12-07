<?php


namespace App\Interface\Excel;

use Closure;

/**
 * Livewire Page with Tabs
 */
interface SpreadSheet {

    /**
     * Summary of generateAndDownload
     * @param array $data
     * @return 
     */
    public function setStartFrom(int $int): void;

    /**
     * Summary of generateAndDownload
     * @param array $data
     * @return 
     */
    public function setFilename(string $filename): void;

    /**
     * Summary of generateAndDownload
     * @param array $data
     * @return 
     */
    public function generateAndDownload(array $data);
}