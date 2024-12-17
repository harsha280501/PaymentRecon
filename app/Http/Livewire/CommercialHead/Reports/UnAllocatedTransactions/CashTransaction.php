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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\MFLInwardStoreIDMissingTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File as FacadesFile;

class CashTransaction extends Component
{

    use HasInfinityScroll, HasTabs, UseOrderBy, ParseMonths, WithExportDate, UseDefaults, WithFileUploads, ReadsExcel, UseMisModels;





    /**
     * Current Tab name
     * Used to identify the tab when the route hits this endpoint
     * required function
     * @var string
     */
    public $activeTab = 'cash';












    /**
     * Display the active tab on the browser
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 'tab']
    ];











    /**
     * Display error messages in the upload modal
     * @var string
     */
    public $message = '';












    /**
     * File to import
     * @var FacadesFile
     */
    public $importFile = null;









    /**
     * Import Headers
     * @var array
     */
    public $headers = [];







    /**
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Un_Allocated_Transaction_Cash';


    /**
     * Bank names for the filters
     * @var array
     */
    public $banks = [];


    /**
     * Bank name for the filter
     * @var string
     */
    public $bank = '';






    /**
     * Location for the filter
     * @var string
     */
    public $location = '';










    /**
     * Resets all the properties
     * @return void
     */
    public function mount()
    {
        $this->_months = $this->_months()->toArray();
        $this->banks = $this->filters('cash-banks');
    }





    /**
     * Reload the filters
     * @return void
     */
    public function back() {
        $this->emit('resetAll');
        $this->resetExcept(['banks', 'activeTab']);
    }





    /**
     * Perform an action when the file is uploadeds
     * @return bool
     */
    public function updatedImportFile()
    {

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






    public function validateArray(array $data, int $rowNum)
    {

        // read the file as array
        $validator = Validator::make($data, [
            "Unique ID" => "required",
            "Store ID" => "required|regex:/^[0-9]{4}$/",
            "Retek Code" => "required|regex:/^[0-9]{5}$/",
            "Sales Date" => "required|date",
            "Deposit Date" => "nullable",
            "Collection Bank" => "nullable",
            "Location" => "nullable",
            "Deposit Slip No" => "nullable",
            "Deposit Amount" => "nullable",
            "Pickupt Code" => "nullable",
        ]);


        if ($validator->fails()) {
            $this->message = 'File: Validation Error: ' . $validator->errors()->first() . ' on row number - ' . $rowNum;
            return false;
        }

        return true;
    }






    /**
     * Update Unallocated Cash Transactions
     * @param array $dataset
     * @return bool
     */
    public function updateUnAllocated(array $dataset): bool
    {


        $_storeID = $this->_generateQuery('cash', $dataset['bank']);
        $_storeID_found =  $_storeID->find($dataset['UID']);

      

        $_main = MFLInwardStoreIDMissingTransactions::find($dataset['itemID']);

        if (!$_main->exists()) {
            $this->emit('unallocated:failed', 'Unable to Find the Record');
            return false;
        }

        // find the item in store master
        $brand = \App\Models\Store::where('Store ID', $dataset['storeID'])
            ?->first()
            ?->{'Brand Desc'};


        DB::beginTransaction();

        try {

            $_main->update([
                "storeID" => $dataset['storeID'],
                "retekCode" => $dataset['retekCode'],
                "salesDate" => $dataset['salesDate'],
                "missingRemarks" => 'Valid',
                "unAllocatedStatus" => 'Valid',
                "unAllocatedRemarks" => $dataset['remarks'],
                "unAllocatedCorrectionDate" => now(),
                'isActive' => '1'
            ]);

            
            $main = $_storeID_found->update([
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
            DB::rollBack();
            dd($th->getMessage());
            $this->emit('unallocated:failed', $th->getMessage());
            return false;
        }
        
        
        DB::commit();
        $this->emit('unallocated:success');
        return true;
    }








    /**
     * Save the data to a file
     * @param array $dataset
     * @return bool
     */
    public function uploadExcelValidatedArray(array $dataset)
    {

        // find the record
        $_main = MFLInwardStoreIDMissingTransactions::find($dataset['Unique ID']);

        $_storeID = $this->_generateQuery('cash', $dataset['Collection Bank']);
        $_storeID_found =  $_storeID->find($_main->UID);
       

        $brand = \App\Models\Store::where('Store ID', $dataset['Store ID'])
            ?->first()
            ?->{'Brand Desc'};

        // checking if the data exists
        if (!$_main->exists()) {
            $this->message = 'File: Not Allowed - Updating the Unique ID will result in a potential data loss, this incident will be reported :)';
            return false;
        }

        // check if the store id is not null
        if ($_main->replicate()->storeID != null) {
            $this->message = 'File: Not Allowed - Updating theStore ID when its not empty is not allowed, this incident will be reported :)';
            return false;
        }


        // if not null then update the item using the unique id field
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

        return $res;
    }





    public function headers(): array
    {
        return [
            "Unique ID",
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Pickupt Code",
            "Deposit Slip No",
            "Collection Bank",
            "Location",
            "Deposit Amount"
        ];
    }





    /**
     * Export functionality
     * @return void
     */
    public function export($dataset = [], $all = '')
    {

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




    public function download($value = ''): \Illuminate\Support\Collection|bool
    {

        $params = [
            'procType' => 'cash-export',
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



    public function filters()
    {
        return DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_StoreID_Missing_Transaction :procType',
            [
                'procType' => 'cash-banks',
            ]
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
     * @return 
     * @return \Illuminate\Support\Collection
     */
    public function dataset(): \Illuminate\Support\Collection
    {
        $params = [
            'procType' => $this->activeTab,
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
     * Render main content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {

        $dataset = $this->dataset();

        return view('livewire.commercial-head.reports.un-allocated-transactions.cash-transaction', [
            'dataset' => $dataset,
            'selectionHas' => $dataset->pluck('storeMissingUID'),
            'totals' => $this->getTotals()
        ]);
    }
}
