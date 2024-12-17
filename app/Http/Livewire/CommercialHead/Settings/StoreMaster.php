<?php

namespace App\Http\Livewire\CommercialHead\Settings;

use App\Models\Store;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\ReadsExcel;
use App\Traits\UseDefaults;
use App\Traits\UseOrderBy;
use Carbon\Carbon;
use DateException;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

use Livewire\WithFileUploads;


class StoreMaster extends Component {

    use HasInfinityScroll, WithFileUploads, ReadsExcel, UseOrderBy, ParseMonths, UseDefaults;




    /**
     * File for import 
     * @var 
     */
    public $importFile = null;








    /**
     * File for import 
     * @var 
     */
    public $headers = [];





    /**
     * Messages to show
     * @var 
     */
    public $message = null;








    /**
     * Messages to show
     * @var 
     */
    public $stores = [];










    /**
     * Messages to show
     * @var 
     */
    public $storeFrom = null;










    /**
     * Messages to show
     * @var 
     */
    public $storeTo = null;








    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Settings_Store_Master';






    public function mount() {
        $this->stores = $this->getStores();
        $this->_months = $this->_months()->toArray();
    }






    /**
     * Brand filter, get brands list
     * @return \Illuminate\Support\Collection
     */
    public function getStores(): \Illuminate\Support\Collection|array {
        return Store::distinct()->pluck('Store ID')->toArray();
    }








    public function headers() {
        return [
            "Unique ID",
            "SL no",
            "MGP SAP code",
            "NEW SAP code",
            "Retak code",
            "New IO No",
            "Brand Name",
            "Sub Brand",
            "StoreTypeasperBrand",
            "Channel",
            "Franchisee Name",
            "Store opening Date",
            "Status",
            "Store Closing Date",
            "Location",
            "City",
            "State",
            "Address",
            "Pin code",
            "Located ",
            "Store Area (Sq Feet)",
            "Region",
            "Store Manager Name",
            "Contact no",
            "Basement occupied (Y/No)",
            "ARM email id",
            "RM email id",
            "NROM email id",
            "RCM mail",
            "Correct store email id",
            "HO contact",
            "RD email id"
        ];
    }










    /**
     * Export as CSV
     * @return void
     */
    public function export() {

        $data = $this->download();
        $headers = $this->headers();

        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }


        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen(filename: $filePath, mode: 'w'); # open the filePath - create if not exists
        fputcsv(stream: $file, fields: $headers); # adding headers to the excel

        foreach ($data as $row) {
            $row = (array) $row;
            fputcsv(stream: $file, fields: $row);
        }

        fclose(stream: $file);

