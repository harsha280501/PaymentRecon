<?php

namespace App\Http\Livewire\CommercialHead\Reports\UnAllocatedTransactions;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithHeaders;
use App\Models\CashDepositReco as ModelsCashDepositReco;
use App\Models\Store;
use App\Traits\BulkSelection;
use App\Traits\HasTabs;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\HasInfinityScroll;
use App\Traits\UseDefaults;
use App\Traits\WithExportDate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;

class RtgsNeftReco extends Component implements UseExcelDataset, WithHeaders {

    use HasInfinityScroll, HasTabs, UseOrderBy, ParseMonths, WithExportDate, UseDefaults, BulkSelection, WithFileUploads;



    public $activeTab = 'rtgs-neft-reco';




    /**
     * List array
     * @var array
     */
    public $branches = [];







    /**
     * List array
     * @var array
     */
    public $stores = [];






    /**
     * List array
     * @var array
     */
    public $accountNo = [];





    /**
     * Imported File
     * @var string
     */
    public $acctNo = "";




    /**
     *
     * @var string
     */
    public $message = '';







    /**
     * Branch
     * @var string
     */
    public $branch = '';





    public $importFile = null;







    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_RtgsNeft_Deposit_Reco';





    public function mount() {
        $this->branches = $this->branches('branch');
        $this->stores = $this->branches('stores');
        $this->accountNo = $this->branches('accountNo');
        $this->_months = $this->_months()->toArray();
    }








    /**
     * Reload the filters
     * @return void
     */
    public function back() {
        $this->reset();
        $this->emit('reset:all');
        $this->emit('resetAll');
    }






    /**
     * Headers for the Export
     *
     * @return array
     */
    public function headers(): array {
        return [
            "Unique ID",
            "Account No",
            "Store ID",
            "Retek Code",
            "Sales Date",
            "Tender",
            "Deposit Date",
            "Col Bank",
            "Description",
            "Transaction Branch",
            "Credit Amount",
            "Debit Amount",
        ];
    }




    public function query(string $tender) {

        if (in_array($tender, ['Cash'])) {
            return DB::table('MFL_Inward_AllBankCashMIS');
        }

        if (in_array($tender, ['HDFC Card', 'ICICI Card', 'AMEX Card', 'SBI Card', 'HDFC UPI'])) {
            return DB::table('MFL_Inward_AllBankCardMIS');
        }

        if (in_array($tender, ['WALLET PAYTM', 'WALLET PHONEPAY'])) {
            return DB::table('MFL_Inward_AllWalletMIS');
        }
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









    public function updatedImportFile() {


        $this->message = 'File : Loading ...';
        // save the file and validate
        $filename = $this->importFile->store('cash-deposit');
        $file_path = storage_path() . '/app/public/' . $filename;

        $sheet = $this->reader($file_path);
        unset($sheet[1]); // removing the header from the array
        $this->message = 'File: Validating ...';

        $index = 2;

        try {

            DB::beginTransaction();

            foreach ($sheet as $item) {
                if (!$this->validateArray($this->withHeaders($item), $index)) {
                    return false;
                }

                $status = $this->uploadExcelValidatedArray($this->withHeaders($item));

                if (!$status) {
                    return false;
                }

                $index++;
            }


            DB::commit();
            $this->emit('file:imported');
            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            $this->message = 'File: Server error ... ' . $th->getMessage() . '- The Data updated by using this file will be reverted back to its original state :)';
            return false;
        }
    }





    public function withHeaders(array $item) {
        return [
            "Unique Id" => $item['A'],
            "Account No" => $item['B'],
            "Store Id" => $item['C'],
            "Retek Code" => $item['D'],
            "Sales Date" => $item['E'],
            "Tender" => $item['F'],
            "Deposit Date" => $item['G'],
            "Col Bank" => $item['H'],
            "Description" => $item['I'],
            "Transaction Branch" => $item['J'],
            "Credit Amount" => $item['K'],
            "Debit Amount" => $item['L'],
        ];
    }





    public function validateArray(array $data, int $rowNum) {

        // read the file as array
        $validator = Validator::make($data, [
            "Unique Id" => "required",
            "Account No" => "required",
            "Store Id" => "required|regex:/^[0-9]{4}$/",
            "Retek Code" => "required|regex:/^[0-9]{5}$/",
            "Sales Date" => "required",
            "Tender" => "required",
            "Deposit Date" => "nullable",
            "Col Bank" => "nullable",
            "Description" => "nullable",
            "Transaction Branch" => "nullable",
            "Credit Amount" => "nullable",
            "Debit Amount" => "nullable",
        ]);


        if ($validator->fails()) {
            $this->message = 'File: Validation Error: ' . $validator->errors()->first() . ' on row number - ' . $rowNum;
            return false;
        }

        return true;
    }






    public function reader(string $path) {
        $inputFileTypeIdentify = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileTypeIdentify);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);

