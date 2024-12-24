<?php

namespace App\Http\Controllers\CommercialHead\Upload;

use App\Http\Controllers\Controller;
use App\Interface\MisReadLogsInterface;
use App\Models\BrandNotConsider;
// Request

use App\Models\Logs\UploadLog;
use Illuminate\Http\Request;



// Response

use Illuminate\Http\RedirectResponse;

// Model

use App\Models\MRepository;
use App\Models\MFLInwardCashMISAxisPos;



// Exception

use Exception;

// Services

use App\Services\GeneralService;
use App\Services\ParseDateService;
use App\Services\ExcelUploadGeneralService;
use App\Traits\GenerateTotalHTML;
// Others

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Log;
use Illuminate\Support\Str;



class AxisController extends Controller {

    use GenerateTotalHTML;

    public function __construct(
        public MisReadLogsInterface $repository
    ) {
    }




    public function importAxisCashData(Request $request) {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS|max:120000'
        ]);


        $file = $request->file('file');
        $destinationPath = storage_path('app/public/commercial/axiscashdata');

        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/axiscashdata/') . $file_1_name;


        // checking if the filename is in the db
        if (MFLInwardCashMISAxisPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
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
            "table" => "MFL_Inward_CashMIS_HdfcPos",
            "bank" => "HDFC Cash",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {

            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $col_bank = config('constants.AXIS.cashBankName'); // bankName

                $pkup_pt_code = trim(str_replace("'", '', $worksheet[$i]["BO"])); //PICKUP POINT CODE
                $tran_type = trim(str_replace("'", '', $worksheet[$i]["A"])); // TYPE
                $cust_code = trim(str_replace("'", '', $worksheet[$i]["B"])); // CUS CODE
                $prd_code = trim(str_replace("'", '', $worksheet[$i]["C"])); // PRD CODE
                $location_name = trim(str_replace("'", '', $worksheet[$i]["E"])); // LOCATION NAME     

                $dep_slip_no = trim(str_replace("'", '', $worksheet[$i]["P"])); // SLIP NO.
                $dep_slip_retekCode = strlen($dep_slip_no) >= 8 ? Str::substr($dep_slip_no, 1, 4) : null; // SLIP NO.

                $storedata = ExcelUploadGeneralService::getRetekCodeFromDepositSlipNo(depositSlip: $dep_slip_retekCode, pickUpCode: $pkup_pt_code);
                # check if the store id is valid store id
                // $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload(store_id: !$dep_slip_retekCode ? $pkup_pt_code : $dep_slip_retekCode);

                $retakeCode = $storedata['RETEK Code'];
                $storeID = $storedata['Store ID'];
                $brand = $storedata['Brand Desc'];

                $deposit_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["H"]), 'Axis Cash MIS'); // DEP DATE
                $adj_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["I"]), 'Axis Cash MIS'); // ADJ DATE                
                $cr_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["K"]), 'Axis Cash MIS'); // CR DATE               


                $deposit_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["W"])); // SLIP AMOUNT
                $adj_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["AP"])); // ADJUSTED AMOUNT

                $return_reason = trim(str_replace("'", '', $worksheet[$i]["BA"])); // RETURN REASON
                $hir_code = trim(str_replace("'", '', $worksheet[$i]["S"])); // HIR CD
                $hir_name = trim(str_replace("'", '', $worksheet[$i]["T"])); // HIERARCHY NAME
                $deposit_br = trim(str_replace("'", '', $worksheet[$i]["F"])); // Depost Branch
                $deposit_br_name = trim(str_replace("'", '', $worksheet[$i]["G"])); // Depost Branch Name
                $location_short = trim(str_replace("'", '', $worksheet[$i]["D"])); // LOCAT

                $clg_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["J"]), 'Axis Cash MIS'); // CLG DATE
                $rec_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["L"]), 'Axis Cash MIS'); // REC DATE
                $rtn_date = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["M"]), 'Axis Cash MIS'); // RTN DATE
                $rev_date = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["N"]), 'Axis Cash MIS'); // REV DATE
                $real_date = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["O"]), 'Axis Cash MIS'); // REAL DATE

                $division_code = trim(str_replace("'", '', $worksheet[$i]["Q"])); // DIV CD
                $division_name = trim(str_replace("'", '', $worksheet[$i]["R"])); // DIVISION NAME
                $adj_value = trim(str_replace("'", '', $worksheet[$i]["U"])); // ADJ
                $no_of_inst = trim(str_replace("'", '', $worksheet[$i]["V"])); // NOF INS

                $sub_customer_code = trim(str_replace("'", '', $worksheet[$i]["Y"])); // SUB CUS
                $sub_customer_name = trim(str_replace("'", '', $worksheet[$i]["Z"])); // SUB CUSTOMER NAME
                $d_s_addl_info_code1 = trim(str_replace("'", '', $worksheet[$i]["AA"])); // D.S ADDTNL INFO CODE1
                $d_s_addl_info1 = trim(str_replace("'", '', $worksheet[$i]["AB"])); // D.S. ADDITIONAL INFORMATION 1
                $d_s_addl_info_code2 = trim(str_replace("'", '', $worksheet[$i]["AC"])); // D.S ADDTNL INFO CODE2
                $d_s_addl_info2 = trim(str_replace("'", '', $worksheet[$i]["AD"])); // D.S. ADDITIONAL INFORMATION 2
                $d_s_addl_info_code3 = trim(str_replace("'", '', $worksheet[$i]["AE"])); // D.S ADDTNL INFO CODE3
                $d_s_addl_info3 = trim(str_replace("'", '', $worksheet[$i]["AF"])); // D.S. ADDITIONAL INFORMATION 3
                $d_s_addl_info_code4 = trim(str_replace("'", '', $worksheet[$i]["AG"])); // D.S ADDTNL INFO CODE4
                $d_s_addl_info4 = trim(str_replace("'", '', $worksheet[$i]["AH"])); // D.S. ADDITIONAL INFORMATION 4
                $d_s_addl_info_code5 = trim(str_replace("'", '', $worksheet[$i]["AI"])); // D.S ADDTNL INFO CODE5
                $d_s_addl_info5 = trim(str_replace("'", '', $worksheet[$i]["AJ"])); // D.S. ADDITIONAL INFORMATION 5                
                $inst_sl = trim(str_replace("'", '', $worksheet[$i]["AK"])); // IN SL
                $inst_no = trim(str_replace("'", '', $worksheet[$i]["AL"])); // INST NO
                $inst_type = trim(str_replace("'", '', $worksheet[$i]["AO"])); // INSTRUMENT TYPE


                $inst_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["AM"]), 'Axis Cash MIS'); // INST DATE

                $recoveredAmount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["X"])); // RECOVERED AMOUNT
                $inst_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["AN"])); // INST AMOUNT

                $adj_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["AP"])); // ADJUSTED AMOUNT
                $recovered_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["AQ"])); // RECOVERED AMOUNT
                $return_amt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["AZ"])); // RTN



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

                $userId = auth()->user()->userUID;

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
                    "tranType" => $tran_type,
                    "custCode" => $cust_code,
                    "prdCode" => $prd_code,
                    "locationName" => $location_name,
                    "depositDt" => $deposit_dt,
                    "adjDt" => $adj_dt,
                    "crDt" => $cr_dt,
                    "depSlipNo" => $dep_slip_no,
                    "depositAmount" => $deposit_amount,
                    "adjAmount" => $adj_amount,
                    "returnReason" => $return_reason,
                    "hirCode" => $hir_code,
                    "hirName" => $hir_name,
                    "depositBr" => $deposit_br,
                    "depositBrName" => $deposit_br_name,
                    "locationShort" => $location_short,
                    "clgDt" => $clg_dt,
                    "recDt" => $rec_dt,
                    "rtnDt" => $rtn_date,
                    "revDt" => $rev_date,
                    "realisationDt" => $real_date,
                    "divisionCode" => $division_code,
                    "divisionName" => $division_name,
                    "adj" => $adj_value,
                    "noOfInst" => $no_of_inst,
                    "recoveredAmount" => $recoveredAmount,
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
                    "filename" => $file_1_name,
                    "createdBy" => $userId,
                    "missingRemarks" => $missingStatus,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );



                if ($cust_code != '' && $tran_type != '') {
                    if (MFLInwardCashMISAxisPos::Insert($data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }

            }

            // finializing the logs
            $this->repository->finializeLog();

            return response()->json([
                'message' => 'Success',
                "data" => $this->generateHTML(function () use ($getorinilfilename) {
                    return MFLInwardCashMISAxisPos::select(
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