        return response()->stream(
            function () use ($filePath) {
                echo file_get_contents(filename: $filePath);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '"',
            ]
        );
    }








    /**
     * Validation for array items
     *
     * @param array $data
     * @param integer $rowNum
     * @return bool
     */
    public function validateArray(array $data, int $rowNum) {

        # read the file as array
        $validator = Validator::make($data, [
            "Unique ID" => "nullable",
            "SL no" => "nullable",
            "MGP SAP code" => "required",
            "NEW SAP code" => "required",
            "Retak code" => "required",
            "New IO No" => "nullable",
            "Brand Name" => "nullable",
            "Sub Brand" => "nullable",

            "StoreTypeasperBrand" => "nullable",
            "Channel" => "nullable",

            "Franchisee Name" => "nullable",
            "Store opening Date" => "nullable",

            "Status" => "nullable",
            "Store Closing Date" => "nullable",
            "Location" => "nullable",
            "City" => "nullable",
            "State" => "nullable",

            "Address" => "nullable",
            "Pin code" => "nullable",
            "Located " => "nullable",
            "Store Area (Sq Feet)" => "nullable",
            "Region" => "nullable",
            "Store Manager Name" => "nullable",
            "Contact no" => "nullable",
            "Basement occupied (Y/No)" => "nullable",
            "ARM email id" => "nullable",
            "RM email id" => "nullable",
            "NROM email id" => "nullable",
            "RCM mail" => "nullable",
            "Correct store email id" => "nullable",
            "HO contact" => "nullable",
            "RD email id" => "nullable"
        ]);


        if ($validator->fails()) {
            $this->message = 'File: Validation Error: ' . $validator->errors()->first() . ' on row number - ' . $rowNum;
            return false;
        }

        return true;
    }







    /**
     * Validating file upload
     * @param \Livewire\TemporaryUploadedFile $request
     * @return bool
     */
    public function updatedImportFile() {

        # message to display when the file is uploaded
        $this->message = 'File : Loading ...';

        # $this->validateOnly("importFile");
        $this->validate([
            "importFile" => "required"
        ]);


        # validate the file
        $_path = $this->importFile->storeAs(path: 'Upload/StoreMaster/Uploaded', name: $this->importFile->getClientOriginalName());

        $targetPath = storage_path(path: 'app/public/') . $_path;
        $sheet = $this->reader(path: $targetPath);
        $this->headers = $sheet[1];
        unset($sheet[1]);

        $this->message = 'File: Validating ...';
        $index = 1;

        DB::beginTransaction();
        try {

            foreach ($sheet as $item) {
                $data = $this->withHeaders(headers: $this->headers, data: $item);

                if (!$this->validateArray(data: $data, rowNum: $index)) {
                    return false;
                }

                $status = $this->importUploadFile(data: $data);

                if (!$status) {
                    DB::rollBack();
                    return false;
                }

                DB::commit();
                $index++;
            }


            # DB::commit();
            $this->emit('file:imported');
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            $this->message = 'File: Server error ... ' . $th->getMessage() . '- The Data updated by using this file will be reverted back to its original state :)';
            return false;
        }
    }








    /**
     * File Upload
     * @return bool
     */
    public function importUploadFile(array $data): bool {
        try {


            // # taking a backup of the data before bulk upload
            // DB::statement('InsertDataIntoDynamicTable :proctype', ["proctype" => "mStore"]);


            $dataset = [
                "MGP SAP code" => $data["MGP SAP code"],
                "Store ID" => $data["NEW SAP code"],
                "RETEK Code" => $data["Retak code"],
                "Brand Desc" => $data["Brand Name"],
                "StoreTypeasperBrand" => $data["StoreTypeasperBrand"],
                "Channel" => $data["Channel"],
                "Store Name" => $data["Franchisee Name"],
                "Store opening Date" => $this->format($data["Store opening Date"]),
                "SStatus" => $data["Status"],
                "Store Closing Date" => $this->format($data["Store Closing Date"]),
                "Location" => $data["Location"],
                "City" => $data["City"],
                "State" => $data["State"],
                "Address" => $data["Address"],
                "Pin code" => $data["Pin code"],
                "Region" => $data["Region"],
                "Store Manager Name" => $data["Store Manager Name"],
                "Contact no" => $data["Contact no"],
                "Basement occupied (Y/No)" => $data["Basement occupied (Y/No)"],
                "ARM email id" => $data["ARM email id"],
                "RM email id" => $data["RM email id"],
                "NROM email id" => $data["NROM email id"],
                "RCM mail" => $data["RCM mail"],
                "Correct store email id" => $data["Correct store email id"],
                "HO contact" => $data["HO contact"],
                "RD email id" => $data["RD email id"],
                "createdBys" => auth()->user()->userUID
            ];


            # create the id
            if (!$data["Unique ID"]) {

                $_exists = Store::where(column: 'Store ID', operator: '=', value: $dataset["Store ID"]);

                # check if the store id already exists
                if ($_exists && $_exists->exists()) {
                    $res = $_exists->update([...$dataset]);
                } else {
                    # create the store
                    $res = Store::updateOrInsert([...$dataset]);
                }

                # if the data not updated
                if (!$res) {
                    $this->message = "Something went wrong";
                    return false;
                }
            } else {

                $_exists = Store::find(id: $data["Unique ID"]);

                if (!$_exists) {
                    $this->message = "File: Updating the Unique ID column may cause issues";
                    return false;
                }

                $_exists->update([...$dataset]);
            }



            return true;
        } catch (\Throwable $exception) {
            $this->message = $exception->getMessage();
            return false;
        }
    }





    public function parse(array $data) {
        return [
            "MGP SAP code" => $data["MGP SAP code"],
            "Store ID" => $data["NEW SAP code"],
            "RETEK Code" => $data["Retak code"],
            "Brand Desc" => $data["Brand Name"],
            "StoreTypeasperBrand" => $data["StoreTypeasperBrand"],
            "Channel" => $data["Channel"],
            "Store Name" => $data["Franchisee Name"],
            "Store opening Date" => Carbon::parse($data["Store opening Date"])->format('Y-m-d'),
            "SStatus" => $data["Status"],
            "Store Closing Date" => Carbon::parse($data["Store Closing Date"])->format('Y-m-d'),
            "Location" => $data["Location"],
            "City" => $data["City"],
            "State" => $data["State"],
            "Address" => $data["Address"],
            "Pin code" => $data["Pin code"],
            "Region" => $data["Region"],
            "Store Manager Name" => $data["Store Manager Name"],
            "Contact no" => $data["Contact no"],
            "ARM email id" => $data["ARM email id"],
            "RM email id" => $data["RM email id"],
            "NROM email id" => $data["NROM email id"],
            "RCM mail" => $data["RCM mail"],
            "Correct store email id" => $data["Correct store email id"],
            "HO contact" => $data["HO contact"],
            "RD email id" => $data["RD email id"]
        ];
    }





    public function create(array $dataset): bool {

        # validate the dataset
        if (!$this->validateArray(data: $dataset, rowNum: 0)) {
            return false;
        }

        DB::beginTransaction();
        # create the dataset
        try {
            Store::insert([...$this->parse(data: $dataset)]);
            DB::commit();
            # emitting an event to reload the page
            $this->emit('file:created');
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('create:failed', ["message" => $th->getMessage()]);
            return false;
        }
    }





    public function edit(array $dataset): bool {

        # validate the dataset
        if (!$this->validateArray(data: $dataset, rowNum: 0)) {
            return false;
        }

        DB::beginTransaction();
        # create the dataset
        try {

            $_exists = Store::find(id: $dataset["Unique ID"]);
            $data = $this->parse(data: $dataset);

            if (!$_exists) {
                $this->emit(event: 'create:failed', params: ["message" => "Updating the Unique ID column may cause issues"]);
                return false;
            }

            $_exists->update([...$data]);

            DB::commit();
            # emitting an event to reload the page
            $this->emit(event: 'file:created');

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());
            $this->emit(event: 'create:failed', params: ["message" => $th->getMessage()]);
            return false;
        }
    }





    /**
     * Format date
     * @param string|null $date
     * @return string|null
     */
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
     * Get the Main reports
     * @return array
     */
    public function download() {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_StoreMaster :procType, :storeFrom, :storeTo, :from, :to', [
            'procType' => 'export',
            'storeFrom' => $this->storeFrom,
            'storeTo' => $this->storeTo,
            'from' => $this->startDate,
            'to' => $this->endDate
        ], $this->perPage, $this->orderBy);
    }



    /**
     * Get the Main reports
     * @return array
     */
    public function getData() {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_StoreMaster :procType, :storeFrom, :storeTo, :from, :to', [
            'procType' => 'main',
            'storeFrom' => $this->storeFrom,
            'storeTo' => $this->storeTo,
            'from' => $this->startDate,
            'to' => $this->endDate
        ], $this->perPage, $this->orderBy);
    }




    /**
     * Render the main Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        return view('livewire.commercial-head.settings.store-master', [
            'datas' => $this->getData(),
        ]);
    }
}
