<?php

namespace App\Http\Controllers\CommercialTeam\Upload;

use App\Http\Controllers\Controller;

// Request

use Illuminate\Http\Request;


// Response

use Illuminate\Http\RedirectResponse;

// Model
use App\Models\MICICIMID;
use App\Models\MFLInwardCardMISIciciPos;
use App\Models\MFLinwardCashMISIciciPos;

// Exception

use Exception;

// Services

use App\Services\GeneralService;
use App\Services\ParseDateService;
use App\Services\ExcelUploadGeneralService;

// Others

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Log;




class ICICIController extends Controller {

    public function ICICIUpload(Request $request) {
        try {


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
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

            $error_msgs_arr = array();

            for ($i = 2; $i <= $arrayCount; $i++) {


                $col_bank = config('constants.ICICI.cashBankName'); // bankName

                $pkup_pt_code = trim(str_replace("'", '', $worksheet[$i]["R"])); // HIR CD

                $retekCode = ExcelUploadGeneralService::getReteckCodeUsingPkupForICICICash($pkup_pt_code);
                $StoreID = ExcelUploadGeneralService::getSAPCodeUsingRetekCodeForICICICash($retekCode);

                $tran_type = trim(str_replace("'", '', $worksheet[$i]["A"])); // TYPE
                $cust_code = trim(str_replace("'", '', $worksheet[$i]["B"])); // CUS CODE
                $prd_code = trim(str_replace("'", '', $worksheet[$i]["C"])); // PRD CODE
                $location_name = trim(str_replace("'", '', $worksheet[$i]["E"])); // LOCATION NAME

                //$deposite_date = trim($worksheet[$i]["F"]); // DEP DATE

                $deposite_date = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["F"])), 'ICICI Cash MIS'); // DEP DATE
                //dd($deposite_date);
                $adj_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["H"])), 'ICICI Cash MIS'); // ADJ DATE
                $cr_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["J"])), 'ICICI Cash MIS'); // CR DATE

                $dep_slip_no = trim(str_replace("'", '', $worksheet[$i]["O"])); // SLIP NO.

                $slip_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["V"]))); // SLIP AMOUNT
                $adj_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["AO"]))); // ADJUSTED AMOUNT

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
                $data = array(
                    "storeID" => $StoreID,
                    "retekCode" => $retekCode,
                    'colBank' => $col_bank,
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
                    "createdBy" => $userId
                );
                if ($tran_type != '' && $pkup_pt_code != '') {

                    $attributes = [
                        "storeID" => $StoreID,
                        "retekCode" => $retekCode,
                        'colBank' => $col_bank,
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
                        "createdBy" => $userId
                    ];
                    MFLinwardCashMISIciciPos::updateOrInsert($attributes, $data);
                }
            }
            return response()->json(['message' => 'Success'], 200);

        } catch (\Throwable $exception) {
            dd($exception);
            throw new Exception('Something went wrong');
        }
    }


    public function ICICIcardUpload(Request $request) {
        try {
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
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);


            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

            $error_msgs_arr = array();

            for ($i = 2; $i <= $arrayCount; $i++) {

                $col_bank = config('constants.ICICI.cardBankName'); // bankName
                $acct_no = config('constants.ICICI.cardaccountNumber');
                ; // ICICICardAc

                $merCode = trim(str_replace("'", '', $worksheet[$i]["D"])); // TRADE NAME
                $tid = trim(str_replace("'", '', $worksheet[$i]["T"])); // TID
                $mid = trim(str_replace("'", '', $worksheet[$i]["B"])); // MID


                $retekCode = GeneralService::getReteckCodeUsingTIDForICICI($mid);
                $storeID = GeneralService::getStoreIDUsingRetekCodeForICICI($retekCode);

                $depositDt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["M"]), 'ICICI Card'); // TRANSACTION DATE
                $crDt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["N"]), 'ICICI Card'); // POST DATE


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
                $data = array(
                    "storeID" => $storeID,
                    "retekCode" => $retekCode,
                    "colBank" => $col_bank,
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
                    "createdBy" => $userId
                );
                $attributes = [
                    "storeID" => $storeID,
                    "retekCode" => $retekCode,
                    "colBank" => $col_bank,
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
                ];

                if ($merCode != '' && $mid != '') {

                    // Assuming $data contains the attributes and values for the user

                    MFLInwardCardMISIciciPos::updateOrInsert($attributes, $data);
                }

            }
            return response()->json(['message' => 'Success'], 200);

        } catch (CustomModelNotFoundException $exception) {
            // dd($exception);
            return $exception->render($exception);
            // throw new Exception('Something went wrong');
        }
    }
}
