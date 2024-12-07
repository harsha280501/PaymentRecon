<?php

namespace App\Http\Controllers\CommercialHead\Upload;

use App\Http\Controllers\Controller;

// Request

use App\Interface\MisReadLogsInterface;
use App\Models\BrandNotConsider;
use App\Models\Logs\UploadLog;
use Illuminate\Http\Request;


use App\Models\MFLInwardCashAgencyHCMSBIPos;
use App\Models\MFLInwardCashAgencyMISSBIPos;

use App\Services\ExcelUploadGeneralService;
use App\Services\Upload\ExcelBankStatement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class SBIHCMController extends Controller {


    public function __construct(
        public MisReadLogsInterface $repository
    ) {
    }




    /**
     * Save the file to a location
     * @param mixed $file
     * @return string
     */
    protected function save(\Illuminate\Http\UploadedFile $file): string {
        $destinationPath = storage_path('app/public/commercial/SbiHCMdata');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/SbiHCMdata/') . $file_1_name;
        return $targetPath;
    }





    /**
     * Load the Excel file
     * @param mixed $targetPath
     * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
     */
    protected function excel(string $targetPath): \PhpOffice\PhpSpreadsheet\Spreadsheet {

        $inputFileTypeIdentify = \PhpOffice\PhpSpreadsheet\IOFactory::identify($targetPath);
        $inputFileTypeFormat = ucwords($inputFileTypeIdentify);

        if ($inputFileTypeFormat == 'csv' || $inputFileTypeFormat == 'CSV' || $inputFileTypeFormat == 'Csv') {
            $inputFileType = 'Csv';
        } else if ($inputFileTypeFormat == 'xls' || $inputFileTypeFormat == 'XLS' || $inputFileTypeFormat == 'Xls') {
            $inputFileType = 'Xls';
        } else if ($inputFileTypeFormat == 'xlsx' || $inputFileTypeFormat == 'XLSX' || $inputFileTypeFormat == 'Xlsx') {
            $inputFileType = 'Xlsx';
        }

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);
        return $reader->load($targetPath);
    }





    /**
     * SBI Uploads
     * @return void
     */
    public function hcm(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS|max:9048'
        ]);

        $getorinilfilename = $request->file('file')->getClientOriginalName();

        // checking if the filename is in the db
        if (MFLInwardCashAgencyHCMSBIPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
            return response()->json(['message' => 'The Filename already exists on the Database'], 409);
        }

        $targetFile = $this->save(file: $request->file('file'));
        $spreadsheet = $this->excel(targetPath: $targetFile);
        $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $arrayCount = $spreadsheet->getActiveSheet()->getHighestRow();

        // setting the inserted count to zero
        $this->repository->startFrom(2);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $getorinilfilename,
            "table" => "MFL_Inward_CashAgencyHCM_SBIPos",
            "bank" => "SBI HCM",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {

            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $colBank = "SBI HCM";
                $heirarchyCode = trim($worksheet[$i]["H"]);

                $storedata = ExcelUploadGeneralService::getSBIHCMStoreID($heirarchyCode);
                $retekCode = $storedata->retekCode;
                $storeID = $storedata->storeID;
                $brand = $storedata->brand;

                // assigning missing status from config constants file
                $missingStatus = config('constants.missingStatus.StoreID');

                // getting the Not considered brands
                $NotconsiderArrayBrand = BrandNotConsider::select('brand')->where('isActive', '=', 1)->pluck('brand')->toArray();


                // if everything is correct
                if ($storeID != "" && $retekCode != "") {
                    $missingStatus = 'Valid';
                }

                // if the brand is in Not considered brands
                if (in_array($brand, $NotconsiderArrayBrand)) {
                    $missingStatus = 'NotValid';
                }


                $data = array(
                    "storeID" => $storeID,
                    "retekCode" => $retekCode, // accountNo
                    "colBank" => $colBank,
                    "brand" => $brand,
                    "stateOffice" => trim($worksheet[$i]["A"]),
                    "locationName" => trim($worksheet[$i]["B"]),
                    "cityName" => trim($worksheet[$i]["C"]),
                    "clientName" => trim($worksheet[$i]["D"]),
                    "depositDate" => $this->format(trim($worksheet[$i]["E"])),
                    "HCMCustomerCode" => trim($worksheet[$i]["F"]),
                    "frequency" => trim($worksheet[$i]["G"]),
                    "heirarchyCode1" => trim($worksheet[$i]["H"]),
                    "accountCode" => trim($worksheet[$i]["I"]),
                    "customerName" => trim($worksheet[$i]["J"]),
                    "area" => trim($worksheet[$i]["K"]),
                    "cashPickupLimit" => trim($worksheet[$i]["L"]),
                    "depositSlipNo" => trim($worksheet[$i]["M"]),
                    "scratchCardSlipNumber" => trim($worksheet[$i]["N"]),
                    "cashPickupAmount" => trim($worksheet[$i]["O"]),
                    "DENOM_2000" => trim($worksheet[$i]["P"]),
                    "DENOM_1000" => trim($worksheet[$i]["Q"]),
                    "DENOM_500" => trim($worksheet[$i]["R"]),
                    "DENOM_200" => trim($worksheet[$i]["S"]),
                    "DENOM_100" => trim($worksheet[$i]["T"]),
                    "DENOM_50" => trim($worksheet[$i]["U"]),
                    "DENOM_20" => trim($worksheet[$i]["V"]),
                    "DENOM_10" => trim($worksheet[$i]["W"]),
                    "DENOM_5" => trim($worksheet[$i]["X"]),
                    "DENOM_2" => trim($worksheet[$i]["Y"]),
                    "DENOM_1" => trim($worksheet[$i]["Z"]),
                    "others" => trim($worksheet[$i]["AA"]),
                    "total" => trim($worksheet[$i]["AB"]),
                    "remarks" => trim($worksheet[$i]["AC"]),
                    "authorizationStatus" => trim($worksheet[$i]["AD"]),
                    "filename" => $getorinilfilename,
                    "createdBy" => Auth::id(),
                    "missingRemarks" => $missingStatus,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );



                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '') {
                    if (MFLInwardCashAgencyHCMSBIPos::insert($data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }
            }

            // finializing the logs
            $this->repository->finializeLog();
            return response()->json(['message' => 'Success'], 200);

        } catch (\Throwable $exception) {

            $this->repository->failedLog($exception);
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }






    /**
     * SBI Uploads
     * @return void
     */
    public function hcm2(Request $request) {


        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS|max:9048'
        ]);

        $getorinilfilename = $request->file('file')->getClientOriginalName();

        // checking if the filename is in the db
        if (MFLInwardCashAgencyHCMSBIPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
            return response()->json(['message' => 'The Filename already exists on the Database'], 409);
        }

        $targetFile = $this->save(file: $request->file('file'));
        $spreadsheet = $this->excel(targetPath: $targetFile);
        $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $arrayCount = $spreadsheet->getActiveSheet()->getHighestRow();

        // setting the inserted count to zero
        $this->repository->startFrom(2);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $getorinilfilename,
            "table" => "MFL_Inward_CashAgencyHCM_SBIPos",
            "bank" => "SBI HCM",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {

            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $colBank = "SBI HCM";
                $heirarchyCode = trim($worksheet[$i]["H"]);

                $storedata = ExcelUploadGeneralService::getSBIHCMStoreID($heirarchyCode);
                $retekCode = $storedata->retekCode;
                $storeID = $storedata->storeID;
                $brand = $storedata->brand;

                // assigning missing status from config constants file
                $missingStatus = config('constants.missingStatus.StoreID');

                // getting the Not considered brands
                $NotconsiderArrayBrand = BrandNotConsider::select('brand')->where('isActive', '=', 1)->pluck('brand')->toArray();


                // if everything is correct
                if ($storeID != "" && $retekCode != "") {
                    $missingStatus = 'Valid';
                }

                // if the brand is in Not considered brands
                if (in_array($brand, $NotconsiderArrayBrand)) {
                    $missingStatus = 'NotValid';
                }


                $data = array(
                    "storeID" => $storeID,
                    "retekCode" => $retekCode, // accountNo
                    "colBank" => $colBank,
                    "brand" => $brand,
                    "stateOffice" => trim($worksheet[$i]["B"]),
                    "locationName" => trim($worksheet[$i]["AG"]),
                    "cityName" => trim($worksheet[$i]["C"]),
                    "clientName" => trim($worksheet[$i]["D"]),
                    "depositDate" => $this->format(trim($worksheet[$i]["E"])),
                    "HCMCustomerCode" => trim($worksheet[$i]["F"]),
                    "frequency" => trim($worksheet[$i]["G"]),
                    "heirarchyCode1" => trim($worksheet[$i]["H"]),
                    "accountCode" => trim($worksheet[$i]["I"]),
                    "customerName" => trim($worksheet[$i]["J"]),
                    "area" => trim($worksheet[$i]["K"]),
                    // "cashPickupLimit" => trim($worksheet[$i]["L"]),
                    "depositSlipNo" => trim($worksheet[$i]["L"]),
                    "scratchCardSlipNumber" => trim($worksheet[$i]["M"]),
                    "cashPickupAmount" => trim($worksheet[$i]["N"]),
                    "DENOM_2000" => trim($worksheet[$i]["O"]),
                    "DENOM_1000" => trim($worksheet[$i]["P"]),
                    "DENOM_500" => trim($worksheet[$i]["Q"]),
                    "DENOM_200" => trim($worksheet[$i]["R"]),
                    "DENOM_100" => trim($worksheet[$i]["S"]),
                    "DENOM_50" => trim($worksheet[$i]["T"]),
                    "DENOM_20" => trim($worksheet[$i]["U"]),
                    "DENOM_10" => trim($worksheet[$i]["V"]),
                    "DENOM_5" => trim($worksheet[$i]["W"]),
                    "DENOM_2" => trim($worksheet[$i]["X"]),
                    "DENOM_1" => trim($worksheet[$i]["Y"]),
                    "others" => trim($worksheet[$i]["Z"]),
                    "total" => trim($worksheet[$i]["AA"]),
                    "remarks" => trim($worksheet[$i]["AC"]),
                    "callStatus" => trim($worksheet[$i]["AD"]),
                    "CRNNo" => trim($worksheet[$i]["AE"]),
                    "Region" => trim($worksheet[$i]["AF"]),
                    "depositType" => trim($worksheet[$i]["AH"]),
                    "OTPStatus" => trim($worksheet[$i]["AI"]),
                    "filename" => $getorinilfilename,
                    "createdBy" => Auth::id(),
                    "missingRemarks" => $missingStatus,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );



                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '') {
                    if (MFLInwardCashAgencyHCMSBIPos::insert($data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }
            }

            // finializing the logs
            $this->repository->finializeLog();
            return response()->json(['message' => 'Success'], 200);

        } catch (\Throwable $exception) {

            $this->repository->failedLog($exception);
            return response()->json(['message' => $exception->getMessage()], 500);
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
     * Get the file extensions
     * @param string $filename
     * @return string
     */
    public function getFileType(string $filename): string {
        return isset(explode('.', $filename)[1]) ? explode('.', $filename)[1] : null;
    }

}