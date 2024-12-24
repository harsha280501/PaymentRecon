<?php

namespace App\Http\Controllers\CommercialHead\Upload;

use App\Http\Controllers\Controller;
use App\Imports\CommercialHead\Uploads\HDFC\CashUpload;
use App\Interface\MisReadLogsInterface;
use App\Models\BrandNotConsider;
use App\Models\Config as ModelsConfig;
// Request

use App\Models\Logs\UploadLog;
use App\Models\MFLInwardCashMISHdfcPos;
use App\Traits\GenerateTotalHTML;
use Illuminate\Http\Request;

// Response

use Illuminate\Http\RedirectResponse;

// Model

use App\Models\MRepository;
use App\Models\MFLInwardCardMISHdfcPos;
use App\Models\MFLInwardUPIMISHdfcPos;
use App\Services\ExcelUploadGeneralService;
// Exception

use Exception;

// Services

use App\Services\GeneralService;
use App\Services\ParseDateService;
// Others

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HDFCController extends Controller {

    use GenerateTotalHTML;


    public function __construct(
        public MisReadLogsInterface $repository
    ) {
    }



    public function importHdfcCardData(Request $request) {

        // validating files
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        // getting the filename
        $file = $request->file('file');
        $input_file_name = $request->file('file')->getClientOriginalName();

        // finding account number
        $fileName = pathinfo($input_file_name, PATHINFO_FILENAME);
        $namearr = explode("-", $fileName);
        $acct_no = config('constants.HDFC.cardaccountNumber');

        // getting the account number
        if (count($namearr) > 1) {
            $acct_no = $namearr[0];
        }

        // getting the account number
        if (count($namearr) == 1) {
            $namearr = explode("_", $fileName);
            $acct_no = $namearr[0];
        }

        // store path
        $destinationPath = storage_path('app/public/commercial/hdfccarddata');
        // origninal file name
        $getorinilfilename = $file->getClientOriginalName();

        // main file name
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
        // moving the file to the destination
        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/hdfccarddata/') . $file_1_name;

        // dd(MFLInwardCardMISHdfcPos::where('filename', 'like', '%' . $getorinilfilename . '%')->get());
        // checking if the filename is in the db
        if (MFLInwardCardMISHdfcPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
            return response()->json(['message' => 'The Filename already exists on the Card Database, (Card)'], 409);
        }

        // checking if the filename exists on the DB for UPI
        if (MFLInwardUPIMISHdfcPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
            return response()->json(['message' => 'The Filename already exists on the Database, (UPI)'], 409);
        }

        // find the file type
        $inputFileTypeIdentify = \PhpOffice\PhpSpreadsheet\IOFactory::identify($targetPath);
        $inputFileTypeFormat = ucwords($inputFileTypeIdentify);

        // creating a reader for the provided filetype
        if ($inputFileTypeFormat == 'csv' || $inputFileTypeFormat == 'CSV' || $inputFileTypeFormat == 'Csv') {
            $inputFileType = 'Csv';
        } else if ($inputFileTypeFormat == 'xls' || $inputFileTypeFormat == 'XLS' || $inputFileTypeFormat == 'Xls') {
            $inputFileType = 'Xls';
        } else if ($inputFileTypeFormat == 'xlsx' || $inputFileTypeFormat == 'XLSX' || $inputFileTypeFormat == 'Xlsx') {
            $inputFileType = 'Xlsx';
        }

        // main reader
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);

        // loading the file
        $spreadsheet = $reader->load($targetPath);
        $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        // length of the array

        // setting the inserted count to zero
        $this->repository->startFrom(2);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_Inward_CardMIS_HdfcPos",
            "bank" => "HDFC Card",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

        try {
            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {
                $col_bank = config('constants.HDFC.cardBankName'); // bankName

                $merCode = trim(str_replace("'", '', $worksheet[$i]["A"])); //POS_ID
                $tid = trim(str_replace("'", '', $worksheet[$i]["B"])); //TERMINAL NUMBER

                $crDt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["H"])), 'HDFC Card');
                $depositDt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["G"])), 'HDFC Card');

                // dd($depositDt); # YYYYMMDD | null 
                # if deposit Date is null then use credit date - 1
                if (!$depositDt) { # deposit isnull # check if the deposit date is null
                    $depositDt = Carbon::parse($crDt)->subDays(value: 1)->format('Y-m-d'); # dateadd(day, -1, getdate())
                }


                $storedata = ExcelUploadGeneralService::getReteckCodeUsingTIDForHDFC(tid: $tid, transactionDt: $depositDt);

                $retekCode = $storedata['retekCode'];
                $storeID = $storedata['storeID'];
                $brand = $storedata['brandName'];

                $intnlAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$i]["J"]))); //INTNL AMT
                $domesticAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$i]["K"]))); //DOMESTIC AMT
                $depositAmount = $intnlAmt + $domesticAmt; //DEPOSIT AMT

                $msfComm = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$i]["O"]))); //MSF
                $cgstAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$i]["S"]))); //CGST AMT

                $sgstAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$i]["T"]))); //SGST AMT

                $igstAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$i]["U"]))); //IGST AMT
                $ugstAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$i]["V"]))); //UTGST AMT
                $netAmount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$i]["W"]))); //Net Amount

                $cardTypes = trim(str_replace("'", '', $worksheet[$i]["E"])); //CARD TYPE
                $cardNumber = trim(str_replace("'", '', $worksheet[$i]["F"])); //CARD NUMBER
                $approvCode = trim(str_replace("'", '', $worksheet[$i]["I"])); //APPROV CODE
                $servTax = trim(str_replace("'", '', $worksheet[$i]["P"])); //SERV TAX

                $sbCess = trim(str_replace("'", '', $worksheet[$i]["Q"])); //SB Cess
                $kkCess = trim(str_replace("'", '', $worksheet[$i]["R"])); //KK Cess
                $drCrType = trim(str_replace("'", '', $worksheet[$i]["X"])); //DEBITCREDIT_TYPE
                $arn_no = trim(str_replace("'", '', $worksheet[$i]["Y"])); //ARN NO

                $recFmt = trim(str_replace("'", '', $worksheet[$i]["C"])); //REC FMT
                $bat_nbr = trim(str_replace("'", '', $worksheet[$i]["D"])); //BAT NBR
                $tran_id = trim(str_replace("'", '', $worksheet[$i]["L"])); //TRAN_ID
                $upValue = trim(str_replace("'", '', $worksheet[$i]["M"])); //UPVALUE

                $merchantTrackId = trim(str_replace("'", '', $worksheet[$i]["N"])); //MERCHANT_TRACKID
                $invoiceNumber = trim(str_replace("'", '', $worksheet[$i]["Z"])); //INVOICE_NUMBER
                $gstnTransactionId = trim(str_replace("'", '', $worksheet[$i]["AA"])); //GSTN_TRANSACTION_ID
                $udf1 = trim(str_replace("'", '', $worksheet[$i]["AB"])); //UDF1
                $udf2 = trim(str_replace("'", '', $worksheet[$i]["AC"])); //UDF2
                $udf3 = trim(str_replace("'", '', $worksheet[$i]["AD"])); //UDF3
                $udf4 = trim(str_replace("'", '', $worksheet[$i]["AE"])); //UDF4
                $udf5 = trim(str_replace("'", '', $worksheet[$i]["AF"])); //UDF5
                $sequence_number = trim(str_replace("'", '', $worksheet[$i]["AG"])); //SEQUENCE NUMBER


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
                    "retekCode" => $retekCode,
                    "brand" => $brand,
                    "colBank" => $col_bank,
                    "acctNo" => $acct_no,
                    "merCode" => $merCode, // MERCHANT CODE
                    "tid" => $tid, // TERMINAL NUMBER
                    "depositDt" => $depositDt, // TRANS DATE
                    "crDt" => $crDt, // SETTLE DATE
                    "intnlAmt" => $intnlAmt, // INTNL AMT
                    "domesticAmt" => $domesticAmt, // DOMESTIC AMT
                    "depositAmount" => $depositAmount, //DEPOSIT AMT
                    "msfComm" => $msfComm, // MSF
                    "cgstAmt" => $cgstAmt, // CGST AMT
                    "sgstAmt" => $sgstAmt, // SGST AMT
                    "igstAmt" => $igstAmt, // IGST AMT
                    "ugstAmt" => $ugstAmt, // UTGST AMT
                    "netAmount" => $netAmount, // Net Amount
                    "cardTypes" => $cardTypes, // CARD TYPE
                    "cardNumber" => $cardNumber, // CARD NUMBER
                    "approvCode" => $approvCode, // APPROV CODE
                    "servTax" => $servTax, // SERV TAX
                    "sbCess" => $sbCess, // SB Cess
                    "kkCess" => $kkCess, // KK Cess
                    "drCrType" => $drCrType, // DEBITCREDIT_TYPE
                    "arn_no" => $arn_no, // ARN NO
                    "recFmt" => $recFmt, // REC FMT
                    "bat_nbr" => $bat_nbr, // BAT NBR
                    "tran_id" => $tran_id, // TRAN_ID
                    "upValue" => $upValue, // UPVALUE
                    "merchantTrackId" => $merchantTrackId, // MERCHANT_TRACKID
                    "invoiceNumber" => $invoiceNumber, // INVOICE_NUMBER
                    "gstnTransactionId" => $gstnTransactionId, // GSTN_TRANSACTION_ID
                    "udf1" => $udf1, //UDF1
                    "udf2" => $udf2, //UDF2
                    "udf3" => $udf3, //UDF3
                    "udf4" => $udf4, //UDF4
                    "udf5" => $udf3, //UDF5
                    "sequence_number" => $sequence_number, //SEQUENCE NUMBER
                    "filename" => $file_1_name,
                    "createdBy" => Auth::id(),
                    "missingRemarks" => $missingStatus,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );


                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '' && trim($worksheet[$i]["C"]) != '' && trim($worksheet[$i]["D"]) != '') {
                    if (MFLInwardCardMISHdfcPos::Insert($data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }

                //upi
                $UPITransaction = trim($worksheet[$i + 1]["A"]);

                if ($UPITransaction == "UPI TRANSACTIONS") {
                    $this->repository->skips(3);

                    for ($j = $i + 3; $j <= $arrayCount; $j++) {
                        $col_bankUPI = config('constants.HDFC.UPIBankName'); // bankName

                        $acct_noUPI = config('constants.HDFC.upiaccountNumber');
                        if (count($namearr) > 1) {
                            $acct_noUPI = $namearr[0];
                        }

                        if (count($namearr) == 1) {
                            $namearr = explode("_", $fileName);
                            $acct_noUPI = $namearr[0];
                        }

                        $cardmerCode = trim(str_replace("'", '', $worksheet[$j]["A"])); //EXTERNAL MID
                        $cardtid = trim(str_replace("'", '', $worksheet[$j]["B"])); //EXTERNAL TID
                        $cardmid = trim(str_replace("'", '', $worksheet[$j]["C"])); //UPI Merchant ID                      


                        $cardcrDt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$j]["K"])), 'HDFC UPI'); //Settlement Date
                        $carddepositDt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$j]["J"])), 'HDFC UPI'); //Transaction Req Date

                        if (!$carddepositDt) { # deposit isnull # check if the deposit date is null
                            $carddepositDt = Carbon::parse($cardcrDt)->subDays(value: 1)->format('Y-m-d'); # dateadd(day, -1, getdate())
                        }
                        $cardstoredata = ExcelUploadGeneralService::getReteckCodeUsingTIDForHDFC($cardtid, $cardcrDt);
                        $cardretekCode = $cardstoredata['retekCode'];
                        $cardstoreID = $cardstoredata['storeID'];
                        $cardBrand = $cardstoredata['brandName'];

                        $carddepositAmount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$j]["M"]))); //Transaction Amount                        

                        $cardmsfComm = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$j]["N"]))); //MSF Amount
                        $cardcgstAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$j]["O"]))); //CGST AMTT AMT
                        $cardsgstAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$j]["P"]))); //SGST AMT

                        $cardigstAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$j]["Q"]))); //IGST AMT
                        $cardugstAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$j]["R"]))); //UTGST AMT
                        $cardnetAmount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(trim(str_replace("'", '', $worksheet[$j]["S"]))); //Net Amount

                        $cardarnNo = trim(str_replace("'", '', $worksheet[$j]["I"])); //Txn ref no.(RRN)
                        $cardtranId = trim(str_replace("'", '', $worksheet[$j]["G"])); //UPI Trxn ID
                        $cardinvoiceNumber = trim(str_replace("'", '', $worksheet[$j]["T"])); //// GST Invoice No

                        $cardudf1 = trim(str_replace("'", '', $worksheet[$j]["X"])); //Txn ref no.(RRN)
                        $cardudf2 = trim(str_replace("'", '', $worksheet[$j]["Y"])); //UPI Trxn ID
                        $cardudf3 = trim(str_replace("'", '', $worksheet[$j]["Z"])); //// UDF3
                        $cardudf4 = trim(str_replace("'", '', $worksheet[$j]["AA"])); //// UDF4
                        $cardudf5 = trim(str_replace("'", '', $worksheet[$j]["AB"])); //// UDF5
                        $cardcrdr = trim(str_replace("'", '', $worksheet[$j]["W"])); //// UDF5

                        $cardtranType = trim(str_replace("'", '', $worksheet[$j]["U"])); //Trans Type
                        $cardmerchantName = trim(str_replace("'", '', $worksheet[$j]["D"])); //Merchant Name
                        $cardmerchantVpa = trim(str_replace("'", '', $worksheet[$j]["E"])); //// Merchant VPA
                        $cardpayerVpa = trim(str_replace("'", '', $worksheet[$j]["F"])); //// Payer VPA
                        $cardorderId = trim(str_replace("'", '', $worksheet[$j]["H"])); //// orderId
                        $cardcurrency = trim(str_replace("'", '', $worksheet[$j]["L"])); //// 


                        // assigning missing status from config constants file
                        $UPImissingStatus = config('constants.missingStatus.StoreID');

                        // getting the Not considered brands
                        $UPINotconsiderArrayBrand = BrandNotConsider::select('brand')->where('isActive', '=', 1)->pluck('brand')->toArray();

                        // if everything is correct
                        if ($cardstoreID != "" && $cardretekCode != "") {
                            $UPImissingStatus = 'Valid';
                        }

                        // if the brand is in Not considered brands
                        if (in_array($brand, $UPINotconsiderArrayBrand)) {
                            $UPImissingStatus = 'NotValid';
                        }

                        $data = array(
                            "storeID" => $cardstoreID,
                            "retekCode" => $cardretekCode,
                            'col_bank' => $col_bankUPI,
                            "brand" => $cardBrand,
                            "acctNo" => $acct_noUPI,
                            "merCode" => $cardmerCode, // EXTERNAL MID
                            "tid" => $cardtid, // EXTERNAL TID
                            "mid" => $cardmid, // UPI Merchant ID
                            "depositDt" => $carddepositDt, // Transaction Req Date
                            "crDt" => $cardcrDt, // Settlement Date
                            "depositAmount" => $carddepositAmount, // 
                            "msfComm" => $cardmsfComm, // MSF Amount
                            "cgstAmt" => $cardcgstAmt, // CGST AMT
                            "sgstAmt" => $cardsgstAmt, // SGST AMT
                            "igstAmt" => $cardigstAmt, // IGST AMT
                            "ugstAmt" => $cardugstAmt, // UTGST AMT
                            "netAmount" => $cardnetAmount, // Net Amount
                            "arnNo" => $cardarnNo, // Txn ref no.(RRN)
                            "tranId" => $cardtranId, // UPI Trxn ID
                            "invoiceNumber" => $cardinvoiceNumber, // GST Invoice No
                            "udf1" => $cardudf1, //UDF1
                            "udf2" => $cardudf2, //UDF2
                            "udf3" => $cardudf3, //UDF3
                            "udf4" => $cardudf4, //UDF4
                            "udf5" => $cardudf5, //UDF5
                            "crdr" => $cardcrdr, //UDF5

                            "tranType" => $cardtranType, // Trans Type
                            "merchantName" => $cardmerchantName, // Merchant Name
                            "merchantVpa" => $cardmerchantVpa, // Merchant VPA
                            "payerVpa" => $cardpayerVpa, // Payer VPA
                            "orderId" => $cardorderId, // Order ID
                            "currency" => $cardcurrency, // Currency
                            "filename" => $file_1_name,
                            "createdBy" => Auth::id(),
                            "missingRemarks" => $UPImissingStatus,
                            'isActive' => '1',
                            'createdDate' => now()->format('Y-m-d')
                        );


                        if (trim($worksheet[$j]["A"]) != '' && trim($worksheet[$j]["B"]) != '' && trim($worksheet[$j]["C"]) != '' && trim($worksheet[$j]["D"]) != '') {
                            if (MFLInwardUPIMISHdfcPos::Insert($data)) {
                                $this->repository->increamentInsertedCount();
                            }
                        }
                    }
                    $i = $j;
                }

            }
            // finializing the logs
            $this->repository->finializeLog();
            // get the file count


            // Return response with updated HTML
            return response()->json([
                'message' => 'Success',
                "data" => $this->generateHTML(function () use ($getorinilfilename) {
                    $query1 = MFLInwardCardMISHdfcPos::select(
                        'depositAmount',
                        'missingRemarks',
                        DB::raw('ISNULL(depositDt, NULL) as depositDt'),
                        DB::raw('ISNULL(crDt, NULL) as crDt')
                    )
                        ->where('filename', 'like', '%' . $getorinilfilename . '%');

                    $query2 = MFLInwardUPIMISHdfcPos::select(
                        'depositAmount',
                        'missingRemarks',
                        DB::raw('ISNULL(depositDt, NULL) as depositDt'),
                        DB::raw('ISNULL(crDt, NULL) as crDt')
                    )->where('filename', 'like', '%' . $getorinilfilename . '%');

                    // Perform the union
                    $unionQuery = $query1->unionAll($query2);

                    // Execute and get the count of results along with selected columns
                    return DB::table(DB::raw("({$unionQuery->toSql()}) as unioned"))
                        ->mergeBindings($unionQuery->getQuery())
                        ->get();
                })
            ], 200);


        } catch (\Throwable $exception) {
            $this->repository->failedLog($exception);
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }



    public function importHdfcCashData(Request $request) {
        // importing the data
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        // getting the file
        $file = $request->file('file');
        $destinationPath = storage_path('app/public/commercial/hdfcCashdata');

        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/hdfcCashdata/') . $file_1_name;

        // checking if the filename is in the db
        if (MFLInwardCashMISHdfcPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
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
        // Here get total count of row in that Excel sheet
        $arrayCount = count($worksheet);


        // setting the inserted count to zero
        $this->repository->startFrom(3);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_Inward_CashMIS_HdfcPos",
            "bank" => "HDFC Cash",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {
            // looping entire excel records
            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {
                // bank Name
                $colBank = config('constants.HDFC.cashBankName');

                $row_type = trim(str_replace("'", '', $worksheet[$i]["A"])); // Row Type
                $entryId = trim(str_replace("'", '', $worksheet[$i]["B"])); // entry_id
                $dr_cr = trim(str_replace("'", '', $worksheet[$i]["D"])); //dr_cr
                $depositAmount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["E"]))); //entry_amt
                $crDt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["F"])), 'HDFC Cash MIS'); // val_dt
                $depositDt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["G"])), 'HDFC Cash MIS'); // post_dt

                # if deposit Date is null then use credit date - 1
                if (!$depositDt) { # check if the deposit date is null
                    $depositDt = Carbon::parse($crDt)->subDays(value: 1); # dateadd(day, -1, getdate())
                }
                $prodCode = trim(str_replace("'", '', $worksheet[$i]["H"])); //prod_code


                if (trim($worksheet[$i]["I"]) == "Susari" && !is_numeric(trim($worksheet[$i]["J"]))) {

                    $locationName = trim($worksheet[$i]["I"]) . ' ' . trim($worksheet[$i]["J"]) . ' ' . trim($worksheet[$i]["K"]); // pkup_loc

                    $pkupPtCode = trim(str_replace("'", '', $worksheet[$i]["L"]));

                    $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($pkupPtCode);
                    $retakCode = $storedata['RETEK Code'];
                    $storeID = $storedata['Store ID'];
                    $brand = $storedata['Brand Desc'];


                    $deptDate = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["O"])), 'HDFC Cash MIS'); // dept_dt
                    $pooledDeptAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["P"]))); //dept_amt
                    $no_of_inst = trim(str_replace("'", '', $worksheet[$i]["Q"]));
                    $remarks1 = trim(str_replace("'", '', $worksheet[$i]["R"])); // remarks1
                    $remarks2 = trim(str_replace("'", '', $worksheet[$i]["S"])); // d1
                    $inst_no = trim(str_replace("'", '', $worksheet[$i]["T"]));
                    $dep_slip_no = trim(str_replace("'", '', $worksheet[$i]["N"]));
                    $drn_bk = trim(str_replace("'", '', $worksheet[$i]["U"]));
                    $location_short = trim($worksheet[$i]["V"]) . ' ' . trim($worksheet[$i]["W"]) . ' ' . trim($worksheet[$i]["X"]); // cl_loc
                    $inst_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["Y"]))); //inst_amt
                    $instDate = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["Z"])), 'HDFC Cash MIS'); // INST DATE

                    $drawer_name = trim(str_replace("'", '', $worksheet[$i]["AA"])); // drawer_name
                    $e1 = trim(str_replace("'", '', $worksheet[$i]["AB"])); // e1
                    $e2 = trim(str_replace("'", '', $worksheet[$i]["AC"])); // e2
                    $e3 = trim(str_replace("'", '', $worksheet[$i]["AD"])); // e3 
                    $return_reason = trim(str_replace("'", '', $worksheet[$i]["AE"])); // return_reason  

                    // assigning missing status from config constants file
                    $missingStatus = config('constants.missingStatus.StoreID');

                    // getting the Not considered brands
                    $NotconsiderArrayBrand = BrandNotConsider::select('brand')->where('isActive', '=', 1)->pluck('brand')->toArray();


                    // if everything is correct
                    if ($storeID != "" && $retakCode != "") {
                        $missingStatus = 'Valid';
                    }


                    // if the brand is in Not considered brands
                    if (in_array($brand, $NotconsiderArrayBrand)) {
                        $missingStatus = 'NotValid';
                    }


                    $pkupDate = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["M"])), 'HDFC Cash MIS'); // pkup_dt     

                    $data = array(
                        "storeID" => $storeID,
                        "retekCode" => $retakCode,
                        "colBank" => $colBank,
                        "brand" => $brand,
                        "pkupPtCode" => $pkupPtCode, // pkup_pt
                        "drCr" => $dr_cr, // dr_cr
                        "prdCode" => $prodCode, // prd_code                    
                        "locationName" => $locationName, // pkup_loc                                        
                        "depositDt" => $depositDt,
                        "crDt" => $crDt,
                        "depSlipNo" => $dep_slip_no, // dept_slip
                        "depositAmount" => $depositAmount, // entry_amt
                        "returnReason" => $return_reason, // return_reason_remarks
                        "locationShort" => $location_short, // cl_loc
                        "pkupDt" => $pkupDate, // pkup_dt
                        "noOfInst" => $no_of_inst, // no_of_inst
                        "instNo" => $inst_no, // inst_no
                        "instDt" => $instDate, // inst_dt
                        "instAmt" => $inst_amount, // inst_amt
                        "drnBk" => $drn_bk, // drawee_bk
                        "drnBr" => $drawer_name, // drawer_name
                        "remarks1" => $remarks1, // dept_rmk
                        "remarks2" => $remarks2, // d1
                        "pooledDeptAmt" => $pooledDeptAmt, // dept_amt
                        "deptDt" => $deptDate, // dept_dt
                        "rowType" => $row_type, // row_type
                        "entryId" => $entryId, // entry_id
                        "e1" => $e1,
                        "e2" => $e2,
                        "e3" => $e3,
                        "filename" => $file_1_name,
                        "createdBy" => Auth::id(),
                        "missingRemarks" => $missingStatus,
                        'isActive' => '1',
                        'createdDate' => now()->format('Y-m-d')
                    );




                    if ($row_type != '' && $entryId != '') {
                        if (MFLInwardCashMISHdfcPos::Insert($data)) {
                            $this->repository->increamentInsertedCount();
                        }
                    }
                }

                if (trim($worksheet[$i]["I"]) != "Susari") {

                    $pkupPtCode = trim(str_replace("'", '', $worksheet[$i]["J"])); // pkup_pts                    

                    $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($pkupPtCode);
                    $retakCode = $storedata['RETEK Code'];
                    $storeID = $storedata['Store ID'];
                    $brand = $storedata['Brand Desc'];

                    $locationName = trim(str_replace("'", '', $worksheet[$i]["I"])); //pkup_loc                  

                    $dep_slip_no = trim(str_replace("'", '', $worksheet[$i]["L"])); //dept_slip

                    $return_reason = trim(str_replace("'", '', $worksheet[$i]["AA"])); // return_reason_remarks
                    $location_short = trim(str_replace("'", '', $worksheet[$i]["T"])); // cl_loc 
                    $pkupDate = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["K"])), 'HDFC Cash MIS'); // pkup_dt

                    $no_of_inst = trim(str_replace("'", '', $worksheet[$i]["O"])); // no_of_inst
                    $inst_no = trim(str_replace("'", '', $worksheet[$i]["R"])); // inst_no
                    $instDate = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["V"])), 'HDFC Cash MIS'); // INST DATE
                    $drn_bk = trim(str_replace("'", '', $worksheet[$i]["S"])); // drawee_bk
                    $drawer_name = trim(str_replace("'", '', $worksheet[$i]["W"])); // drawer_name
                    $remarks1 = trim(str_replace("'", '', $worksheet[$i]["P"])); // remarks1
                    $remarks2 = trim(str_replace("'", '', $worksheet[$i]["Q"])); // d1
                    $pooledDeptAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["N"]))); //dept_amt
                    $inst_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["U"]))); //inst_amt

                    $deptDate = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["M"])), 'HDFC Cash MIS'); // dept_dt

                    $e1 = trim(str_replace("'", '', $worksheet[$i]["X"])); // e1
                    $e2 = trim(str_replace("'", '', $worksheet[$i]["Y"])); // e2
                    $e3 = trim(str_replace("'", '', $worksheet[$i]["Z"])); // e3  

                    // assigning missing status from config constants file
                    $missingStatus = config('constants.missingStatus.StoreID');

                    // getting the Not considered brands
                    $NotconsiderArrayBrand = BrandNotConsider::select('brand')->where('isActive', '=', 1)->pluck('brand')->toArray();

                    // if everything is correct
                    if ($storeID != "" && $retakCode != "") {
                        $missingStatus = 'Valid';
                    }

                    // if the brand is in Not considered brands
                    if (in_array($brand, $NotconsiderArrayBrand)) {
                        $missingStatus = 'NotValid';
                    }


                    $data = array(
                        "storeID" => $storeID,
                        "retekCode" => $retakCode,
                        "colBank" => $colBank,
                        "brand" => $brand,
                        "pkupPtCode" => $pkupPtCode, // pkup_pt
                        "drCr" => $dr_cr, // dr_cr
                        "prdCode" => $prodCode, // prd_code                    
                        "locationName" => $locationName, // pkup_loc                                        
                        "depositDt" => $depositDt,
                        "crDt" => $crDt,
                        "depSlipNo" => $dep_slip_no, // dept_slip
                        "depositAmount" => $depositAmount, // entry_amt
                        "returnReason" => $return_reason, // return_reason_remarks
                        "locationShort" => $location_short, // cl_loc
                        "pkupDt" => $pkupDate, // pkup_dt
                        "noOfInst" => $no_of_inst, // no_of_inst
                        "instNo" => $inst_no, // inst_no
                        "instDt" => $instDate, // inst_dt
                        "instAmt" => $inst_amount, // inst_amt
                        "drnBk" => $drn_bk, // drawee_bk
                        "drnBr" => $drawer_name, // drawer_name
                        "remarks1" => $remarks1, // dept_rmk
                        "remarks2" => $remarks2, // d1
                        "pooledDeptAmt" => $pooledDeptAmt, // dept_amt
                        "deptDt" => $deptDate, // dept_dt
                        "rowType" => $row_type, // row_type
                        "entryId" => $entryId, // entry_id
                        "e1" => $e1,
                        "e2" => $e2,
                        "e3" => $e3,
                        "filename" => $file_1_name,
                        "createdBy" => Auth::id(),
                        "missingRemarks" => $missingStatus,
                        'isActive' => '1',
                        'createdDate' => now()->format('Y-m-d')
                    );


                    if ($row_type != '' && $entryId != '') {
                        if (MFLInwardCashMISHdfcPos::Insert($data)) {
                            $this->repository->increamentInsertedCount();
                        }
                    }
                }
            }

            // finializing the logs
            $this->repository->finializeLog();

            // Return response with updated HTML
            return response()->json([
                'message' => 'Success',
                "data" => $this->generateHTML(function () use ($getorinilfilename) {

                    return MFLInwardCashMISHdfcPos::select(
                        'depositAmount',
                        'missingRemarks',
                        DB::raw('ISNULL(depositDt, NULL) as depositDt'),
                        DB::raw('ISNULL(crDt, NULL) as crDt')
                    )
                        ->where('filename', 'like', '%' . $getorinilfilename . '%')->get();
                })
            ], 200);

        } catch (\Throwable $exception) {
            $this->repository->failedLog($exception);
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}


