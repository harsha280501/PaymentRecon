<?php

namespace App\Http\Livewire\CommercialHead\Exceptions;

use App\Models\StoreUpdateHistory as ModelsStoreUpdateHistory;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\UseDefaults;
use App\Traits\UseOrderBy;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class StoreUpdateHistory extends Component {

    use HasInfinityScroll, ParseMonths, UseOrderBy, UseDefaults, WithFileUploads;





    /**
     * Storres Array
     * @var string
     */
    public $stores = [];






    /**
     * Storres Array
     * @var string
     */
    public $banks = [];







    /**
     * Store
     * @var string
     */
    public $store = '';





    /**
     * Store
     * @var string
     */
    public $bank = '';






    /**
     * Store
     * @var string
     */
    public $message = '';






    /**
     * Store
     * @var string
     */
    public $importFile = null;






    protected $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Exception_Store_Update_History';










    /**
     * Initialize variables
     * @return void
     */
    public function mount() {
        $this->_months = $this->_months()->toArray();
        $this->stores = $this->stores();
        $this->banks = $this->banks();
    }









    /**
     * Summary of headers
     * @return string[]
     */
    public function headers() {
        return [
            "Unique Id",
            "Updated Date",
            "Deposit Date",
            "New Store ID",
            "Old Store ID",
            "Collection Bank",
            "From Date",
            "To Date",
            "Remarks"
        ];
    }





    public function reader(string $path) {
        $inputFileTypeIdentify = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileTypeIdentify);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);

        $spreadsheet = $reader->load($path);
        return $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    }



    public function updatedImportFile() {


        $this->message = 'File : Loading ...';
        // save the file and validate
        $filename = $this->importFile->store('store-update-history');
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
            "Updated Date" => $item['B'],
            "Deposit Date" => $item['C'],
            "New Store ID" => $item['D'],
            "Old Store ID" => $item['E'],
            "Collection Bank" => $item['F'],
            "From Date" => $item['G'],
            "To Date" => $item['H'],
            "Remarks" => $item['I']
        ];
    }





    public function validateArray(array $data, int $rowNum) {

        // read the file as array
        $validator = Validator::make($data, [
            "Unique Id" => "required",
            "Updated Date" => "nullable",
            "Deposit Date" => "nullable",
            "New Store ID" => "required|regex:/^[0-9]{4}$/",
            "Old Store ID" => "required|regex:/^[0-9]{4}$/",
            "Collection Bank" => "required",
            "From Date" => "date",
            "To Date" => "date",
            "Remarks" => "nullable"
        ]);


        if ($validator->fails()) {
            $this->message = 'File: Validation Error: ' . $validator->errors()->first() . ' on row number - ' . $rowNum;
            return false;
        }

        return true;
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






    public function uploadExcelValidatedArray(array $dataset) {


        if (!$dataset['Unique Id']) {
            $this->message = 'File: Unable to locate file: Unique ID missing ';
            return false;
        }

        $data = ModelsStoreUpdateHistory::find($dataset['Unique Id']);

        if(!$data) {
            $this->message = 'File: Record not found! ';
            return false;
        }


        if($data->oldStoreID != $dataset['Old Store ID']) {
            $this->message = 'File: The Old Store ID cannot be updated';
            return false;
        }


        $res = $data->update([
            "updatedDate" => $this->format($dataset['Updated Date']),
            "depositDt" => $this->format($dataset['Deposit Date']),
            "newStoreID" => $dataset['New Store ID'],
            "oldStoreID" => $dataset['Old Store ID'],
            "Colbank" => $dataset['Collection Bank'],
            "dateFrom" => $this->format($dataset['From Date']),
            "dateTo" => $this->format($dataset['From Date']),
            "Remarks" => $dataset['Remarks'],
            'isActive' => 1,
            'modifiedBy' => auth()->user()->userUID

        ]);

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










    /**
     * Get the Main reports
     * @return LengthAwarePaginator
     */
    public function banks() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_StoreID_Updated_History :procType, :store, :bank, :from, :to', [
                'procType' => 'banks',
                'store' => null,
                'bank' => null,
                'from' => null,
                'to' => null,
            ],
            $this->perPage,
            $this->orderBy
        );
    }






    /**
     * Get the Main reports
     * @return LengthAwarePaginator
     */
    public function stores() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_StoreID_Updated_History :procType, :store, :bank, :from, :to', [
                'procType' => 'stores',
                'store' => null,
                'bank' => null,
                'from' => null,
                'to' => null,
            ],
            $this->perPage,
            $this->orderBy
        );
    }






    /**
     * Get the aMain reports
     * 
     */
    public function download(string $value = '') {

        $params = [
            'procType' => 'export',
            'store' => $this->store,
            'bank' => $this->bank,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_StoreID_Updated_History :procType, :store,:bank, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }




    /**
     * Get the aMain reports
     * 
     */
    public function dataset() {

        $params = [
            'procType' => 'main',
            'store' => $this->store,
            'bank' => $this->bank,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_StoreID_Updated_History :procType, :store, :bank, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }






    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->dataset();

        return view('livewire.commercial-head.exceptions.store-update-history', [
            'dataset' => $dataset,
        ]);
    }
}
