<?php

namespace App\Http\Controllers\Administrator\Upload;

use App\Http\Controllers\Controller;

// Request

use Illuminate\Http\Request;


// Response

use Illuminate\Http\RedirectResponse;

// Model
use App\Models\MFLInwardCashMISSBIPos;
use App\Models\MFLInwardCardMISSBIPos;

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



class SBIController extends Controller
{


    /**
     * SBI Uploads
     * @return void
     */
    public function importSBICashData(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS|max:9048'
        ]);


        try {
            // Retrieve the uploaded file
            $file = $request->file('file');

            $destinationPath = storage_path('app/public/admin/SbiCashdata');
            $getorinilfilename= $file->getClientOriginalName();
            $file_1_name = $getorinilfilename."_".Carbon::now()->format('d-m-Y')."_".time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/admin/SbiCashdata/') . $file_1_name;
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

            $error_msgs_arr = array();




            for ($i = 2; $i <= $arrayCount; $i++) {

                $col_bank = config('constants.SBI.cashBankName'); // bankName
                $pkup_pt_code = trim($worksheet[$i]["E"]); // CUST_REF_NO

                $retakeCode = ExcelUploadGeneralService::getReteckCodeUsingPkupForSBICash($pkup_pt_code);
                $storeID = ExcelUploadGeneralService::getSAPCodeUsingRetekCodeForSBICash($retakeCode);


                $cust_code = trim($worksheet[$i]["B"]); // CUSTOMER_CODE
                $prd_code = trim($worksheet[$i]["D"]); // PRODUCT_CODE
                $location_name = trim($worksheet[$i]["C"]); // LOCATION_NAME

                //$deposit_dt = trim($worksheet[$i]["G"]); // DEPOSIT_DATE
                $deposit_dt=ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["G"]),'SBI Cash MIS'); // DEP DATE
                //$crDt==ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["G"]),'SBI Cash MIS'); // DEP DATE
                $deposit_slipno = trim($worksheet[$i]["F"]); // DEPOSIT_SLIP_NO

                $total_amount = trim(str_replace(',', '',$worksheet[$i]["I"])); // TOTAL_PAID_AMT


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
                $inst_dt=ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["L"]),'SBI Cash MIS'); // INSTRUMENT_DATE
                $inst_amt = trim(str_replace(',', '',$worksheet[$i]["K"])); // INSTRUMENT_AMT


                $drn_bk = trim($worksheet[$i]["M"]); // DRAWEE_BANK
                $drn_br = trim($worksheet[$i]["N"]); // DRAWEE_BRANCH
                $drawer_name = trim($worksheet[$i]["O"]); // DRAWER_NAME
                $debtor_acc_no = trim($worksheet[$i]["P"]); // DEBTOR_ACC_NO
                $e2 = trim($worksheet[$i]["Z"]); // S_NO


                $userId = Auth::id();

                $data = array(
                    "storeID" => $storeID,
                    "retekCode" => $retakeCode,
                    "colBank" => $col_bank,
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
                    "filename"=> $file_1_name,
                    "createdBy" => $userId
                );

                 $attributes = [
                   "storeID" => $storeID,
                    "retekCode" => $retakeCode,
                    "colBank" => $col_bank,
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


                if($cust_code != '' && $prd_code !=''){

                    MFLInwardCashMISSBIPos::updateOrInsert($attributes, $data);
                }

            }

             return response()->json(['message' => 'Success'], 200);


        } catch (\Throwable $exception) {
            dd($exception);
            throw new Exception('Something went wrong');
        }
    }



     public function importSBICardData(Request $request)
    {


        try {
            // Retrieve the uploaded file
            $request->validate([
                'file' => 'required|mimes:csv,txt,xls,xlsx,XLS|max:9048'
            ]);


            $file = $request->file('file');

            $destinationPath = storage_path('app/public/admin/SbiCarddata');
            $getorinilfilename= $file->getClientOriginalName();
            $file_1_name = $getorinilfilename."_".Carbon::now()->format('d-m-Y')."_".time() . '.' . $file->getClientOriginalExtension();

            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/admin/SbiCarddata/') . $file_1_name;
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

            $error_msgs_arr = array();




            for ($i = 2; $i <= $arrayCount; $i++) {

                $col_bank = config('constants.SBI.cardBankName'); // bankName
                $acct_no = "Account Number"; // SBICardAc
                $mer_code = trim(str_replace("'", '',$worksheet[$i]["AB"])); // Accountnr
                $tid = trim(str_replace("'", '',$worksheet[$i]["B"])); // TID
                $mid = trim(str_replace("'", '',$worksheet[$i]["A"])); // MID

                $retekCode=ExcelUploadGeneralService::getReteckCodeUsingTIDForSBI($mid);
                $storeID=ExcelUploadGeneralService::getStoreIDUsingRetekCodeForSBI($retekCode);

                $deposit_dt = trim($worksheet[$i]["E"]); // Tran Date
                $cr_dt = trim($worksheet[$i]["F"]); // Stl Date

                $deposit_dt=ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["E"]),'SBI Card'); // Tran Date
                $cr_dt=ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["F"]),'SBI Card'); // Stl Date


                $deposit_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '',trim($worksheet[$i]["K"]))); // Txn Amount

                $mdr_rate = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '',trim($worksheet[$i]["L"]))); // MDR Rate
                $msf_comm = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '',trim($worksheet[$i]["M"]))); // MDR Amount
                $gst_total = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '',trim($worksheet[$i]["AG"]))); // GST
                $net_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '',trim($worksheet[$i]["O"]))); // Net Amount

                /*$mdr_rate = trim(str_replace(',', '',$worksheet[$i]["L"])); // MDR Rate
                $msf_comm = trim(str_replace(',', '',$worksheet[$i]["M"])); // MDR Amount
                $gst_total = trim(str_replace(',', '',$worksheet[$i]["AG"])); // GST
                $net_amount = trim(str_replace(',', '',$worksheet[$i]["O"])); // Net Amount*/

                $card_type = trim(str_replace("'", '',$worksheet[$i]["J"])); // cardtype
                $card_number = trim(str_replace("'", '',$worksheet[$i]["D"])); // PAN
                $approv_code = trim(str_replace("'", '',$worksheet[$i]["I"])); // Auth Code
                $serv_tax = trim(str_replace("'", '',$worksheet[$i]["N"])); // ServiceTax

                $sb_cess = trim(str_replace(',', '',$worksheet[$i]["X"])); // Swachh Bharat Cess
                $kk_cess = trim(str_replace(',', '',$worksheet[$i]["Y"])); // Krishi Kalyan Cess
                $arn_no = trim(str_replace("'", '',$worksheet[$i]["H"])); // RRN
                $bat_nbr = trim($worksheet[$i]["AK"]); // BatchNr

                $tran_type = trim(str_replace("'", '',$worksheet[$i]["AM"])); // TranType
                $name_And_loc = trim(str_replace("'", '',$worksheet[$i]["C"])); // NAME AND LOC
                $mcc = trim(str_replace("'", '',$worksheet[$i]["G"])); // MCC
                $onus_offus= trim(str_replace("'", '',$worksheet[$i]["P"])); // On US / Off US

                $penalty_mdr_rate = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '',trim($worksheet[$i]["Q"]))); // Penalty Mdr Rate
                $penalty_mdr_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '',trim($worksheet[$i]["R"]))); // Penalty Mdr Amt
                $penalty_service_tax = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '',trim($worksheet[$i]["S"]))); // Penalty Service Tax
                $cashback_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '',trim($worksheet[$i]["T"]))); // Cashback Amt

               /* $penalty_mdr_rate= trim(str_replace(',', '',$worksheet[$i]["Q"])); // Penalty Mdr Rate
                $penalty_mdr_amt= trim(str_replace(',', '',$worksheet[$i]["R"])); // Penalty Mdr Amt
                $penalty_service_tax= trim(str_replace(',', '',$worksheet[$i]["S"])); // Penalty Service Tax
                $cashback_amt= trim(str_replace(',', '',$worksheet[$i]["T"])); // Cashback Amt*/

                $inc_mdr_rate= trim(str_replace(',', '',$worksheet[$i]["U"])); // Inc Mdr Rate
                $inc_amt= trim(str_replace(',', '',$worksheet[$i]["V"])); // Inc Amt
                $inc_service_tax= trim(str_replace(',', '',$worksheet[$i]["W"])); // Inc Service Tax
                $penalty_sbc= trim(str_replace(',', '',$worksheet[$i]["Z"])); // PenaltySBC


                $penalty_kcc = trim(str_replace(',', '',$worksheet[$i]["AA"])); // PenaltyKCC
                $branch_code = trim(str_replace(',', '',$worksheet[$i]["AC"])); // BranchCode
                $circle = trim(str_replace(',', '',$worksheet[$i]["AD"])); // circle

                $CardType   = trim(str_replace("'", '',$worksheet[$i]["AE"])); // CardType
                $sponsorbank   = trim(str_replace("'", '',$worksheet[$i]["AF"])); // sponsorbank
                $PenaltyGST = trim(str_replace(',', '',$worksheet[$i]["AH"])); // PenaltyGST
                $GSTIN = trim(str_replace("'", '',$worksheet[$i]["AI"])); // GSTIN
                $Paymentmode = trim(str_replace("'", '',$worksheet[$i]["AJ"])); // Paymentmode
                $Interchange = trim(str_replace("'", '',$worksheet[$i]["AL"])); // Interchange
                $Tran_Identifier = trim(str_replace("'", '',$worksheet[$i]["AN"])); // Tran_Identifier
                $SuperMID = trim(str_replace("'", '',$worksheet[$i]["AO"])); // SuperMID
                $ParentMID = trim(str_replace("'", '',$worksheet[$i]["AP"])); // ParentMID

                $userId = Auth::id();

                $data = array(
                        "storeID" => $storeID,
                        "retekCode" => $retekCode ,
                        "colBank" => $col_bank,
                        "acctNo" => $acct_no,
                        "merCode" => $mer_code,
                        "tid" => $tid,
                        "mid" => $mid,
                        "depositDt" => $deposit_dt,
                        "depositAmount"=> $deposit_amount,
                        "crDt" => $cr_dt,
                        "mdrRate" =>   $mdr_rate,
                        "msfComm" =>  $msf_comm,
                        "gstTotal" =>  $gst_total,
                        "netAmount" => $net_amount,
                        "cardTypes" =>  $card_type,
                        "cardNumber" => $card_number,
                        "approvCode" => $approv_code,
                        "servTax" => $serv_tax,
                        "sbCess" => $sb_cess,
                        "kkCess" => $kk_cess,
                        "arnNo" => $arn_no,
                        "batNbr" => $bat_nbr,
                        "tranType" =>$tran_type,
                        "nameAndLoc" =>$name_And_loc,
                        "mcc" =>$mcc,
                        "onusOffus" =>$onus_offus,
                        "penaltyMdrRate" =>$penalty_mdr_rate,
                        "penaltyMdrAmt" =>$penalty_mdr_amt,
                        "penaltyServiceTax" =>$penalty_service_tax,
                        "cashbackAmt" =>$cashback_amt,
                        "incMdrRate" =>$inc_mdr_rate,
                        "incAmt" =>$inc_amt,
                        "incServiceTax" =>$inc_service_tax,
                        "penaltySbc" =>$penalty_sbc,
                        "penaltyKcc" =>$penalty_kcc,
                        "branchCode" =>$branch_code,
                        "circle" =>$circle,
                        "CardType" =>$CardType,
                        "sponsorbank" =>$sponsorbank,
                        "PenaltyGST" => $PenaltyGST,
                        "GSTIN" => $GSTIN,
                        "Paymentmode" =>$Paymentmode,
                        "Interchange"  =>$Interchange,
                        "TranIdentifier" => $Tran_Identifier,
                        "SuperMID" => $SuperMID,
                        "ParentMID" => $ParentMID,
                        "filename"=> $file_1_name,
                        "createdBy" => $userId
                );


               $attributes = [
                        "storeID" => $storeID,
                        "retekCode" => $retekCode ,
                        "colBank" => $col_bank,
                        "acctNo" => $acct_no,
                        "merCode" => $mer_code,
                        "tid" => $tid,
                        "mid" => $mid,
                        "depositDt" => $deposit_dt,
                        "depositAmount"=> $deposit_amount,
                        "crDt" => $cr_dt,
                        "mdrRate" =>   $mdr_rate,
                        "msfComm" =>  $msf_comm,
                        "gstTotal" =>  $gst_total,
                        "netAmount" => $net_amount,
                        "cardTypes" =>  $card_type,
                        "cardNumber" => $card_number,
                        "approvCode" => $approv_code,
                        "servTax" => $serv_tax,
                        "sbCess" => $sb_cess,
                        "kkCess" => $kk_cess,
                        "arnNo" => $arn_no,
                        "batNbr" => $bat_nbr,
                        "tranType" =>$tran_type,
                        "nameAndLoc" =>$name_And_loc,
                        "mcc" =>$mcc,
                        "onusOffus" =>$onus_offus,
                        "penaltyMdrRate" =>$penalty_mdr_rate,
                        "penaltyMdrAmt" =>$penalty_mdr_amt,
                        "penaltyServiceTax" =>$penalty_service_tax,
                        "cashbackAmt" =>$cashback_amt,
                        "incMdrRate" =>$inc_mdr_rate,
                        "incAmt" =>$inc_amt,
                        "incServiceTax" =>$inc_service_tax,
                        "penaltySbc" =>$penalty_sbc,
                        "penaltyKcc" =>$penalty_kcc,
                        "branchCode" =>$branch_code,
                        "circle" =>$circle,
                        "CardType" =>$CardType,
                        "sponsorbank" =>$sponsorbank,
                        "PenaltyGST" => $PenaltyGST,
                        "GSTIN" => $GSTIN,
                        "Paymentmode" =>$Paymentmode,
                        "Interchange"  =>$Interchange,
                        "TranIdentifier" => $Tran_Identifier,
                        "SuperMID" => $SuperMID,
                        "ParentMID" => $ParentMID,
                        "createdBy" => $userId
                ];

                if($mer_code != '' && $tid !=''){

                    MFLInwardCardMISSBIPos::updateOrInsert($attributes, $data);
                }

            }

             return response()->json(['message' => 'Success'], 200);


        } catch (CustomModelNotFoundException $exception) {
           return $exception->render($exception);
            //throw new Exception('Something went wrong');
        }
    }

    /**
     * Logout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        // Logging the user out
        Auth::logout();
        // Clearing the menus
        Cache::forget('menus');
        // regenarate the session
        session()->regenerate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

}
