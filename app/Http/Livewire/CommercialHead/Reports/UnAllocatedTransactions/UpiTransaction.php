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

class UpiTransaction extends Component
{

    use HasInfinityScroll, HasTabs, UseOrderBy, ParseMonths, WithExportDate, UseDefaults, WithFileUploads, ReadsExcel, UseMisModels;






    public $activeTab = 'upi';






    protected $queryString = [
        'activeTab' => ['as' => 'tab']
    ];

    public $location = '';



    public $banks = [];


    public $bank = '';





    /**
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Un_Allocated_Transaction_UPI';




    /**
     * Display error messages in the upload modal
     * @var string
     */
    public $message = '';










    /**
     * File to import
     * @var \Illuminate\Http\File
     */
    public $importFile = null;


    public $selectedTid;
    public $tids = [];

    public function tidFilter()
    {
        $tids = DB::select('EXEC PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_StoreIDMissingTransactions
        @procType = :procType,
        @bank = :bank,
        @location = :location,
        @selection = :selection,
        @from = :fromDate,
        @to = :toDate,
        @PageSize = :perPage,
        @OrderBy = :orderBy',
            [
                'procType' => $this->activeTab . '-tid',
                'bank' => $this->bank,
                'location' => $this->location,
                'selection' => null,
                'fromDate' => $this->startDate,
                'toDate' => $this->endDate,
                'perPage' => $this->perPage,
                'orderBy' => $this->orderBy,
            ]
        );
        $this->tids = collect($tids)->map(function ($item) {
            return (array) $item;
        })->toArray();


    }

    /**
     * Resets all the properties
     * @return void
     */
    public function mount()
    {
        $this->_months = $this->_months()->toArray();
        $this->banks = $this->filters('upi-banks');
        $this->tidFilter();
        logger(json_encode($this->tids));

    }








    /**
     * Reload the filters
     * @return void
     */
    public function back()
    {
        $this->emit('resetAll');
        $this->resetExcept(['banks', 'activeTab']);
        // $this->tidFilter();
    }












    public function filters()
    {
        return DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_StoreID_Missing_Transaction :procType',
            [
                'procType' => 'upi-banks',
            ]
        );
    }











    public function headers(): array
    {
        return [
            "Unique ID",
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "TID",
            "Collection Bank",
            "Deposit Amount",
        ];
    }








    public function validateArray(array $data, int $rowNum)
    {

        // read the file as array
        $validator = Validator::make($data, [
            "Unique ID" => "required",
            "Sales Date" => "required|date",
            "Deposit Date" => "nullable",
            "Store ID" => "required|regex:/^[0-9]{4}$/",
            "Retek Code" => "required|regex:/^[0-9]{5}$/",
            "TID" => "nullable",
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








    /**
     * Update Unallocated Cash Transactions
     * @param array $dataset
     * @return bool
     */
    public function updateUnAllocated(array $dataset): bool
    {

        $_storeID = $this->_generateQuery('upi', 'HDFC UPI');
        $_storeID_found = $_storeID->find($dataset['UID']);


        $_main = MFLInwardStoreIDMissingTransactions::find($dataset['itemID']);

        if (!$_main->exists()) {
            $this->emit('unallocated:failed', 'Unable to Find the Record');
            return false;
        }

        $brand = \App\Models\Store::where('Store ID', $dataset['storeID'])
                ?->first()
            ?->{'Brand Desc'};
        DB::beginTransaction();

        try {

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
            $_storeID_found->update([
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

        } catch (\Throwable $th) {
            DB::rollBack();
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

        $_storeID = $this->_generateQuery('upi', $dataset['Collection Bank']);
        $_storeID_found = $_storeID->find($_main->UID);


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









    /**
     * Get the total Records
     *
     * @return Collection|array
     */
    public function getTotals(): Collection|array
    {
        if ($this->selectedTid && $this->selectedTid !== 'ALL') {
            $params = [
                'procType' => $this->activeTab . '-totals',
                'bank' => $this->bank,
                'location' => $this->location,
                'selection' => null,
                'from' => $this->startDate,
                'to' => $this->endDate,
                'PageSize' => $this->perPage,
                'OrderBy' => $this->orderBy,
                'selectedTidValue' => $this->selectedTid
            ];

            $data = DB::select(
                'EXEC PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_StoreIDMissingTransactions :procType, :bank, :location, :selection, :from, :to, :PageSize ,:OrderBy, :selectedTidValue',
                $params
            );

            return collect($data);
        } else {

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
    }


    /**
     * Dataset for the screen
     * @return Collection
     */
    public function dataset()
    {
        $optionAll = $this->selectedTid !== 'ALL';
        if ($this->selectedTid && $optionAll) {
            $this->filtering = true;
            $params = [
                'procType' => $this->activeTab,
                'bank' => $this->bank,
                'location' => $this->location,
                'selection' => null,
                'from' => $this->startDate,
                'to' => $this->endDate,
                'PageSize' => $this->perPage,
                'OrderBy' => $this->orderBy,
                'selectedTidValue' => $this->selectedTid
            ];

            $data = DB::select(
                'EXEC PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_StoreIDMissingTransactions :procType, :bank, :location, :selection, :from, :to, :PageSize ,:OrderBy, :selectedTidValue',
                $params
            );

            return collect($data);
        } else {
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
    }

    public function download($value = ''): Collection|bool
    {

        $params = [
            'procType' => 'upi-export',
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
     * Dataset for the screen
     * @return \Illuminate\Support\Collection
     */





    /**
     * Render main content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {


        $dataset = $this->dataset();

        return view('livewire.commercial-head.reports.un-allocated-transactions.upi-transaction', [
            'dataset' => $dataset,
            'selectionHas' => $dataset->pluck('storeMissingUID'),
            'totals' => $this->getTotals()
        ]);
    }
}
