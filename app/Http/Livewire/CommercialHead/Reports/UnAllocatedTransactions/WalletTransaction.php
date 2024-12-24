<?php

namespace App\Http\Livewire\CommercialHead\Reports\UnAllocatedTransactions;

use Carbon\Carbon;
use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\ReadsExcel;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\UseDefaults;
use App\Traits\UseMisModels;
use Livewire\WithFileUploads;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\MFLInwardStoreIDMissingTransactions;
use Illuminate\Support\Facades\Log;

class WalletTransaction extends Component {

    use HasInfinityScroll, HasTabs, UseOrderBy, ParseMonths, WithExportDate, UseDefaults, WithFileUploads, ReadsExcel, UseMisModels;





    public $activeTab = 'wallet';






    /**
     * Display error messages in the upload modal
     * @var string
     */
    public $message = '';




    public $location = '';






    protected $queryString = [
        'activeTab' => ['as' => 'tab']
    ];



    public $headers = [];



    public $banks = [];






    public $bank = '';








    /**
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Un_Allocated_Transaction_Wallet';









    /**
     * File to import
     * @var \Illuminate\Http\File
     */
    public $importFile = null;









    /**
     * Resets all the properties
     * @return void
     */
    public function mount() {
        $this->_months = $this->_months()->toArray();
        $this->banks = $this->filters('wallet-banks');
    }











    /**
     * Reload the filters
     * @return void
     */
    public function back() {
        $this->emit('resetAll');
        $this->resetExcept(['banks', 'activeTab']);
    }













    public function headers(): array {
        return [
            "Unique ID",
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "TID",
            "Collection Bank",
            "Store Name",
            "Deposit Amount"
        ];
    }




