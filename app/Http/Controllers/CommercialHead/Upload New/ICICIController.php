<?php

namespace App\Http\Controllers\CommercialHead\Upload;

use App\Traits\GenerateTotalHTML;
use Log;

// Request

use Exception;
use Carbon\Carbon;
use App\Models\Store;
use App\Models\MICICIMID;


// Response

use Illuminate\View\View;

// Model
use Illuminate\Http\Request;
use App\Models\Logs\UploadLog;
use App\Models\BrandNotConsider;
use App\Services\GeneralService;

// Exception

use App\Services\ParseDateService;

// Services

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

// Others

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use App\Interface\MisReadLogsInterface;
use App\Models\MFLInwardCardMISIciciPos;
use App\Models\MFLinwardCashMISIciciPos;
use App\Services\ExcelUploadGeneralService;




class ICICIController extends Controller {

    use GenerateTotalHTML;



    public function __construct(
        public MisReadLogsInterface $repository
    ) {
    }




    public function ICICIUpload(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS|max:129048'
        ]);


        // Retrieve the uploaded file
        $file = $request->file('file');

        $destinationPath = storage_path('app/public/commercial/iciciCashdata');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/iciciCashdata/') . $file_1_name;

        // checking if the filename is in the db
        if (MFLinwardCashMISIciciPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
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

        // setting the inserted count to zero
        $this->repository->startFrom(2);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_Inward_CashMIS_ICICIPos",
            "bank" => "ICICI Cash",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {

            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $col_bank = config('constants.ICICI.cashBankName'); // bankName

                $pkup_pt_code = trim(str_replace("'", '', $worksheet[$i]["R"])); // HIR CD
                $dep_slip_no = trim(str_replace("'", '', $worksheet[$i]["O"])); // SLIP NO.

                if ($pkup_pt_code == "MADGAR") {
                    $retekCode = "";
                    $StoreID = "";
                    $brand = "";

                    $slipsumber_split = substr($dep_slip_no, 0, 5);
                    $storeselect = Store::select('Store ID', 'RETEK Code', 'Brand Desc')->where('RETEK Code', '=', $slipsumber_split)->get();
                    $storeCount = $storeselect->count();

                    if ($storeCount > 0) {
                        $StoreID = $storeselect->toArray()[0]['Store ID'];
                        $retekCode = $storeselect->toArray()[0]['RETEK Code'];
                        $brand = $storeselect->toArray()[0]['Brand Desc'];
                    }

                } else {
                    $depSlip_reteckCode = substr($dep_slip_no, 1, 4);
                    $storedata = ExcelUploadGeneralService::getRetekCodeFromDepositSlipNo(depositSlip: $depSlip_reteckCode, pickUpCode: $pkup_pt_code);
                    // $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($pkup_pt_code);
                    $retekCode = $storedata['RETEK Code'];
                    $StoreID = $storedata['Store ID'];
                    $brand = $storedata['Brand Desc'];
                }

                $tran_type = trim(str_replace("'", '', $worksheet[$i]["A"])); // TYPE
                $cust_code = trim(str_replace("'", '', $worksheet[$i]["B"])); // CUS CODE
                $prd_code = trim(str_replace("'", '', $worksheet[$i]["C"])); // PRD CODE
                $location_name = trim(str_replace("'", '', $worksheet[$i]["E"])); // LOCATION NAME

                $deposite_date = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["F"])), 'ICICI Cash MIS'); // DEP DATE
                $adj_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["H"])), 'ICICI Cash MIS'); // ADJ DATE  
                $cr_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["J"])), 'ICICI Cash MIS'); // CR DATE


                $slip_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["V"]))); // SLIP AMOUNT
                $adj_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["AO"]))); // ADJUSTED             

                $return_reason = trim(str_replace("'", '', $worksheet[$i]["BA"])); // RETURN REASON
                $hir_code = trim(str_replace("'", '', $worksheet[$i]["R"])); // HIR CD
                $hir_name = trim(str_replace("'", '', $worksheet[$i]["S"])); // HIERARCHY NAME
                $location_short = trim(str_replace("'", '', $worksheet[$i]["D"])); // LOCAT
                $clg_type = trim(str_replace("'", '', $worksheet[$i]["G"])); // CLG TYPE  

                $clg_date = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["I"])), 'ICICI Cash MIS'); // CLG DATE
                $rec_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["K"])), 'ICICI Cash MIS'); // REC DATE
                $rtn_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["L"])), 'ICICI Cash MIS'); // RTN DATE
                $rev_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["M"])), 'ICICI Cash MIS'); // REV DATE
                $realisation_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["N"])), 'ICICI Cash MIS'); // REAL DATE                

                $division_code = trim(str_replace("'", '', $worksheet[$i]["P"])); // DIV CD
                $division_name = trim(str_replace("'", '', $worksheet[$i]["Q"])); // DIVISION NAME
                $adj = trim(str_replace("'", '', $worksheet[$i]["T"])); // ADJ
                $no_of_inst = trim(str_replace("'", '', $worksheet[$i]["U"])); // NOF INS

                // $recovered_amount = trim(str_replace(',', '',$worksheet[$i]["W"])); // RECOVERED AMOUNT

                $recovered_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["W"]))); // RECOVERED AMOUNT

                $sub_customer_code = trim(str_replace("'", '', $worksheet[$i]["X"])); // SUB CUS
                $sub_customer_name = trim(str_replace("'", '', $worksheet[$i]["Y"])); // SUB CUSTOMER NAME
                $d_s_addl_info_code1 = trim(str_replace("'", '', $worksheet[$i]["Z"])); // D.S ADDTNL INFO CODE1
                $d_s_addl_info1 = trim(str_replace("'", '', $worksheet[$i]["AA"])); // D.S. ADDITIONAL INFORMATION 1
                $d_s_addl_info_code2 = trim(str_replace("'", '', $worksheet[$i]["AB"])); // D.S ADDTNL INFO CODE2
                $d_s_addl_info2 = trim(str_replace("'", '', $worksheet[$i]["AC"])); // D.S. ADDITIONAL INFORMATION 2
                $d_s_addl_info_code3 = trim(str_replace("'", '', $worksheet[$i]["AD"])); // D.S ADDTNL INFO CODE3
                $d_s_addl_info3 = trim(str_replace("'", '', $worksheet[$i]["AE"])); // D.S. ADDITIONAL INFORMATION 3
                $d_s_addl_info_code4 = trim(str_replace("'", '', $worksheet[$i]["AF"])); // D.S ADDTNL INFO CODE4
                $d_s_addl_info4 = trim(str_replace("'", '', $worksheet[$i]["AG"])); // D.S. ADDITIONAL INFORMATION 4
                $d_s_addl_info_code5 = trim(str_replace("'", '', $worksheet[$i]["AH"])); // D.S ADDTNL INFO CODE5
                $d_s_addl_info5 = trim(str_replace("'", '', $worksheet[$i]["AI"])); // D.S. ADDITIONAL INFORMATION 5

                $inst_sl = trim(str_replace("'", '', $worksheet[$i]["AJ"])); // IN SL
                $inst_no = trim(str_replace("'", '', $worksheet[$i]["AK"])); // INST NO
                $inst_type = trim(str_replace("'", '', $worksheet[$i]["AL"])); // INSTRUMENT TYPE


                $inst_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["AM"])), 'ICICI Cash MIS'); // INST DATE
                $inst_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["AN"]))); // INST AMOUNT
                $adj_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["AO"]))); // ADJUSTED AMOUNT
                $recovered_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["AP"]))); // RECOVERED AMOUNT
                $return_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["AZ"]))); // RTN AMOUNT


                $drn_on = trim(str_replace("'", '', $worksheet[$i]["AR"])); // DRN ON
                $drn_on_location = trim(str_replace("'", '', $worksheet[$i]["AS"])); // DRAWN ON LOCATION
                $drn_bk = trim(str_replace("'", '', $worksheet[$i]["AT"])); // DRN BK
                $drn_br = trim(str_replace("'", '', $worksheet[$i]["AU"])); // DRN BR
                $sub_cust = trim(str_replace("'", '', $worksheet[$i]["AV"])); // SUB CU
                $sub_cust_name = trim(str_replace("'", '', $worksheet[$i]["AW"])); // SUB CUSTOMER NAME
                $dr_cod = trim(str_replace("'", '', $worksheet[$i]["AX"])); // DR COD
                $drawer_name = trim(str_replace("'", '', $worksheet[$i]["AY"])); // DRAWER NAME                            
                $ins_addl_info_code1 = trim(str_replace("'", '', $worksheet[$i]["BB"])); // INS ADDTNL INFO CODE1
                $ins_addl_info1 = trim(str_replace("'", '', $worksheet[$i]["BC"])); // INS ADDITIONAL INFORMATION 1
                $ins_addl_info_code2 = trim(str_replace("'", '', $worksheet[$i]["BD"])); // INS ADDTNL INFO CODE2
                $ins_addl_info2 = trim(str_replace("'", '', $worksheet[$i]["BE"])); // INS ADDITIONAL INFORMATION 2
                $ins_addl_info_code3 = trim(str_replace("'", '', $worksheet[$i]["BF"])); // INS ADDTNL INFO CODE3
                $ins_addl_info3 = trim(str_replace("'", '', $worksheet[$i]["BG"])); // INS ADDITIONAL INFORMATION 3
                $ins_addl_info_code4 = trim(str_replace("'", '', $worksheet[$i]["BH"])); // INS ADDTNL INFO CODE4
                $ins_addl_info4 = trim(str_replace("'", '', $worksheet[$i]["BI"])); // INS ADDITIONAL INFORMATION 4
                $ins_addl_info_code5 = trim(str_replace("'", '', $worksheet[$i]["BJ"])); // INS ADDTNL INFO CODE5
                $ins_addl_info5 = trim(str_replace("'", '', $worksheet[$i]["BK"])); // INS ADDITIONAL INFORMATION 5

                $remarks1 = trim(str_replace("'", '', $worksheet[$i]["BL"])); // REMARKS 1
                $remarks2 = trim(str_replace("'", '', $worksheet[$i]["BM"])); // REMARKS 2
                $remarks3 = trim(str_replace("'", '', $worksheet[$i]["BN"])); // REMARKS 3
                $pool_sl = trim(str_replace("'", '', $worksheet[$i]["BO"])); // Pool Sl

                $userId = Auth::id();

                // assigning missing status from config constants file
                $missingStatus = config('constants.missingStatus.StoreID');

                // getting the Not considered brands
                $NotconsiderArrayBrand = BrandNotConsider::select('brand')->where('isActive', '=', 1)->pluck('brand')->toArray();

                // if everything is correct
                if ($StoreID != "" && $retekCode != "") {
                    $missingStatus = 'Valid';
                }

                // if the brand is in Not considered brands
                if (in_array($brand, $NotconsiderArrayBrand)) {
                    $missingStatus = 'NotValid';
                }


                $data = array(
                    "storeID" => $StoreID,
                    "retekCode" => $retekCode,
                    'colBank' => $col_bank,
                    "brand" => $brand,
                    "pkupPtCode" => $pkup_pt_code,
                    "tranType" => $tran_type,
                    "custCode" => $cust_code,
                    "prdCode" => $prd_code,
                    "locationName" => $location_name,
                    "depositDt" => $deposite_date,
                    "adjDt" => $adj_dt,
                    "crDt" => $cr_dt,
                    "depSlipNo" => $dep_slip_no,
                    "depositAmount" => $slip_amount,
                    "adjAmount" => $adj_amount,
                    "returnReason" => $return_reason,
                    "hirCode" => $hir_code,
                    "hirName" => $hir_name,
                    "locationShort" => $location_short,
                    "clgType" => $clg_type,
                    "clgDt" => $clg_date,
                    "recDt" => $rec_dt,
                    "rtnDt" => $rtn_dt,
                    "revDt" => $rev_dt,
                    "realisationDt" => $realisation_dt,
                    "divisionCode" => $division_code,
                    "divisionName" => $division_name,
                    "adj" => $adj,
                    "noOfInst" => $no_of_inst,
                    "recoveredAmount" => $recovered_amount,
                    "subCustomerCode" => $sub_customer_code,
                    "subCustomerName" => $sub_customer_name,
                    "dS_Addl_InfoCode1" => $d_s_addl_info_code1,
                    "dS_AddlInfo1" => $d_s_addl_info1,
                    "dS_Addl_InfoCode2" => $d_s_addl_info_code2,
                    "dS_AddlInfo2" => $d_s_addl_info2,
                    "dS_Addl_InfoCode3" => $d_s_addl_info_code3,
                    "dS_AddlInfo3" => $d_s_addl_info3,
                    "dS_Addl_InfoCode4" => $d_s_addl_info_code4,
                    "dS_AddlInfo4" => $d_s_addl_info4,
                    "dS_Addl_InfoCode5" => $d_s_addl_info_code5,
                    "dS_AddlInfo5" => $d_s_addl_info5,
                    "instSl" => $inst_sl,
                    "instNo" => $inst_no,
                    "instDt" => $inst_dt,
                    "instAmt" => $inst_amt,
                    "instType" => $inst_type,
                    "adjAmt" => $adj_amt,
                    "recoveredAmt" => $recovered_amt,
                    "drnOn" => $drn_on,
                    "drnOnLocation" => $drn_on_location,
                    "drnBk" => $drn_bk,
                    "drnBr" => $drn_br,
                    "subCust" => $sub_cust,
                    "subCustName" => $sub_cust_name,
                    "drCod" => $dr_cod,
                    "drawerName" => $drawer_name,
                    "returnAmt" => $return_amt,
                    "insAddl_InfoCode1" => $ins_addl_info_code1,
                    "insAddlInfo1" => $ins_addl_info1,
                    "insAddl_InfoCode2" => $ins_addl_info_code2,
                    "insAddlInfo2" => $ins_addl_info2,
                    "insAddl_InfoCode3" => $ins_addl_info_code3,
                    "insAddlInfo3" => $ins_addl_info3,
                    "insAddl_InfoCode4" => $ins_addl_info_code4,
                    "insAddlInfo4" => $ins_addl_info4,
                    "insAddl_InfoCode5" => $ins_addl_info_code5,
                    "insAddlInfo5" => $ins_addl_info5,
                    "remarks1" => $remarks1,
                    "remarks2" => $remarks2,
                    "remarks3" => $remarks3,
                    "poolSl" => $pool_sl,
                    "filename" => $file_1_name,
                    "createdBy" => $userId,
                    "missingRemarks" => $missingStatus,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );

                if ($tran_type != '' && $pkup_pt_code != '') {
                    if (MFLinwardCashMISIciciPos::Insert($data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }
            }

            // finializing the logs
            $this->repository->finializeLog();

            return response()->json([
                'message' => 'Success',
                "data" => $this->generateHTML(function () use ($getorinilfilename) {
                    return MFLinwardCashMISIciciPos::select(
                        'depositAmount',
                        'missingRemarks',
                        DB::raw('ISNULL(depositDt, NULL) as depositDt'),
                        DB::raw('ISNULL(crDt, NULL) as crDt')
                    )->where('filename', 'like', '%' . $getorinilfilename . '%')->get();
                })
            ], 200);


        } catch (\Throwable $exception) {
            $this->repository->failedLog($exception);
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }


    public function ICICIcardUpload(Request $request) {

        // Retrieve the uploaded file

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS|max:129048'
        ]);

        $file = $request->file('file');


        // Load the Excel file using PhpSpreadsheet
        $destinationPath = storage_path('app/public/commercial/icicicarddata');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/icicicarddata/') . $file_1_name;



        // checking if the filename is in the db
        if (MFLinwardCardMISIciciPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
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
        //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
        $spreadsheet = $reader->load($targetPath);
        $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);


        $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet


        // setting the inserted count to zero
        $this->repository->startFrom(2);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_Inward_CardMIS_ICICIPos",
            "bank" => "ICICI Card",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {
            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $col_bank = config('constants.ICICI.cardBankName'); // bankName
                $acct_no = config('constants.ICICI.cardaccountNumber');
                // ICICICardAc

                $merCode = trim(str_replace("'", '', $worksheet[$i]["D"])); // TRADE NAME                
                $tid = trim(str_replace("'", '', $worksheet[$i]["T"])); // TID
                $mid = trim(str_replace("'", '', $worksheet[$i]["B"])); // MID
                $crDt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["N"]), 'ICICI Card'); // POST DATE  
                $depositDt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["M"]), 'ICICI Card'); // TRANSACTION DATE              
                if (!$depositDt) { # deposit isnull # check if the deposit date is null
                    $depositDt = Carbon::parse($crDt)->subDays(value: 1)->format('Y-m-d'); # dateadd(day, -1, getdate())
                }
                $parsed_ = str_replace(['AM', 'PM'], '', $depositDt);

                $storedata = GeneralService::getReteckCodeUsingTIDForICICI($tid, Carbon::parse($parsed_)->format('Y-m-d'));
                $retekCode = $storedata['retekCode'];
                $storeID = $storedata['storeID'];
                $brand = $storedata['brand'];


                $depositAmount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["Y"]))); // TRANSACTION AMOUNT
                $msfComm = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["AB"]))); // COMM AMOUNT
                $netamount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["AC"]))); //NET AMT

                $cardType = trim(str_replace("'", '', $worksheet[$i]["R"])); //CARD TYPE
                $cardno = trim(str_replace("'", '', $worksheet[$i]["O"])); //CARDDNO
                $transactionType = trim(str_replace("'", '', $worksheet[$i]["X"])); //TRANSACTION TYPE

                if (trim($worksheet[$i]["L"] == "") || empty(trim($worksheet[$i]["L"]))) {
                    $batchDate = NULL;
                } else {
                    $batchDate = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["L"]), 'ICICI Card'); // BATCHDATE
                }

                $approv_code = trim(str_replace("'", '', $worksheet[$i]["V"])); //AUTH CODE

                $settlAmount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["AA"]))); //AMOUNT

                $drCrType = trim(str_replace("'", '', $worksheet[$i]["AD"])); //CREDIT/DEBIT
                $batNbr = trim(str_replace("'", '', $worksheet[$i]["K"])); //BATCH NO
                $tranId = trim(str_replace("'", '', $worksheet[$i]["AF"])); // FT NO.
                $merchantTrackid = trim(str_replace("'", '', $worksheet[$i]["AG"])); // SESSION ID [ASPD]
                $funding_type = trim(str_replace("'", '', $worksheet[$i]["J"])); // FUNDING TYPE
                $merchantTariff = trim(str_replace("'", '', $worksheet[$i]["H"])); //MERCHANT TARIFF 
                $merchantGrade = trim(str_replace("'", '', $worksheet[$i]["I"])); //MERCHANT GRADE
                $terminal_capture = trim(str_replace("'", '', $worksheet[$i]["U"])); //TERMINAL CAPTURE
                $originalMsgType = trim(str_replace("'", '', $worksheet[$i]["W"])); //ORIG_MSG_TYPE
                $sequenceNumber = trim(str_replace("'", '', $worksheet[$i]["AR"])); //SE_NO
                $arnno = trim(str_replace("'", '', $worksheet[$i]["AL"])); //ARN NO

                $tran_type = trim(str_replace("'", '', $worksheet[$i]["C"])); //MID TYPE
                $merchantName = trim(str_replace("'", '', $worksheet[$i]["E"])); //LEGAL NAME

                $currency = trim(str_replace("'", '', $worksheet[$i]["Z"])); //TRANSACTION CURRENCY
                $name_and_loc = trim(str_replace("'", '', $worksheet[$i]["F"])); //LOCATION
                $mcc = trim(str_replace("'", '', $worksheet[$i]["G"])); //MCC
                $onusOffus = trim(str_replace("'", '', $worksheet[$i]["Q"])); //CARD CATEGORY

                $CardType = trim(str_replace("'", '', $worksheet[$i]["S"])); //AREA OF EVENT
                $TranIdentifier = trim(str_replace("'", '', $worksheet[$i]["AM"])); //RET_REF_NUM
                $SuperMID = trim(str_replace("'", '', $worksheet[$i]["A"])); //SUPER MID
                $AirlineTicketNumber = trim(str_replace("'", '', $worksheet[$i]["AI"])); //TICKETNUMBER

                $dcc_indicator = trim(str_replace("'", '', $worksheet[$i]["AN"])); //DCC Indicator
                $mc_conv_fee = trim(str_replace("'", '', $worksheet[$i]["AO"])); //MC_CONV_FEE
                $future_fund_date = trim(str_replace("'", '', $worksheet[$i]["AI"])); //FUTURE FUND DATE
                $flight_no = trim(str_replace("'", '', $worksheet[$i]["AH"])); //FLIGHT NO
                $trvl_agency_code = trim(str_replace("'", '', $worksheet[$i]["AJ"])); //TRVLAGENCYCODE
                $travel_agency_name = trim(str_replace("'", '', $worksheet[$i]["AK"])); //TRAVEL AGENCY NAME
                $recur_tran = trim(str_replace("'", '', $worksheet[$i]["AP"])); //RECURR TRAN
                $custom_data = trim(str_replace("'", '', $worksheet[$i]["AQ"])); //CUSTOM DATA
                $transaction_status = trim(str_replace("'", '', $worksheet[$i]["AE"])); //TRANSACTION STATUS


                $userId = Auth::id();

                // assigning missing status from config constants file
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
                    "colBank" => $col_bank,
                    "brand" => $brand,
                    "acctNo" => $acct_no,
                    "merCode" => $merCode,
                    "tid" => $tid,
                    "mid" => $mid,
                    "depositDt" => $depositDt,
                    "crDt" => $crDt,
                    "depositAmount" => $depositAmount,
                    "msfComm" => $msfComm,
                    "netAmount" => $netamount,
                    "cardTypes" => $cardType,
                    "cardNumber" => $cardno,
                    "transactionType" => $transactionType,
                    "procDt" => $batchDate,
                    "approvCode" => $approv_code,
                    "settlAmount" => $settlAmount,
                    "drCrType" => $drCrType,
                    "batNbr" => $batNbr,
                    "tranId" => $tranId,
                    "merchantTrackid" => $merchantTrackid,
                    "fundingType" => $funding_type,
                    "merchantTariff" => $merchantTariff,
                    "merchantGrade" => $merchantGrade,
                    "terminalCapture" => $terminal_capture,
                    "originalMsgType" => $originalMsgType,
                    "sequenceNumber" => $sequenceNumber,
                    "tranType" => $tran_type,
                    "merchantName" => $merchantName,
                    "currency" => $currency,
                    "nameAndLoc" => $name_and_loc,
                    "onusOffus" => $onusOffus,
                    "CardType" => $CardType,
                    "TranIdentifier" => $TranIdentifier,
                    "mcc" => $mcc,
                    "SuperMID" => $SuperMID,
                    "AirlineTicketNumber" => $AirlineTicketNumber,
                    "dccIndicator" => $dcc_indicator,
                    "mcConvFee" => $mc_conv_fee,
                    "futureFundDate" => $future_fund_date,
                    "flightNo" => $flight_no,
                    "travelAgencyCode" => $travel_agency_name,
                    "travelAgencyName" => $travel_agency_name,
                    "recurTran" => $recur_tran,
                    "customData" => $custom_data,
                    "transactionStatus" => $transaction_status,
                    "filename" => $file_1_name,
                    "createdBy" => $userId,
                    "missingRemarks" => $missingStatus,
                    "arnno" => $arnno,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );


                if ($merCode != '' && $mid != '') {
                    // Assuming $data contains the attributes and values for the user                                              
                    if (MFLInwardCardMISIciciPos::Insert($data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }

            }

            // finializing the logs
            $this->repository->finializeLog();
            return response()->json([
                'message' => 'Success',
                "data" => $this->generateHTML(function () use ($getorinilfilename) {
                    return MFLinwardCardMISIciciPos::select(
                        'depositAmount',
                        'missingRemarks',
                        DB::raw('ISNULL(depositDt, NULL) as depositDt'),
                        DB::raw('ISNULL(crDt, NULL) as crDt')
                    )->where('filename', 'like', '%' . $getorinilfilename . '%')->get();
                })
            ], 200);

        } catch (\Throwable $exception) {
            $this->repository->failedLog($exception);
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
