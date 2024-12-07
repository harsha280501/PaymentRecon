<?php

namespace App\Http\Controllers\CommercialHead\Upload;

use App\Http\Controllers\Controller;

// Request

use App\Interface\MisReadLogsInterface;
use App\Models\BrandNotConsider;
use App\Models\Logs\UploadLog;
use Illuminate\Http\Request;


// Response

use Illuminate\Http\RedirectResponse;

// Model
use App\Models\MFLInwardCashMISSBIPos;
use App\Models\MFLInwardCardMISSBIPos;
use App\Models\MFLInwardCashAgencyMISSBIPos;


// Exception

// Services

use App\Services\GeneralService;
use App\Services\ParseDateService;
use App\Services\ExcelUploadGeneralService;
use App\Services\Upload\ExcelBankStatement;
// Others

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class SBIController extends Controller {


    public function __construct(
        public MisReadLogsInterface $repository
    ) {
    }



    /**
     * SBI Uploads
     * @return void
     */
    public function importSBICashData(Request $request) {
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
        if (MFLInwardCashMISSBIPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
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
            "table" => "MFL_Inward_CashMIS_SbiPos",
            "bank" => "SBI Cash",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {

            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $col_bank = config('constants.SBI.cashBankName'); // bankName
                $getpkup_pt_code = trim($worksheet[$i]["E"]); // CUST_REF_NO

                $pkup_pt_code = is_numeric($getpkup_pt_code) ? $getpkup_pt_code : 0; // if not numeric set it as zero

                $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($pkup_pt_code);
                $retakeCode = $storedata['RETEK Code'];
                $storeID = $storedata['Store ID'];
                $brand = $storedata['Brand Desc'];

                $cust_code = trim($worksheet[$i]["B"]); // CUSTOMER_CODE
                $prd_code = trim($worksheet[$i]["D"]); // PRODUCT_CODE
                $location_name = trim($worksheet[$i]["C"]); // LOCATION_NAME

                $deposit_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["G"]), 'SBI Cash MIS'); // DEP DATE     
                $deposit_slipno = trim($worksheet[$i]["F"]); // DEPOSIT_SLIP_NO
                $total_amount = trim(str_replace(',', '', $worksheet[$i]["I"])); // TOTAL_PAID_AMT

                $return_reason = trim($worksheet[$i]["Q"]); // REMARKS
                $deposit_br = trim($worksheet[$i]["R"]); // BRANCH_CODE
                $deposit_br_name = trim($worksheet[$i]["S"]); // BRANCH_NAME               
                $no_of_inst = trim($worksheet[$i]["H"]); // NO_OF_INST

                $d_s_addl_info1 = trim($worksheet[$i]["U"]); // INST_ENRICHMENT1                
                $d_s_addl_info2 = trim($worksheet[$i]["V"]); // INST_ENRICHMENT2               
                $d_s_addl_info3 = trim($worksheet[$i]["W"]); // INST_ENRICHMENT3               
                $d_s_addl_info4 = trim($worksheet[$i]["X"]); // INST_ENRICHMENT4               
                $d_s_addl_info5 = trim($worksheet[$i]["Y"]); // INST_ENRICHMENT5

                $inst_no = trim($worksheet[$i]["J"]); // INSTRUMENT_NO
                //$inst_dt = trim($worksheet[$i]["L"]); // INSTRUMENT_DATE
                $inst_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["L"]), 'SBI Cash MIS'); // INSTRUMENT_DATE
                $inst_amt = trim(str_replace(',', '', $worksheet[$i]["K"])); // INSTRUMENT_AMT


                $drn_bk = trim($worksheet[$i]["M"]); // DRAWEE_BANK
                $drn_br = trim($worksheet[$i]["N"]); // DRAWEE_BRANCH
                $drawer_name = trim($worksheet[$i]["O"]); // DRAWER_NAME           
                $debtor_acc_no = trim($worksheet[$i]["P"]); // DEBTOR_ACC_NO
                $e2 = trim($worksheet[$i]["Z"]); // S_NO


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
                    "pkupPtCode" => $pkup_pt_code,
                    "custCode" => $cust_code,
                    "prdCode" => $prd_code,
                    "locationName" => $location_name,
                    "depositDt" => $deposit_dt,
                    "depSlipNo" => $deposit_slipno,
                    "depositAmount" => $total_amount,
                    "returnReason" => $return_reason,
                    "depositBr" => $deposit_br,
                    "depositBrName" => $deposit_br_name,
                    "noOfInst" => $no_of_inst,
                    "dS_AddlInfo1" => $d_s_addl_info1,
                    "dS_AddlInfo2" => $d_s_addl_info2,
                    "dS_AddlInfo3" => $d_s_addl_info3,
                    "dS_AddlInfo4" => $d_s_addl_info4,
                    "dS_AddlInfo5" => $d_s_addl_info5,
                    "instNo" => $inst_no,
                    "instDt" => $inst_dt,
                    "instAmt" => $inst_amt,
                    "drnBk" => $drn_bk,
                    "drnBr" => $drn_br,
                    "drawerName" => $drawer_name,
                    "pooledAcNo" => $debtor_acc_no,
                    "e2" => $e2,
                    "filename" => $file_1_name,
                    "createdBy" => $userId,
                    "missingRemarks" => $missingStatus
                );

                $attributes = [
                    "storeID" => $storeID,
                    "retekCode" => $retakeCode,
                    "colBank" => $col_bank,
                    "brand" => $brand,
                    "pkupPtCode" => $pkup_pt_code,
                    "custCode" => $cust_code,
                    "prdCode" => $prd_code,
                    "locationName" => $location_name,
                    "depositDt" => $deposit_dt,
                    "depSlipNo" => $deposit_slipno,
                    "depositAmount" => $total_amount,
                    "returnReason" => $return_reason,
                    "depositBr" => $deposit_br,
                    "depositBrName" => $deposit_br_name,
                    "noOfInst" => $no_of_inst,
                    "dS_AddlInfo1" => $d_s_addl_info1,
                    "dS_AddlInfo2" => $d_s_addl_info2,
                    "dS_AddlInfo3" => $d_s_addl_info3,
                    "dS_AddlInfo4" => $d_s_addl_info4,
                    "dS_AddlInfo5" => $d_s_addl_info5,
                    "instNo" => $inst_no,
                    "instDt" => $inst_dt,
                    "instAmt" => $inst_amt,
                    "drnBk" => $drn_bk,
                    "drnBr" => $drn_br,
                    "drawerName" => $drawer_name,
                    "pooledAcNo" => $debtor_acc_no,
                    "e2" => $e2,
                    "createdBy" => $userId
                ];


                if ($cust_code != '' && $prd_code != '') {
                    if (MFLInwardCashMISSBIPos::updateOrInsert($attributes, $data)) {
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



    public function importSBICardData(Request $request) {

        // Retrieve the uploaded file
        $request->validate([
            'file' => 'required|mimes:csv,txt,xls,xlsx,XLS|max:25048'
        ]);

        $file = $request->file('file');

        $destinationPath = storage_path('app/public/commercial/SbiCarddata');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/SbiCarddata/') . $file_1_name;


        // checking if the filename is in the db
        if (MFLInwardCardMISSBIPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
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

        $error_msgs_arr = array();

        // setting the inserted count to zero
        $this->repository->startFrom(2);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_Inward_CardMIS_SbiPos",
            "bank" => "SBI Card",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {

            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $col_bank = config('constants.SBI.cardBankName'); // bankName
                $acct_no = "Account Number"; // SBICardAc   
                $mer_code = trim(str_replace("'", '', $worksheet[$i]["AB"])); // Accountnr
                $tid = trim(str_replace("'", '', $worksheet[$i]["B"])); // TID
                $mid = trim(str_replace("'", '', $worksheet[$i]["A"])); // MID


                $parsed_ = str_replace(['AM', 'PM'], '', trim($worksheet[$i]["E"]));

                $store_ = ExcelUploadGeneralService::getReteckCodeUsingTIDForSBI($tid, $parsed_);
                $retekCode = $store_['retekCode'];
                $storeID = $store_['storeID'];
                $brand = $store_['brand'];
                $cr_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["F"]), 'SBI Card'); // Stl Date
                $deposit_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["E"]), 'SBI Card'); // Tran Date
             


                $deposit_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["K"]))); // Txn Amount

                if (!$deposit_dt) { # deposit isnull # check if the deposit date is null
                    $deposit_dt = Carbon::parse($cr_dt)->subDays(value: 1)->format('Y-m-d'); # dateadd(day, -1, getdate())
                }


                $mdr_rate = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["L"]))); // MDR Rate
                $msf_comm = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["M"]))); // MDR Amount
                $gst_total = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["AG"]))); // GST
                $net_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["O"]))); // Net Amount

                $card_type = trim(str_replace("'", '', $worksheet[$i]["J"])); // cardtype
                $card_number = trim(str_replace("'", '', $worksheet[$i]["D"])); // PAN
                $approv_code = trim(str_replace("'", '', $worksheet[$i]["I"])); // Auth Code
                $serv_tax = trim(str_replace("'", '', $worksheet[$i]["N"])); // ServiceTax

                $sb_cess = trim(str_replace(',', '', $worksheet[$i]["X"])); // Swachh Bharat Cess
                $kk_cess = trim(str_replace(',', '', $worksheet[$i]["Y"])); // Krishi Kalyan Cess
                $arn_no = trim(str_replace("'", '', $worksheet[$i]["H"])); // RRN
                $bat_nbr = trim($worksheet[$i]["AK"]); // BatchNr

                $tran_type = trim(str_replace("'", '', $worksheet[$i]["AM"])); // TranType
                $name_And_loc = trim(str_replace("'", '', $worksheet[$i]["C"])); // NAME AND LOC
                $mcc = trim(str_replace("'", '', $worksheet[$i]["G"])); // MCC
                $onus_offus = trim(str_replace("'", '', $worksheet[$i]["P"])); // On US / Off US

                $penalty_mdr_rate = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["Q"]))); // Penalty Mdr Rate
                $penalty_mdr_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["R"]))); // Penalty Mdr Amt
                $penalty_service_tax = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["S"]))); // Penalty Service Tax
                $cashback_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["T"]))); // Cashback Amt

                $inc_mdr_rate = trim(str_replace(',', '', $worksheet[$i]["U"])); // Inc Mdr Rate
                $inc_amt = trim(str_replace(',', '', $worksheet[$i]["V"])); // Inc Amt
                $inc_service_tax = trim(str_replace(',', '', $worksheet[$i]["W"])); // Inc Service Tax
                $penalty_sbc = trim(str_replace(',', '', $worksheet[$i]["Z"])); // PenaltySBC


                $penalty_kcc = trim(str_replace(',', '', $worksheet[$i]["AA"])); // PenaltyKCC                
                $branch_code = trim(str_replace(',', '', $worksheet[$i]["AC"])); // BranchCode               
                $circle = trim(str_replace(',', '', $worksheet[$i]["AD"])); // circle

                $CardType = trim(str_replace("'", '', $worksheet[$i]["AE"])); // CardType
                $sponsorbank = trim(str_replace("'", '', $worksheet[$i]["AF"])); // sponsorbank
                $PenaltyGST = trim(str_replace(',', '', $worksheet[$i]["AH"])); // PenaltyGST
                $GSTIN = trim(str_replace("'", '', $worksheet[$i]["AI"])); // GSTIN
                $Paymentmode = trim(str_replace("'", '', $worksheet[$i]["AJ"])); // Paymentmode
                $Interchange = trim(str_replace("'", '', $worksheet[$i]["AL"])); // Interchange
                $Tran_Identifier = trim(str_replace("'", '', $worksheet[$i]["AN"])); // Tran_Identifier
                $SuperMID = trim(str_replace("'", '', $worksheet[$i]["AO"])); // SuperMID
                $ParentMID = trim(str_replace("'", '', $worksheet[$i]["AP"])); // ParentMID

                $userId = Auth::id();

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
                    "merCode" => $mer_code,
                    "tid" => $tid,
                    "mid" => $mid,
                    "depositDt" => $deposit_dt,
                    "depositAmount" => $deposit_amount,
                    "crDt" => $cr_dt,
                    "mdrRate" => $mdr_rate,
                    "msfComm" => $msf_comm,
                    "gstTotal" => $gst_total,
                    "netAmount" => $net_amount,
                    "cardTypes" => $card_type,
                    "cardNumber" => $card_number,
                    "approvCode" => $approv_code,
                    "servTax" => $serv_tax,
                    "sbCess" => $sb_cess,
                    "kkCess" => $kk_cess,
                    "arnNo" => $arn_no,
                    "batNbr" => $bat_nbr,
                    "tranType" => $tran_type,
                    "nameAndLoc" => $name_And_loc,
                    "mcc" => $mcc,
                    "onusOffus" => $onus_offus,
                    "penaltyMdrRate" => $penalty_mdr_rate,
                    "penaltyMdrAmt" => $penalty_mdr_amt,
                    "penaltyServiceTax" => $penalty_service_tax,
                    "cashbackAmt" => $cashback_amt,
                    "incMdrRate" => $inc_mdr_rate,
                    "incAmt" => $inc_amt,
                    "incServiceTax" => $inc_service_tax,
                    "penaltySbc" => $penalty_sbc,
                    "penaltyKcc" => $penalty_kcc,
                    "branchCode" => $branch_code,
                    "circle" => $circle,
                    "CardType" => $CardType,
                    "sponsorbank" => $sponsorbank,
                    "PenaltyGST" => $PenaltyGST,
                    "GSTIN" => $GSTIN,
                    "Paymentmode" => $Paymentmode,
                    "Interchange" => $Interchange,
                    "TranIdentifier" => $Tran_Identifier,
                    "SuperMID" => $SuperMID,
                    "ParentMID" => $ParentMID,
                    "filename" => $file_1_name,
                    "createdBy" => $userId,
                    "missingRemarks" => $missingStatus
                );


             

                if ($mer_code != '' && $tid != '') {
                    if (MFLInwardCardMISSBIPos::Insert( $data)) {
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
    public function importSBIAgencyData(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS|max:9048'
        ]);


        $file = $request->file('file');

        $destinationPath = storage_path('app/public/commercial/SbiAgencydata');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/SbiAgencydata/') . $file_1_name;


        // checking if the filename is in the db
        if (MFLInwardCashAgencyMISSBIPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
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
        $arrayCount = $spreadsheet->getActiveSheet()->getHighestRow();

        $error_msgs_arr = array();


        // setting the inserted count to zero
        $this->repository->startFrom(5);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_Inward_CashAgencyMIS_SBIPos",
            "bank" => "SBI Agency",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {

            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $colBank = "SBI Cash Agency";

                $SAPCode = trim(str_replace("'", '', $worksheet[$i]["M"])); // SAPCode
                // checking to see if SAP code is numeric
                $SAPCode = is_numeric($SAPCode) ? $SAPCode : 0; // if not numeric set it as zero

                $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($SAPCode);
                $retekCode = $storedata['RETEK Code'];
                $StoreID = $storedata['Store ID'];
                $brand = $storedata['Brand Desc'];

                $depositDate = ExcelBankStatement::convertDateForForBankSt(trim(str_replace("'", '', $worksheet[3]["A"])), 'SBI Agency Cash'); // deposit_dt
                $region = trim(str_replace("'", '', $worksheet[$i]["B"])); // region
                $location = trim(str_replace("'", '', $worksheet[$i]["C"])); // Location
                $pointName = trim(str_replace("'", '', $worksheet[$i]["D"])); // pointName
                $pointAddress = trim(str_replace("'", '', $worksheet[$i]["E"])); // pointAddress.
                $customerName = trim(str_replace("'", '', $worksheet[$i]["F"])); // customerName
                $pickupAgencyCode = trim(str_replace("'", '', $worksheet[$i]["G"])); // Agency Code
                $city = trim(str_replace("'", '', $worksheet[$i]["H"])); // city
                $poolingAccNo = trim(str_replace("'", '', $worksheet[$i]["I"])); // poolingAccNo
                $clientName = trim(str_replace("'", '', $worksheet[$i]["J"])); // clientName
                $clientCode = trim(str_replace("'", '', $worksheet[$i]["K"])); // clientCode
                $shortVANCode = trim(str_replace("'", '', $worksheet[$i]["L"])); // clientCode
                
                $LOLDate = ExcelBankStatement::convertDateForForBankSt(trim(str_replace("'", '', $worksheet[$i]["N"])), 'SBI Agency Cash'); // LOLDate
                
                $cashLimit = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["O"])); //Cash Limit
                $pickupFrequency = trim(str_replace("'", '', $worksheet[$i]["P"])); // pickupFrequency
                $HCINo = trim(str_replace("'", '', $worksheet[$i]["Q"])); // HCINo
                $pickupAmount = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["R"])); //pickupAmount
                $depositSlipNo = trim(str_replace("'", '', $worksheet[$i]["S"])); // depositSlipNo
                $depositAmount = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["T"])); //depositAmount
                $sealingTagNo = trim(str_replace("'", '', $worksheet[$i]["U"])); // depositSlipNo
                $depositBranchName = trim(str_replace("'", '', $worksheet[$i]["V"])); // depositBranchName
                $depositBranchCode = trim(str_replace("'", '', $worksheet[$i]["W"])); // depositBranchCode
                $vaultAmount = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["X"])); //Vault Amount

                $two2000 = trim(str_replace("'", '', $worksheet[$i]["Y"])); // two2000
                $one1000 = trim(str_replace("'", '', $worksheet[$i]["Z"])); // one1000
                $five500 = trim(str_replace("'", '', $worksheet[$i]["AA"])); // five500
                $two200 = trim(str_replace("'", '', $worksheet[$i]["AB"])); // two200
                $one100 = trim(str_replace("'", '', $worksheet[$i]["AC"])); // one100
                $fifty50 = trim(str_replace("'", '', $worksheet[$i]["AD"])); // fifty50
                $twenty20 = trim(str_replace("'", '', $worksheet[$i]["AE"])); // twenty20
                $ten10 = trim(str_replace("'", '', $worksheet[$i]["AF"])); // ten10
                $five5 = trim(str_replace("'", '', $worksheet[$i]["AG"])); // five5
                $others = trim(str_replace("'", '', $worksheet[$i]["AH"])); // others
                $total = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["AI"])); //total
                $difference = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["AJ"])); //difference

                $previousDayVaultDepositAmount = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["AK"])); //
                $accountNo = trim(str_replace("'", '', $worksheet[$i]["AL"])); // accountNo
                $branchName = trim(str_replace("'", '', $worksheet[$i]["AM"])); // branchName 
                $noOfChequesPickupDone = trim(str_replace("'", '', $worksheet[$i]["AN"])); // branchName 
                $recieptNo = trim(str_replace("'", '', $worksheet[$i]["AO"])); // recieptNo
                $depositionBank = trim(str_replace("'", '', $worksheet[$i]["AP"])); // depositionBank
                $depositionDate = ExcelBankStatement::convertDateForForBankSt(trim(str_replace("'", '', $worksheet[$i]["AQ"])), 'SBI Agency Cash'); // LOLDate
                $remarks = trim(str_replace("'", '', $worksheet[$i]["AR"])); // remarks
                $status = trim(str_replace("'", '', $worksheet[$i]["AS"])); // status
                $pointId = trim(str_replace("'", '', $worksheet[$i]["AT"])); // pointId


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
                    "retekCode" => $retekCode, // accountNo
                    "colBank" => $colBank,
                    "brand" => $brand,
                    "customerName" => $customerName,
                    "depositDate" => $depositDate,
                    "region" => $region,
                    "location" => $location,
                    "pointName" => $pointName,
                    "pointAddress" => $pointAddress,
                    "pickupAgencyCode" => $pickupAgencyCode,
                    "city" => $city,
                    "poolingAccNo" => $poolingAccNo,
                    "clientName" => $clientName,
                    "clientCode" => $clientCode,
                    'shortVanCode' => $shortVANCode,
                    "SAPCode" => $SAPCode,
                    "LOIDate" => $LOLDate,
                    "cashLimit" => $cashLimit,
                    "pickupFrequency" => $pickupFrequency,
                    "HCINo" => $HCINo,
                    "pickupAmount" => $pickupAmount,
                    "depositSlipNo" => $depositSlipNo,
                    "depositAmount" => $depositAmount,
                    "sealingTagNo" => $sealingTagNo,
                    "depositBranchName" => $depositBranchName,
                    "depositBranchCode" => $depositBranchCode,
                    "vaultAmount" => $vaultAmount,
                    "two2000" => $two2000,
                    "one1000" => $one1000,
                    "five500" => $five500,
                    "two200" => $two200,
                    "one100" => $one100,
                    "fifty50" => $fifty50,
                    "twenty20" => $twenty20,
                    "ten10" => $ten10,
                    "five5" => $five5,
                    "others" => $others,
                    "total" => $total,
                    "difference" => $difference,
                    "previousDayVaultDepositAmount" => $previousDayVaultDepositAmount,
                    "accountNo" => $accountNo,
                    "branchName" => $branchName,
                    "noOfChequesPickupDone" => $noOfChequesPickupDone,
                    "recieptNo" => $recieptNo,
                    "depositionBank" => $depositionBank,
                    "depositionDate" => $depositionDate,
                    "remarks" => $remarks,
                    "status" => $status,
                    "pointId" => $pointId,
                    "filename" => $file_1_name,
                    "createdBy" => Auth::id(),
                    "missingRemarks" => $missingStatus,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );


                $attributes = [
                    "storeID" => $StoreID,
                    "retekCode" => $retekCode, // accountNo
                    "colBank" => $colBank,
                    "brand" => $brand,
                    "customerName" => $customerName,
                    "depositDate" => $depositDate,
                    "region" => $region,
                    "location" => $location,
                    "pointName" => $pointName,
                    "pointAddress" => $pointAddress,
                    "pickupAgencyCode" => $pickupAgencyCode,
                    "city" => $city,
                    "poolingAccNo" => $poolingAccNo,
                    "clientName" => $clientName,
                    "clientCode" => $clientCode,
                    'shortVanCode' => $shortVANCode,
                    "SAPCode" => $SAPCode,
                    "LOIDate" => $LOLDate,
                    "cashLimit" => $cashLimit,
                    "pickupFrequency" => $pickupFrequency,
                    "HCINo" => $HCINo,
                    "pickupAmount" => $pickupAmount,
                    "depositSlipNo" => $depositSlipNo,
                    "depositAmount" => $depositAmount,
                    "sealingTagNo" => $sealingTagNo,
                    "depositBranchName" => $depositBranchName,
                    "depositBranchCode" => $depositBranchCode,
                    "vaultAmount" => $vaultAmount,
                    "two2000" => $two2000,
                    "one1000" => $one1000,
                    "five500" => $five500,
                    "two200" => $two200,
                    "one100" => $one100,
                    "fifty50" => $fifty50,
                    "twenty20" => $twenty20,
                    "ten10" => $ten10,
                    "five5" => $five5,
                    "others" => $others,
                    "total" => $total,
                    "difference" => $difference,
                    "previousDayVaultDepositAmount" => $previousDayVaultDepositAmount,
                    "accountNo" => $accountNo,
                    "branchName" => $branchName,
                    "noOfChequesPickupDone" => $noOfChequesPickupDone,
                    "recieptNo" => $recieptNo,
                    "depositionBank" => $depositionBank,
                    "depositionDate" => $depositionDate,
                    "remarks" => $remarks,
                    "status" => $status,
                    "pointId" => $pointId,
                    "createdBy" => Auth::id()
                ];

                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '') {
                    if (MFLInwardCashAgencyMISSBIPos::updateOrInsert($attributes, $data)) {
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
    public function OLD_FULLEXCEL_importSBIAgencyData_BACKUP(Request $request) {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS|max:9048'
        ]);

        try {
            $file = $request->file('file');
            $destinationPath = storage_path('app/public/commercial/SbiAgencydata');
            $getorinilfilename = $file->getClientOriginalName();
            $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/commercial/SbiAgencydata/') . $file_1_name;



            // checking if the filename is in the db
            if (MFLInwardCashAgencyMISSBIPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
                return response()->json(['message' => 'The Filename already exists on the Database'], 409);
            }

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

            $error_msgs_arr = array();

            for ($i = 2; $i <= $arrayCount; $i++) {


                $colBank = "SBI Cash Agency";

                $SAPCode = trim(str_replace("'", '', $worksheet[$i]["L"])); // SAPCode
                $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($SAPCode);
                $retekCode = $storedata['RETEK Code'];
                $StoreID = $storedata['Store ID'];


                $depositDate = ExcelBankStatement::convertDateForForBankSt(trim(str_replace("'", '', $worksheet[$i]["A"])), 'SBI Agency Cash'); // deposit_dt
                $region = trim(str_replace("'", '', $worksheet[$i]["B"])); // region
                $location = trim(str_replace("'", '', $worksheet[$i]["C"])); // Location
                $pointName = trim(str_replace("'", '', $worksheet[$i]["D"])); // pointName
                $pointAddress = trim(str_replace("'", '', $worksheet[$i]["E"])); // pointAddress.
                $customerName = trim(str_replace("'", '', $worksheet[$i]["F"])); // customerName
                $pickupAgencyCode = trim(str_replace("'", '', $worksheet[$i]["G"])); // Agency Code
                $city = trim(str_replace("'", '', $worksheet[$i]["H"])); // city
                $poolingAccNo = trim(str_replace("'", '', $worksheet[$i]["I"])); // poolingAccNo
                $clientName = trim(str_replace("'", '', $worksheet[$i]["J"])); // clientName
                $clientCode = trim(str_replace("'", '', $worksheet[$i]["K"])); // clientName
                $LOLDate = ExcelBankStatement::convertDateForForBankSt(trim(str_replace("'", '', $worksheet[$i]["M"])), 'SBI Agency Cash'); // LOLDate
                $cashLimit = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["N"])); //Cash Limit
                $pickupFrequency = trim(str_replace("'", '', $worksheet[$i]["O"])); // clientName
                $HCINo = trim(str_replace("'", '', $worksheet[$i]["P"])); // HCINo
                $pickupAmount = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["Q"])); //Cash Limit
                $depositSlipNo = trim(str_replace("'", '', $worksheet[$i]["R"])); // depositSlipNo
                $depositAmount = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["S"])); //depositAmount
                $sealingTagNo = trim(str_replace("'", '', $worksheet[$i]["T"])); // depositSlipNo
                $depositBranchName = trim(str_replace("'", '', $worksheet[$i]["U"])); // depositBranchName
                $depositBranchCode = trim(str_replace("'", '', $worksheet[$i]["V"])); // depositBranchCode
                $vaultAmount = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["W"])); //Vault Amount

                $two2000 = trim(str_replace("'", '', $worksheet[$i]["X"])); // two2000
                $one1000 = trim(str_replace("'", '', $worksheet[$i]["Y"])); // one1000
                $five500 = trim(str_replace("'", '', $worksheet[$i]["Z"])); // five500
                $two200 = trim(str_replace("'", '', $worksheet[$i]["AA"])); // two200
                $one100 = trim(str_replace("'", '', $worksheet[$i]["AB"])); // one100
                $fifty50 = trim(str_replace("'", '', $worksheet[$i]["AC"])); // fifty50
                $twenty20 = trim(str_replace("'", '', $worksheet[$i]["AD"])); // twenty20
                $ten10 = trim(str_replace("'", '', $worksheet[$i]["AE"])); // ten10
                $five5 = trim(str_replace("'", '', $worksheet[$i]["AF"])); // five5
                $others = trim(str_replace("'", '', $worksheet[$i]["AG"])); // others
                $total = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["AH"])); //total
                $difference = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["AI"])); //difference

                $previousDayVaultDepositAmount = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["AJ"])); //
                $accountNo = trim(str_replace("'", '', $worksheet[$i]["AK"])); // accountNo
                $branchName = trim(str_replace("'", '', $worksheet[$i]["AL"])); // branchName 
                $noOfChequesPickupDone = trim(str_replace("'", '', $worksheet[$i]["AM"])); // branchName 
                $recieptNo = trim(str_replace("'", '', $worksheet[$i]["AN"])); // recieptNo
                $depositionBank = trim(str_replace("'", '', $worksheet[$i]["AO"])); // depositionBank
                $depositionDate = ExcelBankStatement::convertDateForForBankSt(trim(str_replace("'", '', $worksheet[$i]["AP"])), 'SBI Agency Cash'); // LOLDate
                $remarks = trim(str_replace("'", '', $worksheet[$i]["AQ"])); // remarks
                $status = trim(str_replace("'", '', $worksheet[$i]["AR"])); // status
                $pointId = trim(str_replace("'", '', $worksheet[$i]["AS"])); // pointId



                $data = array(
                    "storeID" => $StoreID,
                    "retekCode" => $retekCode, // accountNo
                    "colBank" => $colBank,
                    "customerName" => $customerName,
                    "depositDate" => $depositDate,
                    "region" => $region,
                    "location" => $location,
                    "pointName" => $pointName,
                    "pointAddress" => $pointAddress,
                    "pickupAgencyCode" => $pickupAgencyCode,
                    "city" => $city,
                    "poolingAccNo" => $poolingAccNo,
                    "clientName" => $clientName,
                    "clientCode" => $clientCode,
                    "SAPCode" => $SAPCode,
                    "LOIDate" => $LOLDate,
                    "cashLimit" => $cashLimit,
                    "pickupFrequency" => $pickupFrequency,
                    "HCINo" => $HCINo,
                    "pickupAmount" => $pickupAmount,
                    "depositSlipNo" => $depositSlipNo,
                    "depositAmount" => $depositAmount,
                    "sealingTagNo" => $sealingTagNo,
                    "depositBranchName" => $depositBranchName,
                    "depositBranchCode" => $depositBranchCode,
                    "vaultAmount" => $vaultAmount,
                    "two2000" => $two2000,
                    "one1000" => $one1000,
                    "five500" => $five500,
                    "two200" => $two200,
                    "one100" => $one100,
                    "fifty50" => $fifty50,
                    "twenty20" => $twenty20,
                    "ten10" => $ten10,
                    "five5" => $five5,
                    "others" => $others,
                    "total" => $total,
                    "difference" => $difference,
                    "previousDayVaultDepositAmount" => $previousDayVaultDepositAmount,
                    "accountNo" => $accountNo,
                    "branchName" => $branchName,
                    "noOfChequesPickupDone" => $noOfChequesPickupDone,
                    "recieptNo" => $recieptNo,
                    "depositionBank" => $depositionBank,
                    "depositionDate" => $depositionDate,
                    "remarks" => $remarks,
                    "status" => $status,
                    "pointId" => $pointId,
                    "filename" => $file_1_name,
                    "createdBy" => Auth::id()
                );


                $attributes = [

                    "storeID" => $StoreID,
                    "retekCode" => $retekCode, // accountNo
                    "colBank" => $colBank,
                    "customerName" => $customerName,
                    "depositDate" => $depositDate,
                    "region" => $region,
                    "location" => $location,
                    "pointName" => $pointName,
                    "pointAddress" => $pointAddress,
                    "pickupAgencyCode" => $pickupAgencyCode,
                    "city" => $city,
                    "poolingAccNo" => $poolingAccNo,
                    "clientName" => $clientName,
                    "clientCode" => $clientCode,
                    "SAPCode" => $SAPCode,
                    "LOIDate" => $LOLDate,
                    "cashLimit" => $cashLimit,
                    "pickupFrequency" => $pickupFrequency,
                    "HCINo" => $HCINo,
                    "pickupAmount" => $pickupAmount,
                    "depositSlipNo" => $depositSlipNo,
                    "depositAmount" => $depositAmount,
                    "sealingTagNo" => $sealingTagNo,
                    "depositBranchName" => $depositBranchName,
                    "depositBranchCode" => $depositBranchCode,
                    "vaultAmount" => $vaultAmount,
                    "two2000" => $two2000,
                    "one1000" => $one1000,
                    "five500" => $five500,
                    "two200" => $two200,
                    "one100" => $one100,
                    "fifty50" => $fifty50,
                    "twenty20" => $twenty20,
                    "ten10" => $ten10,
                    "five5" => $five5,
                    "others" => $others,
                    "total" => $total,
                    "difference" => $difference,
                    "previousDayVaultDepositAmount" => $previousDayVaultDepositAmount,
                    "accountNo" => $accountNo,
                    "branchName" => $branchName,
                    "noOfChequesPickupDone" => $noOfChequesPickupDone,
                    "recieptNo" => $recieptNo,
                    "depositionBank" => $depositionBank,
                    "depositionDate" => $depositionDate,
                    "remarks" => $remarks,
                    "status" => $status,
                    "pointId" => $pointId,
                    "createdBy" => Auth::id()
                ];

                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '') {

                    MFLInwardCashAgencyMISSBIPos::updateOrInsert($attributes, $data);
                }
            }
            return response()->json(['message' => 'Success'], 200);

        } catch (CustomModelNotFoundException $exception) {
            return $exception->render($exception);
        }
    }






    /**
     * Logout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): RedirectResponse {
        // Logging the user out
        Auth::logout();
        // Clearing the menus
        Cache::forget('menus');
        // regenarate the session
        session()->regenerate();
        session()->regenerateToken();

        return redirect()->route('login');
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