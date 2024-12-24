<?php

namespace App\Http\Controllers\CommercialHead\Upload;

use App\Http\Controllers\Controller;

// Request

use App\Interface\MisReadLogsInterface;
use App\Models\BrandNotConsider;
use Illuminate\Http\Request;

// Model
use App\Models\MFLInwardCashMIS2SBIPos;
use App\Models\MFLInwardCashMISSBIMumbai;
use App\Services\ParseDateService;
use App\Services\ExcelUploadGeneralService;
use App\Traits\GenerateTotalHTML;
// Others

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SBICASHMISController extends Controller {

    use GenerateTotalHTML;

    public function __construct(
        public MisReadLogsInterface $repository
    ) {
    }



    /**
     * SBI Uploads
     * @return void
     */
    public function importSBICashMIS2Data(Request $request) {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:25048'
        ]);

        // Retrieve the uploaded file
        $file = $request->file('file');

        $destinationPath = storage_path('app/public/commercial/SbiCashdata');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/SbiCashdata/') . $file_1_name;


        // checking if the filename is in the db
        if (MFLInwardCashMIS2SBIPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
            return response()->json(['message' => 'The Filename already exists on the Database'], 409);
        }



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
        $spreadsheet = $reader->load($targetPath);
        $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

        $error_msgs_arr = array();

        // setting the inserted count to zero
        $this->repository->startFrom(2);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_inward_CashMIS2_SBIPos",
            "bank" => "SBICASHMIS2",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {

            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $col_bank = config('constants.SBICASHMIS.ColBank');
                // bankName
                $SRNo = trim($worksheet[$i]["A"]); // Sr No
                $UTR = trim($worksheet[$i]["B"]); // UTR
                $VAN = trim($worksheet[$i]["C"]); // VAN
                $depositAmount = trim(str_replace(',', '', $worksheet[$i]["D"])); // Amount
                $deposit_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["S"]), 'SBI Cash MIS'); // Input Date
                $chequeDate = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["E"]), 'SBI Cash MIS'); // Cheque Date
                $chequeNumber = trim($worksheet[$i]["F"]); // Cheque Number
                $corpName = trim($worksheet[$i]["G"]); // Corp Name
                $corporateID = trim($worksheet[$i]["H"]); // Corporate ID
                $creditAccountNumber = trim($worksheet[$i]["I"]); // Credit Account Number
                $creditTime = trim($worksheet[$i]["J"]); // Credit Time (HH24:MI:SS) 
                $creditCancelDate = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["K"]), 'SBI Cash MIS'); // Credit/Cancel Date
                $dealerAmount = trim(str_replace(',', '', is_numeric($worksheet[$i]["L"]) ? $worksheet[$i]["L"] : 0)); // Dealer Amount
                $dealerCode_get = trim($worksheet[$i]["M"]); // Dealer Code
                $dealerCode = is_numeric($dealerCode_get) ? $dealerCode_get : 0; // if not numeric set it as zero

                $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($dealerCode);

                $retakeCode = $storedata['RETEK Code'];
                $storeID = $storedata['Store ID'];
                $brand = $storedata['Brand Desc'];


                $dealerName = trim($worksheet[$i]["N"]); // Dealer Name
                $depositBranchCodeCDM = trim($worksheet[$i]["O"]); // Deposit Branch Code/CDM
                $depositBranchName = trim($worksheet[$i]["P"]); // Deposit Branch Name
                $district = trim($worksheet[$i]["Q"]); // District
                $fileNameExcel = trim($worksheet[$i]["R"]); // File Name
                $inputMode = trim($worksheet[$i]["T"]); // Input Mode
                $pinCode = trim($worksheet[$i]["U"]); // Pin Code
                $presentationDate = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["V"]), 'SBI Cash MIS'); // Presentation Date
                $product = trim($worksheet[$i]["W"]); // Product
                $regionName = trim($worksheet[$i]["X"]); // Region Name
                $reportGenerationDate = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["Y"]), 'SBI Cash MIS'); // Report Generation Date
                $returnReason = trim($worksheet[$i]["Z"]); // Return Reason

                $senderAccountName = trim($worksheet[$i]["AA"]); // Sender Account Name
                $senderAccountNumber = trim($worksheet[$i]["AB"]); // Sender Account Number
                $senderBank = trim($worksheet[$i]["AC"]); // Sender Bank
                $senderBankLocation = trim($worksheet[$i]["AD"]); // Sender Bank Location
                $senderIFSC = trim($worksheet[$i]["AE"]); // Sender IFSC
                $transactionStatus = trim($worksheet[$i]["AF"]); // Transaction Status
                $uniqueReferenceNumber = trim($worksheet[$i]["AG"]); // Unique Reference Number

                $userId = Auth::id();

                // assigning missing status from config constants file
                $missingStatus = config('constants.missingStatus.StoreID');

                // getting the Not considered brands
                $NotconsiderArrayBrand = BrandNotConsider::select('brand')->where('isActive', '=', 1)->pluck('brand')->toArray();


                // if everything is correct
                if ($storeID != "" && $retakeCode != "") {
                    $missingStatus = 'Valid';
                }

                // if the brand is in Not considered brands
                if (in_array($brand, $NotconsiderArrayBrand)) {
                    $missingStatus = 'NotValid';
                }


                $data = array(
                    "storeID" => $storeID,
                    "retekCode" => $retakeCode,
                    "colBank" => $col_bank,
                    "brand" => $brand,
                    "SRNo" => $SRNo,
                    "UTR" => $UTR,
                    "VAN" => $VAN,
                    "depositAmount" => $depositAmount,
                    "depositDt" => $deposit_dt,
                    "chequeDate" => $chequeDate,
                    "chequeNumber" => $chequeNumber,
                    "corpName" => $corpName,
                    "corporateID" => $corporateID,
                    "creditAccountNumber" => $creditAccountNumber,
                    "creditTime" => $creditTime,
                    "creditCancelDate" => $creditCancelDate,
                    "dealerAmount" => $dealerAmount,
                    "dealerCode" => $dealerCode,
                    "dealerName" => $dealerName,
                    "depositBranchCodeCDM" => $depositBranchCodeCDM,
                    "depositBranchName" => $depositBranchName,
                    "district" => $district,
                    "fileNameExcel" => $fileNameExcel,
                    "inputMode" => $inputMode,
                    "pinCode" => $pinCode,
                    "presentationDate" => $presentationDate,
                    "product" => $product,
                    "regionName" => $regionName,
                    "reportGenerationDate" => $reportGenerationDate,
                    "returnReason" => $returnReason,
                    "senderAccountName" => $senderAccountName,
                    "senderAccountNumber" => $senderAccountNumber,
                    "senderBank" => $senderBank,
                    "senderBankLocation" => $senderBankLocation,
                    "senderIFSC" => $senderIFSC,
                    "transactionStatus" => $transactionStatus,
                    "uniqueReferenceNumber" => $uniqueReferenceNumber,
                    "missingRemarks" => $missingStatus,
                    "filename" => $file_1_name,
                    "createdBy" => $userId,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );



                if ($SRNo != '' && $UTR != '') {
                    if (MFLInwardCashMIS2SBIPos::Insert($data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }
            }

            // finializing the logs
            $this->repository->finializeLog();

            return response()->json([
                'message' => 'Success',
                "data" => $this->generateHTML(function () use ($getorinilfilename) {
                    return MFLInwardCashMIS2SBIPos::select(
                        'depositAmount',
                        'missingRemarks',
                        DB::raw('ISNULL(depositDt, NULL) as depositDt'),
                        DB::raw('ISNULL(chequeDate, NULL) as crDt')
                    )->where('filename', 'like', '%' . $getorinilfilename . '%')->get();
                })
            ], 200);

        } catch (\Throwable $exception) {
            $this->repository->failedLog($exception);
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }








    public function importSBICashMISMumbai(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:25048'
        ]);

        // Retrieve the uploaded file
        $file = $request->file('file');

        $destinationPath = storage_path('app/public/commercial/SbiCashMumbaidata');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/SbiCashMumbaidata/') . $file_1_name;


        // checking if the filename is in the db
        if (MFLInwardCashMISSBIMumbai::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
            return response()->json(['message' => 'The Filename already exists on the Database'], 409);
        }


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
        $spreadsheet = $reader->load($targetPath);
        $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

        $error_msgs_arr = array();

        // setting the inserted count to zero
        $this->repository->startFrom(2);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_Inward_CashMIS_SBI_Mumbai",
            "bank" => "SBICASHMumbai",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {

            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $colBank = config('constants.SBICASHMIS.ColBankMumbai');
                $depositDate = ParseDateService::formatDate(trim($worksheet[$i]["A"])); // Date
                $depositAmount = trim(str_replace(',', '', is_numeric($worksheet[$i]["I"]) ? $worksheet[$i]["I"] : 0)); // Pick up Amount..

                $dealerCode_get = trim($worksheet[$i]["F"]); // Customer Point Code
                $dealerCode = is_numeric($dealerCode_get) ? $dealerCode_get : 0; // if not numeric set it as zero
                $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($dealerCode);

                $retakeCode = $storedata['RETEK Code'];
                $storeID = $storedata['Store ID'];
                $brand = $storedata['Brand Desc'];
                $shopID = trim($worksheet[$i]["B"]); // Shop ID
                $clientName = trim($worksheet[$i]["C"]); // Client Name
                $customerName = trim($worksheet[$i]["D"]); // Cust Name
                $customerCode = trim($worksheet[$i]["E"]); // Customer Code
                $locationName = trim($worksheet[$i]["G"]); // Location Name
                $sealTagNo = trim($worksheet[$i]["H"]); // Seal Tag No.

                $userId = Auth::id();

                // assigning missing status from config constants file
                $missingStatus = config('constants.missingStatus.StoreID');

                // getting the Not considered brands
                $NotconsiderArrayBrand = BrandNotConsider::select('brand')->where('isActive', '=', 1)->pluck('brand')->toArray();


                // if everything is correct
                if ($storeID != "" && $retakeCode != "") {
                    $missingStatus = 'Valid';
                }

                // if the brand is in Not considered brands
                if (in_array($brand, $NotconsiderArrayBrand)) {
                    $missingStatus = 'NotValid';
                }


                $data = array(
                    "storeID" => $storeID,
                    "retekCode" => $retakeCode,
                    "colBank" => $colBank,
                    "brand" => $brand,
                    "depositAmount" => $depositAmount,
                    "depositDate" => $depositDate,
                    "shopID" => $shopID,
                    "clientName" => $clientName,
                    "customerName" => $customerName,
                    "customerCode" => $customerCode,
                    "customerPointCode" => $dealerCode_get,
                    "locationName" => $locationName,
                    "sealTagNo" => $sealTagNo,
                    "missingRemarks" => $missingStatus,
                    "filename" => $file_1_name,
                    "createdBy" => $userId,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );




                if ($depositDate != '' && $shopID != '') {
                    if (MFLInwardCashMISSBIMumbai::Insert($data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }
            }

            // finializing the logs
            $this->repository->finializeLog();

            return response()->json([
                'message' => 'Success',
                "data" => $this->generateHTML(function () use ($getorinilfilename) {
                    return MFLInwardCashMISSBIMumbai::select(
                        'depositAmount',
                        'missingRemarks',
                        DB::raw('ISNULL(depositDt, NULL) as depositDt'),
                        DB::raw('ISNULL(chequeDate, NULL) as crDt')
                    )->where('filename', 'like', '%' . $getorinilfilename . '%')->get();
                })
            ], 200);

        } catch (\Throwable $exception) {
            $this->repository->failedLog($exception);
            return response()->json(['message' => $exception->getMessage()], 500);
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