        $spreadsheet = $reader->load($path);
        return $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    }








    public function format(string|null $date) {

        if (!$date) {
            return null;
        }

        $_string = preg_replace('/[^\w]/', '-', $date);

        try {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($_string)->format('Y-m-d');
            } catch (\Throwable $th) {
                return Carbon::parse($_string)->format('Y-m-d');
            }
        } catch (\Throwable $th) {
            return Carbon::createFromFormat('m-d-Y', $_string)->format('Y-m-d');
        }
    }







    /**
     * Download Excel
     * @param string $value
     * @return Collection|boolean
     */
    public function branches($procType): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Rtgs_Neft_Deposit_Reco :procType, :branch, :acctNo, :selection, :from, :to',
            [
                'procType' => $procType,
                'branch' => '',
                'acctNo' => '',
                'selection' => '',
                'from' => '',
                'to' => ''
            ],
            perPage: $this->perPage,
            orderBy: 'asc'
        );
    }










    /**
     * Download Excel
     * @param string $value
     * @return Collection|boolean
     */
    public function download($value = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Rtgs_Neft_Deposit_Reco :procType, :branch, :acctNo, :selection, :from, :to',
            [
                'procType' => 'export',
                'branch' => $this->branch,
                'acctNo' => $this->acctNo,
                'selection' => $value,
                'from' => $this->startDate,
                'to' => $this->endDate
            ],
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }



    public function save(array $dataset) {

        Log::channel('rtgs-neft-logs')->debug('Starting save method', ['dataset' => $dataset]);

        $data = ModelsCashDepositReco::find($dataset['id']);
        Log::channel('rtgs-neft-logs')->debug('Fetched ModelsCashDepositReco record', ['data' => $data]);

        $_store = Store::where('Store ID', $dataset['storeID'])->first();
        Log::channel('rtgs-neft-logs')->debug('Fetched Store record', ['store' => $_store]);

        $query = $this->query($dataset['tender']);
        Log::channel('rtgs-neft-logs')->debug('Query prepared for tender', ['tender' => $dataset['tender'], 'query' => $query]);

        try {
            Log::channel('rtgs-neft-logs')->info('Initiating RTGS/NEFT transaction process', ['dataset' => $dataset]);

            DB::beginTransaction();
            Log::channel('rtgs-neft-logs')->debug('Transaction started');

            Log::channel('rtgs-neft-logs')->debug('Inserting data into the transaction table', [
                'storeID' => $dataset['storeID'],
                'retekCode' => $dataset['retekCode'],
                'colBank' => in_array($dataset['tender'], ['Cash']) ? 'HDFC' : $dataset['tender'],
                'brand' => $_store->{'Brand Desc'},
                'depositDate' => $data->depositDate,
                'depositAmount' => ($data->creditAmount == 0 || !$data->creditAmount) ? $data->debitAmount : $data->creditAmount,
                'remarks' => 'RTGS/NEFT Transaction'
            ]);

            $query->insert([
                'storeID' => $dataset['storeID'],
                'retekCode' => $dataset['retekCode'],
                'colBank' => in_array($dataset['tender'], ['Cash']) ? 'HDFC' : $dataset['tender'],
                'brand' => $_store->{'Brand Desc'},
                'depositDt' => $data->depositDate,
                'depositAmount' => ($data->creditAmount == 0 || !$data->creditAmount) ? $data->debitAmount : $data->creditAmount,
                'remarks' => 'RTGS/NEFT Transaction'
            ]);

            Log::channel('rtgs-neft-logs')->info('RTGS/NEFT transaction inserted successfully', ['storeID' => $dataset['storeID'], 'retekCode' => $dataset['retekCode']]);

            Log::channel('rtgs-neft-logs')->debug('Updating ModelsCashDepositReco record', [
                'storeID' => $dataset['storeID'],
                'retekCode' => $dataset['retekCode'],
                'salesDate' => $this->format($dataset['saleDate']),
                'tender' => in_array($dataset['tender'], ['Cash']) ? 'HDFC' : $dataset['tender'],
                'remarks' => $dataset['remarks'],
                'missingRemarks' => 'Valid',
                'isActive' => 1,
                'isMovedAllBank' => 1,
            ]);

            $data->update([
                "storeID" => $dataset['storeID'],
                "retekCode" => $dataset['retekCode'],
                "salesDate" => $this->format($dataset['saleDate']),
                "tender" => in_array($dataset['tender'], ['Cash']) ? 'HDFC' : $dataset['tender'],
                "remarks" => $dataset['remarks'],
                "missingRemarks" => 'Valid',
                'isActive' => 1,
                'isMovedAllBank' => 1,
                'modifiedBy' => auth()->user()->userUID,
                'modifiedAt' => now()->format('Y-m-d')
            ]);

            DB::commit();
            Log::channel('rtgs-neft-logs')->info('RTGS/NEFT transaction committed successfully', ['storeID' => $dataset['storeID'], 'retekCode' => $dataset['retekCode']]);

            $this->emit('cash-deposit:success');
            Log::channel('rtgs-neft-logs')->debug('Event cash-deposit:success emitted');

            return true;

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('rtgs-neft-logs')->error('RTGS/NEFT transaction failed', [
                'dataset' => $dataset,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            $this->emit('cash-deposit:failed', ['message' => $th->getMessage()]);
            Log::channel('rtgs-neft-logs')->debug('Event cash-deposit:failed emitted', ['message' => $th->getMessage()]);

            return false;
        }
    }





    public function uploadExcelValidatedArray(array $dataset) {

        Log::channel('rtgs-neft-logs')->debug('Starting uploadExcelValidatedArray method', ['dataset' => $dataset]);

        $data = ModelsCashDepositReco::find($dataset['Store Id']);
        Log::channel('rtgs-neft-logs')->debug('Fetched ModelsCashDepositReco record', ['data' => $data]);

        $_store = Store::where('Store ID', $dataset['Store Id'])->first();
        Log::channel('rtgs-neft-logs')->debug('Fetched Store record', ['store' => $_store]);

        $query = $this->query($dataset['Tender']);
        Log::channel('rtgs-neft-logs')->debug('Query prepared for tender', ['tender' => $dataset['Tender'], 'query' => $query]);

        // Conflict check
        if ($data->storeID != null) {
            Log::channel('rtgs-neft-logs')->warning('Conflict: Store ID is not null, operation aborted', [
                'storeID' => $data->storeID,
                'dataset' => $dataset
            ]);

            $this->message = "File: Conflict - Trying to update a record where the storeID is not null - This action will be reported";
            return false;
        }

        Log::channel('rtgs-neft-logs')->info('No conflict detected, proceeding with data insertion', [
            'storeID' => $dataset['Store Id'],
            'retekCode' => $dataset['Retek Code']
        ]);

        // Insert operation
        Log::channel('rtgs-neft-logs')->debug('Inserting transaction into database', [
            'storeID' => $dataset['Store Id'],
            'retekCode' => $dataset['Retek Code'],
            'colBank' => $dataset['Tender'] == 'Cash' ? 'HDFC' : $dataset['Tender'],
            'brand' => $_store->{'Brand Desc'},
            'depositDate' => $data->depositDate,
            'depositAmount' => $data->creditAmount,
            'remarks' => 'RTGS/NEFT Transaction'
        ]);

        $query->insert([
            'storeID' => $dataset['Store Id'],
            'retekCode' => $dataset['Retek Code'],
            'colBank' => $dataset['Tender'] == 'Cash' ? 'HDFC' : $dataset['tender'],
            'brand' => $_store->{'Brand Desc'},
            'depositDt' => $data->depositDate,
            'depositAmount' => $data->creditAmount,
            'remarks' => 'RTGS/NEFT Transaction'
        ]);

        Log::channel('rtgs-neft-logs')->info('Transaction inserted successfully', [
            'storeID' => $dataset['Store Id'],
            'retekCode' => $dataset['Retek Code']
        ]);

        // Update operation
        Log::channel('rtgs-neft-logs')->debug('Updating ModelsCashDepositReco record', [
            'storeID' => $dataset['Store Id'],
            'retekCode' => $dataset['Retek Code'],
            'salesDate' => $this->format($dataset['Sales Date']),
            'tender' => $dataset['Tender'] == 'Cash' ? 'HDFC' : $dataset['Tender'],
            'remarks' => 'Uploaded from Excel',
            'missingRemarks' => 'Valid',
            'isActive' => 1,
            'isMovedAllBank' => 1
        ]);

        $res = $data->update([
            "storeID" => $dataset['Store Id'],
            "retekCode" => $dataset['Retek Code'],
            "salesDate" => $this->format($dataset['Sales Date']),
            "tender" => $dataset['Tender'] == 'Cash' ? 'HDFC' : $dataset['Tender'],
            "remarks" => 'Uploaded from Excel',
            "missingRemarks" => 'Valid',
            'isActive' => 1,
            'isMovedAllBank' => 1,
            'modifiedBy' => auth()->user()->userUID,
            'modifiedAt' => now()->format('Y-m-d')
        ]);

        if ($res) {
            Log::channel('rtgs-neft-logs')->info('RTGS/NEFT transaction successfully updated', [
                'storeID' => $dataset['Store Id'],
                'retekCode' => $dataset['Retek Code'],
                'update_result' => $res
            ]);
        } else {
            Log::channel('rtgs-neft-logs')->error('Failed to update RTGS/NEFT transaction', [
                'storeID' => $dataset['Store Id'],
                'retekCode' => $dataset['Retek Code'],
                'update_result' => $res
            ]);
        }

        Log::channel('rtgs-neft-logs')->debug('Exiting uploadExcelValidatedArray method', ['result' => $res]);

        return $res;
    }






    /**
     * Data source
     * @return array
     */
    public function getTotals() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Rtgs_Neft_Deposit_Reco :procType, :branch, :acctNo, :selection, :from, :to',
            [
                'procType' => 'totals',
                'branch' => $this->branch,
                'acctNo' => $this->acctNo,
                'selection' => '',
                'from' => $this->startDate,
                'to' => $this->endDate
            ],
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }




    /**
     * Data source
     * @return array
     */
    public function getData() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Rtgs_Neft_Deposit_Reco :procType, :branch, :acctNo, :selection, :from, :to',
            [
                'procType' => 'main',
                'branch' => $this->branch,
                'acctNo' => $this->acctNo,
                'selection' => '',
                'from' => $this->startDate,
                'to' => $this->endDate
            ],
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }






    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->getData();
        return view('livewire.commercial-head.reports.un-allocated-transactions.rtgs-neft-reco', [
            'cashRecons' => $dataset,
            'selectionHas' => $dataset->pluck('UID'),
            'totals' => $this->getTotals()
        ]);
    }
}
