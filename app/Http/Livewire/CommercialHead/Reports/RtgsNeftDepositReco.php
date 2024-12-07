<?php

namespace App\Http\Livewire\CommercialHead\Reports;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithHeaders;
use App\Models\CashDepositReco as ModelsCashDepositReco;
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
use Livewire\WithFileUploads;

class RtgsNeftDepositReco extends Component implements UseExcelDataset, WithHeaders {

    use HasInfinityScroll, HasTabs, UseOrderBy, ParseMonths, WithExportDate, UseDefaults, BulkSelection, WithFileUploads;




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







    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_RtgsNeft_Deposit_Reco';





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
            "Description",
            "Transaction Branch",
            "Credit Amount",
            "Debit Amount",
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

                if(!$status) {
                    return false;
                }

                $index++;
            }


            DB::commit();
            $this->emit('file:imported');
            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            $this->message = 'File: Server error ... '. $th->getMessage() . '- The Data updated by using this file will be reverted back to its original state :)';
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
            "Description" => $item['H'],
            "Transaction Branch" => $item['I'],
            "Credit Amount" => $item['J'],
            "Debit Amount" => $item['K'],
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

        if(!$date) {
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

        $data = ModelsCashDepositReco::find($dataset['id']);

        try {
            DB::beginTransaction();

            $data->update([
                "storeID" => $dataset['storeID'],
                "retekCode" => $dataset['retekCode'],
                "salesDate" => $dataset['saleDate'],
                "remarks" => $dataset['remarks'],
                "missingRemarks" => 'Valid',
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
        $data = ModelsCashDepositReco::find($dataset['Unique Id']);

        if($data->storeID != null){
            $this->message = "File: Conflict - Trying to update a record where the storeID is not null - This action will be reported";
            return false;
        }

        $res = $data->update([
            "storeID" => $dataset['Store Id'],
            "retekCode" => $dataset['Retek Code'],
            "salesDate" => $this->format($dataset['Sales Date']),
            "remarks" => 'Uploaded from Excel',
            "missingRemarks" => 'Valid',
            'isActive' => 1
        ]);

        return $res;
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
        return view('livewire.commercial-head.reports.rtgs-neft-deposit-reco', [
            'cashRecons' => $dataset,
            'selectionHas' => $dataset->pluck('UID')
        ]);
    }
}
