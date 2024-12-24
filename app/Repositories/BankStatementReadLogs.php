<?php

namespace App\Repositories;

use App\Interface\BankStatementReadLogsInterface;
use App\Models\Logs\UploadLog;
use Throwable;

class BankStatementReadLogs implements BankStatementReadLogsInterface {


    /**
     * Monitor the inserted count
     * @var int
     */
    public $insertedRowCount = 0;


    /**
     * Set Start from
     * @var int
     */
    public $startFrom = 0;


    /**
     * Default values
     * @var 
     */
    protected $filename = null;


    /**
     * Summary of table
     * @var 
     */
    protected $table = null;


    /**
     * Assigning the bank name
     * @var 
     */
    protected $bank = null;


    /**
     * Dataset
     * @var array
     */
    protected $dataset = [];


    /**
     * Skips
     * @var array
     */
    protected $skips = 0;







    /**
     * Increment the Count on a loop
     * @param int $value
     * @return bool
     */
    public function increamentInsertedCount(): bool {
        $this->insertedRowCount++;
        return true;
    }




    /**
     * Set the "Start the counter from"
     * @param int $start
     * @return bool
     */
    public function startFrom(int $start): bool {
        $this->startFrom = $start;
        return true;
    }






    /**
     * Setting the configuration values
     * @param array $configuration
     * @return bool
     */
    public function configure(array $configuration): bool {
        $this->bank = $configuration['bank'];
        $this->table = $configuration['table'];
        $this->dataset = $configuration['dataset'];
        $this->filename = $configuration['filename'];

        return true;
    }






    /**
     * Get the Last Index of the Dataset
     * @param array $configuration
     * @return bool
     */
    public function getLastRecord(): int {
        return ($this->insertedRowCount - 1) + $this->skips;
    }



    /**
     * get the First index of the dataset with skips
     * @param array $configuration
     * @return bool
     */
    public function getFirstRecord(): int {
        return $this->startFrom + $this->skips;
    }





    /**
     * Get the Prevois inserted Row
     * @param array $configuration
     * @return bool
     */
    public function getPreviousInsertedRecord(): int {
        return (($this->insertedRowCount + $this->skips) - 1) > 0 ? $this->insertedRowCount - 1 : $this->insertedRowCount;
    }




    /**
     * Skips few known empty lines
     * @param array $configuration
     * @return bool
     */
    public function skips(int $skips): bool {
        $this->skips = $skips;
        return true;
    }





    /**
     * Read inserted Row count with skips
     * @param array $configuration
     * @return bool
     */
    public function withSkips(): int {
        return $this->insertedRowCount + $this->skips;
    }




    /**
     * Get index of Failed Value
     * @param array $configuration
     * @return bool
     */
    public function getFailedRecord(): int {
        return $this->insertedRowCount + $this->skips;
    }



    /**
     * Create a Initialized log record to mention that the upload is started
     * @return boolean
     */
    public function initializeLog(): bool {
        // setting the inserted count to 0
        $this->insertedRowCount = $this->startFrom + $this->skips;

        // creating log 
        UploadLog::create([
            'logType' => 'Initializing MIS Upload',
            'bankName' => $this->bank,
            'fileName' => $this->filename,
            'uploadTableName' => $this->table,
            'totalRecordCount' => count($this->dataset),
            'startingRecord' => json_encode($this->dataset[$this->insertedRowCount]),
            'status' => 'Pending',
            'uploadedAt' => now()->format('Y-m-d h:m:s'),
        ]);
        // returning a boolean indicating the creating is completed
        return true;
    }



    /**
     * Write a Log to the Database to indicate that the Upload is completed 
     * @return boolean
     */

    public function finializeLog(): bool {
        // getting the final line
        $finalLine = $this->dataset[$this->getLastRecord()];

        // creating log 
        UploadLog::create([
            'logType' => 'Finalizing Mis Upload',
            'bankName' => $this->bank,
            'fileName' => $this->filename,
            'uploadTableName' => $this->table,
            'totalRecordCount' => count($this->dataset),
            'startingRecord' => json_encode($this->dataset[$this->startFrom]),
            'completedCount' => $this->insertedRowCount,
            'endingRecord' => json_encode($finalLine),
            'status' => 'Successful',
            'uploadedAt' => now()->format('Y-m-d h:m:s'),
        ]);
        // returning a boolean indicating the creating is completed
        return true;
    }

    /**
     * Write a Log to the DB to indicate that the upload has failed
     * @return boolean
     */
    public function failedLog(Throwable $exception): bool {
        // getting the final line
        $errorLine = $this->dataset[$this->getFailedRecord()];
        $finalLine = ($this->dataset[$this->getLastRecord()]);

        // creating log 
        UploadLog::create([
            'logType' => 'Failed Mis Upload',
            'bankName' => $this->bank,
            'fileName' => $this->filename,
            'uploadTableName' => $this->table,
            'totalRecordCount' => count($this->dataset),
            'startingRecord' => json_encode($this->dataset[$this->startFrom]),
            'endingRecord' => json_encode($finalLine),
            'status' => 'Failed',
            'completedCount' => $this->insertedRowCount,
            'isError' => true,
            'errorAt' => json_encode($errorLine),
            'errorMessage' => $exception->getMessage(),
            'uploadedAt' => now()->format('Y-m-d h:m:s'),
        ]);

        // returning a boolean indicating the creating has failed
        return true;
    }
}