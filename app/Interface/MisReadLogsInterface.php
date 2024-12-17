<?php


namespace App\Interface;

use Throwable;

/**
 * Livewire Page with Tabs
 */
interface MisReadLogsInterface {






    /**
     * Update the inserted Count
     * @return int
     */
    public function increamentInsertedCount(): bool;



    /**
     * Value to Start From
     * @return int
     */
    public function startFrom(int $start): bool;




    /**
     * Value to Start From
     * @return int
     */
    public function configure(array $configuration): bool;




    /**
     * Value to Start From
     * @return int
     */
    public function skips(int $skips): bool;






    /**
     * Inititializing Log message
     * @return int
     */
    public function initializeLog(): bool;


    /**
     * Inititializing Log message
     * @return int
     */
    public function finializeLog(): bool;


    /**
     * Inititializing Log message
     * @return int
     */
    public function failedLog(Throwable $exception): bool;

}