<?php

namespace App\Http\Livewire\CommercialHead\Reports\UnAllocatedTransactions;

use App\Models\CashDepositReco;
use Carbon\Carbon;
use App\Traits\HasTabs;
use Livewire\Component;
use Illuminate\Http\File;
use App\Traits\ReadsExcel;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\UseDefaults;
use Livewire\WithFileUploads;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\BulkSelection;

class CashDirectDepositReco extends Component {


    use HasInfinityScroll, HasTabs, UseOrderBy, ParseMonths, WithExportDate, UseDefaults, BulkSelection, WithFileUploads;




    public $activeTab = 'cash-direct-deposit';





    /**
     * List array
     * @var array
     */
    public $branches = [];






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








    public $tenders = [
        "hdfc" => "HDFC",
        "icici" => "ICICI Cash",
        "sbi" => "SBI Cash",
        "axis" => "AXIS Cash",
        "idfc" => "IDFC",
    ];






    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Cash_Deposit_Reco';





    public function mount() {
        $this->branches = $this->branches('branch');
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
            "Deposit Date",
            "Col Bank",
            "Sales Tender",
            "Description",
            "Transaction Branch",
            "Credit Amount",
            "Debit Amount",
            "Remarks",
        ];
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
            "Deposit Date" => $item['F'],
            "Col Bank" => $item['G'],
            "Sales Tender" => $item['H'],
            "Description" => $item['I'],
            "Transaction Branch" => $item['J'],
            "Credit Amount" => $item['K'],
            "Debit Amount" => $item['L'],
            "Remarks" => $item['M'],
        ];
    }





    public function validateArray(array $data, int $rowNum) {

        // read the file as array
        $validator = Validator::make($data, [
            "Unique Id" => "nullable",
            "Account No" => "required",
            "Store Id" => "nullable|regex:/^[0-9]{4}$/",
            "Retek Code" => "nullable|regex:/^[0-9]{5}$/",
            "Sales Date" => "nullable",
            "Deposit Date" => "nullable",
            "Col Bank" => "nullable",
            "Sales Tender" => "nullable",
            "Description" => "nullable",
            "Transaction Branch" => "nullable",
            "Credit Amount" => "nullable",
            "Debit Amount" => "nullable",
            "Remarks" => "nullable"
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
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Cash_Deposit_Reco :procType, :branch, :acctNo, :selection, :from, :to',
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
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Cash_Deposit_Reco :procType, :branch, :acctNo, :selection, :from, :to',
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

        $data = CashDepositReco::find($dataset['id']);

        try {
            DB::beginTransaction();

            $data->update([
                "storeID" => $dataset['storeID'],
                "retekCode" => $dataset['retekCode'],
                "salesDate" => $dataset['saleDate'],
                "remarks" => $dataset['remarks'],
                "missingRemarks" => 'Valid',
                'tender' => $dataset['tender'],
                'isActive' => 1
            ]);

            DB::commit();
            // calling the statement is enough for the update
            $this->emit('cash-deposit:success');
            return true;

        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('cash-deposit:failed');
            return false;
        }
    }




    public function uploadExcelValidatedArray(array $dataset) {
        
        if (!$dataset['Unique Id']) {
            $res = CashDepositReco::insert([
                "accountNo" => $dataset["Account No"],
                "storeID" => $dataset["Store Id"],
                "retekCode" => $dataset["Retek Code"],
                "salesDate" => $this->format($dataset['Sales Date']),
                "depositDate" => $this->format($dataset["Deposit Date"]),
                "colBank" => $dataset["Col Bank"],
                "tender" => $dataset["Sales Tender"],
                "description" => $dataset["Description"],
                "creditAmount" => $dataset["Credit Amount"],
                "transactionBranch" => $dataset["Transaction Branch"],
                "remarks" => $dataset["Remarks"],
                "debitAmount" => $dataset["Debit Amount"],
                'isActive' => 1
            ]);

            return $res;
        }


        $data = CashDepositReco::find($dataset['Unique Id']);


        // if ($data->storeID != null) {
        //     $this->message = "File: Conflict - Trying to update a record where the storeID is not null - This action will be reported";
        //     return false;
        // }


        $res = $data->update([
            "storeID" => $dataset['Store Id'],
            "retekCode" => $dataset['Retek Code'],
            "salesDate" => $this->format($dataset['Sales Date']),
            "remarks" => $dataset['Remarks'],
            "missingRemarks" => 'Valid',
            'tender' => $dataset['Sales Tender'],
            'isActive' => 1
        ]);

        return $res;
    }





    /**
     * Data source
     * @return array
     */
    public function getTotals() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Cash_Deposit_Reco :procType, :branch, :acctNo, :selection, :from, :to',
            [
                'procType' => 'total',
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
    public function dataset() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Cash_Deposit_Reco :procType, :branch, :acctNo, :selection, :from, :to',
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
     * Render main content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->dataset();

        return view('livewire.commercial-head.reports.un-allocated-transactions.cash-direct-deposit-reco', [
            'cashRecons' => $dataset,
            'selectionHas' => $dataset->pluck('UID'),
            'totals' => $this->getTotals()
        ]);
    }
}