    public function filters() {
        return DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_StoreID_Missing_Transaction :procType',
            [
                'procType' => 'wallet-banks',
            ]
        );
    }



    public function validateArray(array $data, int $rowNum) {

        // read the file as array
        $validator = Validator::make($data, [
            "Unique ID" => "required",
            "Sales Date" => "required|date",
            "Deposit Date" => "nullable",
            "Store ID" => "required|regex:/^[0-9]{4}$/",
            "Retek Code" => "required|regex:/^[0-9]{5}$/",
            "TID" => "nullable",
            "Store Name" => "nullable",
            "Collection Bank" => "nullable",
            "Deposit Amount" => "nullable",
        ]);




        if ($validator->fails()) {
            $this->message = 'File: Validation Error: ' . $validator->errors()->first() . ' on row number - ' . $rowNum;
            return false;
        }

        return true;
    }






    /**
     * Perform an action when the file is uploadeds
     * @return bool
     */
    public function updatedImportFile() {

        // message to display when the file is uploaded
        $this->message = 'File : Loading ...';

        // save the file and validate
        $filename = $this->importFile->store('un-allocated');
        $file_path = storage_path() . '/app/public/' . $filename;

        $sheet = $this->reader($file_path);
        $this->headers = $sheet[1];
        unset($sheet[1]); // removing the header from the array

        $this->message = 'File: Validating ...';
        $index = 2;

        try {

            // DB::beginTransaction();

            foreach ($sheet as $item) {

                $data = $this->withHeaders($this->headers, $item);

                if (!$this->validateArray($data, $index)) {
                    return false;
                }

                $status = $this->uploadExcelValidatedArray($data);

                if (!$status) {
                    return false;
                }

                $index++;
            }


            // DB::commit();
            $this->emit('file:imported');
            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            $this->message = 'File: Server error ... ' . $th->getMessage() . '- The Data updated by using this file will be reverted back to its original state :)';
            return false;
        }
    }







    /**
     * Update Unallocated Cash Transactions
     * @param array $dataset
     * @return bool
     */
    public function updateUnAllocated(array $dataset): bool {
        // Log the start of the method
        Log::channel('store-missing-transactions')->debug('Starting updateUnAllocated method', ['dataset' => $dataset]);

        // Generate the store ID query
        $_storeID = $this->_generateQuery('wallet', $dataset['bank']);
        $_storeID_found = $_storeID->find($dataset['UID']);

        // Find the main record
        Log::channel('store-missing-transactions')->debug('Looking up MFLInwardStoreIDMissingTransactions', ['itemID' => $dataset['itemID']]);
        $_main = MFLInwardStoreIDMissingTransactions::find($dataset['itemID']);

        // Check if the main record exists
        if (!$_main->exists()) {
            Log::channel('store-missing-transactions')->warning('Record not found', ['itemID' => $dataset['itemID']]);
            $this->emit('unallocated:failed', 'Unable to Find the Record');
            return false;
        }

        // Fetch the brand for the store
        Log::channel('store-missing-transactions')->debug('Fetching brand for store', ['storeID' => $dataset['storeID']]);
        $brand = \App\Models\Store::where('Store ID', $dataset['storeID'])
                ?->first()
            ?->{'Brand Desc'};

        // Start transaction
        DB::beginTransaction();

        try {
            // Update the main transaction record
            Log::channel('store-missing-transactions')->info('Updating main transaction record', [
                'itemID' => $dataset['itemID'],
                'update_data' => [
                    "storeID" => $dataset['storeID'],
                    "retekCode" => $dataset['retekCode'],
                    "brand" => $brand,
                    "salesDate" => $dataset['salesDate'],
                    "missingRemarks" => 'Valid',
                    "unAllocatedStatus" => 'Valid',
                    "unAllocatedRemarks" => $dataset['remarks'],
                    "unAllocatedCorrectionDate" => now(),
                    'isActive' => '1'
                ]
            ]);

            $_main->update([
                "storeID" => $dataset['storeID'],
                "retekCode" => $dataset['retekCode'],
                "brand" => $brand,
                "salesDate" => $dataset['salesDate'],
                "missingRemarks" => 'Valid',
                "unAllocatedStatus" => 'Valid',
                "unAllocatedRemarks" => $dataset['remarks'],
                "unAllocatedCorrectionDate" => now(),
                'isActive' => '1'
            ]);

            // Update the store ID record
            Log::channel('store-missing-transactions')->info('Updating storeID record', [
                'UID' => $dataset['UID'],
                'update_data' => [
                    "storeID" => $dataset['storeID'],
                    "retekCode" => $dataset['retekCode'],
                    "brand" => $brand,
                    "missingRemarks" => 'Valid',
                    "unAllocatedStatus" => 'Valid',
                    "unAllocatedRemarks" => $dataset['remarks'],
                    "unAllocatedCorrectionDate" => now(),
                    'isActive' => '1'
                ]
            ]);

            $_storeID_found->update([
                "storeID" => $dataset['storeID'],
                "retekCode" => $dataset['retekCode'],
                "brand" => $brand,
                "missingRemarks" => 'Valid',
                "unAllocatedStatus" => 'Valid',
                "unAllocatedRemarks" => $dataset['remarks'],
                "unAllocatedCorrectionDate" => now(),
                'isActive' => '1'
            ]);

        } catch (\Throwable $th) {
            Log::channel('store-missing-transactions')->error('Transaction update failed', ['error' => $th->getMessage()]);
            DB::rollBack();
            $this->emit('unallocated:failed', $th->getMessage());
            return false;
        }

        DB::commit();
        Log::channel('store-missing-transactions')->info('Unallocated cash transactions updated successfully', ['itemID' => $dataset['itemID']]);
        $this->emit('unallocated:success');
        return true;
    }


    /**
     * Save the data to a file
     * @param array $dataset
     * @return bool
     */
    public function uploadExcelValidatedArray(array $dataset) {
        // Log the start of the method
        Log::channel('store-missing-transactions')->debug('Starting uploadExcelValidatedArray method', ['dataset' => $dataset]);

        // Find the main record
        $_main = MFLInwardStoreIDMissingTransactions::find($dataset['Unique ID']);
        Log::channel('store-missing-transactions')->debug('Looking up MFLInwardStoreIDMissingTransactions', ['Unique ID' => $dataset['Unique ID']]);

        // Find the store ID
        $_storeID = $this->_generateQuery('wallet', $dataset['Collection Bank']);
        $_storeID_found = $_storeID->find($_main->UID);

        // Fetch the brand
        $brand = \App\Models\Store::where('Store ID', $dataset['Store ID'])
                ?->first()
            ?->{'Brand Desc'};

        // Check if the main record exists
        if (!$_main->exists()) {
            Log::channel('store-missing-transactions')->warning('Main record not found', ['Unique ID' => $dataset['Unique ID']]);
            $this->message = 'File: Not Allowed - Updating the Unique ID will result in a potential data loss, this incident will be reported :)';
            return false;
        }

        // Check if the store ID is not null
        if ($_main->replicate()->storeID != null) {
            Log::channel('store-missing-transactions')->warning('Store ID update attempt when not empty', [
                'Unique ID' => $dataset['Unique ID'],
                'currentStoreID' => $_main->replicate()->storeID
            ]);
            $this->message = 'File: Not Allowed - Updating the Store ID when its not empty is not allowed, this incident will be reported :)';
            return false;
        }

        // If not null, then update the item using the unique ID field
        Log::channel('store-missing-transactions')->info('Updating main transaction record', [
            'Unique ID' => $dataset['Unique ID'],
            'update_data' => [
                "storeID" => $dataset['Store ID'],
                "retekCode" => $dataset['Retek Code'],
                "salesDate" => Carbon::parse($dataset['Sales Date'])->format('Y-m-d'),
                "missingRemarks" => 'Valid',
                "unAllocatedStatus" => 'Valid',
                "unAllocatedRemarks" => "Imported by Excel",
                "unAllocatedCorrectionDate" => now(),
                'isActive' => '1'
            ]
        ]);

        $res = $_main->update([
            "storeID" => $dataset['Store ID'],
            "retekCode" => $dataset['Retek Code'],
            "salesDate" => Carbon::parse($dataset['Sales Date'])->format('Y-m-d'), // Parsing and formatting 
            "missingRemarks" => 'Valid',
            "unAllocatedStatus" => 'Valid',
            "unAllocatedRemarks" => "Imported by Excel",
            "unAllocatedCorrectionDate" => now(),
            'isActive' => '1'
        ]);

        Log::channel('store-missing-transactions')->info('Updating storeID record', [
            'UID' => $_main->UID,
            'update_data' => [
                "storeID" => $dataset['Store ID'],
                "retekCode" => $dataset['Retek Code'],
                "brand" => $brand,
                "missingRemarks" => 'Valid',
                "unAllocatedStatus" => 'Valid',
                "unAllocatedRemarks" => "Imported by Excel",
                "unAllocatedCorrectionDate" => now()->format('Y-m-d'),
                'isActive' => '1'
            ]
        ]);

        $_storeID_found->update([
            "storeID" => $dataset['Store ID'],
            "retekCode" => $dataset['Retek Code'],
            "brand" => $brand,
            "missingRemarks" => 'Valid',
            "unAllocatedStatus" => 'Valid',
            "unAllocatedRemarks" => "Imported by Excel",
            "unAllocatedCorrectionDate" => now()->format('Y-m-d'),
            'isActive' => '1'
        ]);

        Log::channel('store-missing-transactions')->info('Successfully uploaded Excel validated array', ['Unique ID' => $dataset['Unique ID']]);
        return $res;
    }




    /**
     * Export functionality
     * @return void
     */
    public function export($dataset = [], $all = '') {


        $data = $this->download(!$all ? json_encode($dataset) : json_encode([]));
        $headers = $this->headers();

        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }

        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists

        fputcsv($file, $headers); // adding headers to the excel

        foreach ($data as $row) {
            $row = (array) $row;
            fputcsv($file, $row);
        }

        fclose($file);

        return response()->stream(
            function () use ($filePath) {
                echo file_get_contents($filePath);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '"',
            ]
        );
    }







    public function download($value = ''): \Illuminate\Support\Collection|bool {

        $params = [
            'procType' => 'wallet-export',
            'bank' => $this->bank,
            'location' => $this->location,
            'selection' => $value,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_StoreIDMissingTransactions :procType, :bank, :location, :selection, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }











    /**
     * Get the total Records
     *
     * @return Collection|array
     */
    public function getTotals(): Collection|array {
        $params = [
            'procType' => $this->activeTab . '-totals',
            'bank' => $this->bank,
            'location' => $this->location,
            'selection' => null,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_StoreIDMissingTransactions :procType, :bank, :location, :selection, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }












    /**
     * Dataset for the screen
     * @return Collection
     */
    public function dataset() {

        $params = [
            'procType' => $this->activeTab,
            'bank' => $this->bank,
            'location' => $this->location,
            'selection' => null,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return \Illuminate\Support\Facades\DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_StoreIDMissingTransactions :procType, :bank, :location, :selection, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }









    /**
     * Render main content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->dataset();

        return view('livewire.commercial-head.reports.un-allocated-transactions.wallet-transaction', [
            'dataset' => $dataset,
            'selectionHas' => $dataset->pluck('storeMissingUID'),
            'totals' => $this->getTotals()
        ]);
    }

}
