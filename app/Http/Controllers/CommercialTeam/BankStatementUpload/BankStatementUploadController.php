<?php

namespace App\Http\Controllers\CommercialTeam\Upload;

use App\Http\Controllers\Controller;

// Request

use Illuminate\Http\Request;

// Response

use Illuminate\Http\RedirectResponse;

// Others
use App\Services\GeneralService;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;


class BankStatementUploadController extends Controller {

    public function bankStatementHDFCUpload(Request $request) {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        try {

            $file = $request->file('file');
            $destinationPath = storage_path('app/public/commercial/BankStatement/HDFC');
            $file_1_name = Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/commercial/BankStatement/HDFC/') . $file_1_name;

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            ;
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

            $error_msgs_arr = array();

            for ($i = 2; $i <= $arrayCount; $i++) {

                $colBank = config('constants.HDFC.BankStatementName'); // bankName
                $accountnumber = trim($worksheet[$i]["A"]);
                ; // AccountNumber
                $deposit_dt = trim($worksheet[$i]["B"]); // deposit_dt
                $book_dt = trim($worksheet[$i]["C"]); // book_dt
                $description = trim($worksheet[$i]["D"]); // description
                if (trim($worksheet[$i]["E"] == "")) {
                    $ledger_bal = "0.00";
                } else {
                    $ledger_bal = trim($worksheet[$i]["E"]);
                }
                if (trim($worksheet[$i]["F"] == "")) {
                    $credit = "0.00";
                } else {
                    $credit = trim($worksheet[$i]["F"]);
                }
                if (trim($worksheet[$i]["G"] == "")) {
                    $debit = "0.00";
                } else {
                    $debit = trim($worksheet[$i]["G"]);
                }
                $cr_dt = trim($worksheet[$i]["H"]); // cr_dt
                //$ref_no = trim($worksheet[$i]["H"]); // ref_no
                $transaction_br = trim($worksheet[$i]["J"]); // ref_no

                if (trim($worksheet[$i]["I"] == "")) {
                    $ref_no = "";
                } else {
                    $ref_no = trim($worksheet[$i]["I"]);
                }

                $data = array(
                    'colBank' => $colBank,
                    "accountNo" => $accountnumber, // pkup_pt
                    "depositDt" => $deposit_dt, // deposit_dt
                    "bookDt" => $book_dt, // book_dt
                    "description" => $description, // description
                    "ledger_bal" => $ledger_bal, // ledger_bal
                    "credit" => $credit, // cr_dt
                    "debit" => $debit, // dept_slip
                    "crDt" => $cr_dt, // cr_dt
                    "refNo" => $ref_no, // ref_no
                    "transactionBr" => $transaction_br, // transactionBr
                    "isActive" => 1, // no_of_inst
                    "createdBy" => Auth::id()
                );
                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '') {

                    DB::table('MFL_Inward_BankStatement_HDFC')->insert($data);
                }

            }

            return response()->json(['message' => 'Success'], 200);

        } catch (CustomModelNotFoundException $exception) {
            return $exception->render($exception);
        }
    }

    //bankStatementHDFCUpload Ends

    public function bankStatementICICIUpload(Request $request) {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        try {

            $file = $request->file('file');
            $destinationPath = storage_path('app/public/commercial/BankStatement/ICICI');
            $file_1_name = Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/commercial/BankStatement/ICICI/') . $file_1_name;

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            ;
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

            $error_msgs_arr = array();

            for ($i = 2; $i <= $arrayCount; $i++) {

                $colBank = config('constants.ICICI.BankStatementName'); // bankName
                $accountnumber_spilit = explode("Ac No:", trim($worksheet[$i]["A"]));
                if (count($accountnumber_spilit) > 1) {
                    $accountnumber = $accountnumber_spilit[1];
                } else {
                    $accountnumber = trim($worksheet[$i]["A"]);
                }
                $bookDt = trim($worksheet[$i]["B"]); // Tran Date
                $description = trim($worksheet[$i]["C"]); // Tran Particular
                if (trim($worksheet[$i]["I"] == "")) {
                    $credit = "0.00";
                } else {
                    $credit = trim($worksheet[$i]["I"]);
                }
                if (trim($worksheet[$i]["H"] == "")) {
                    $debit = "0.00";
                } else {
                    $debit = trim($worksheet[$i]["H"]);
                }
                $transaction_br = trim($worksheet[$i]["K"]); // Deposit Branch
                $refNo = trim($worksheet[$i]["D"]); // Tran Remarks
                if (trim($worksheet[$i]["E"] == "")) {
                    $instNum = "0.00";
                } else {
                    $instNum = trim($worksheet[$i]["E"]);
                }
                $currency_code = trim($worksheet[$i]["G"]); // Currency Code
                if (trim($worksheet[$i]["J"] == "")) {
                    $ledger_bal = "0.00";
                } else {
                    $ledger_bal = trim($worksheet[$i]["J"]);
                }

                if (trim($worksheet[$i]["F"] == "")) {
                    $origSolID = "0";
                } else {
                    $origSolID = trim($worksheet[$i]["F"]);
                }

                $data = array(
                    'colBank' => $colBank,
                    "accountNo" => $accountnumber, // pkup_pt
                    "bookDt" => $bookDt, // bookDt
                    "description" => $description, // Tran Particular
                    "credit" => $credit, // Cr Tran Amt
                    "debit" => $debit, // Dr Tran Amt
                    "ledger_bal" => $ledger_bal, // Bal Amt
                    "refNo" => $refNo, // Tran Remarks
                    "transactionBr" => $transaction_br, // Deposit Branch
                    "instNum" => $instNum, // Inst Num
                    "origSolID" => $origSolID, // transactionBr
                    "currencyCode" => $currency_code, // currency Code
                    "isActive" => 1, //
                    "createdBy" => Auth::id()
                );
                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '') {

                    DB::table('MFL_Inward_BankStatement_ICICI')->insert($data);
                }
            }

            return response()->json(['message' => 'Success'], 200);

        } catch (CustomModelNotFoundException $exception) {
            return $exception->render($exception);
        }

    }

    //bankStatementICICIUpload Ends


    // bankStatementAxisUpload

    public function bankStatementAxisUpload(Request $request) {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        try {

            $file = $request->file('file');
            $destinationPath = storage_path('app/public/commercial/BankStatement/AXIS');
            $file_1_name = Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/commercial/BankStatement/AXIS/') . $file_1_name;

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            ;
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

            $error_msgs_arr = array();

            for ($i = 2; $i <= $arrayCount; $i++) {

                $colBank = config('constants.AXIS.BankStatementName'); // bankName
                $accountnumber = trim($worksheet[$i]["A"]); // AccountNumber
                $bookDt = Carbon::parse(strtotime(trim($worksheet[$i]["B"])));
                $bookDt_convert = $bookDt->format('Y-m-d');
                $description = trim($worksheet[$i]["D"]); // Particulars
                if (trim($worksheet[$i]["F"] == "") || empty(trim($worksheet[$i]["F"]))) {
                    $credit = "0.00";
                } else {
                    $credit = trim($worksheet[$i]["F"]);
                } //Credit
                if (trim($worksheet[$i]["E"] == "") || empty(trim($worksheet[$i]["E"]))) {
                    $debit = "0.00";
                } else {
                    $debit = trim($worksheet[$i]["E"]);
                } // Debit
                if (trim($worksheet[$i]["G"] == "") || empty(trim($worksheet[$i]["G"]))) {
                    $ledger_bal = "0.00";
                } else {
                    $ledger_bal = trim($worksheet[$i]["G"]);
                } //Balance
                $branchCode = trim($worksheet[$i]["H"]); // Init.
                $chequeNo = trim($worksheet[$i]["C"]); // Cheque No

                $data = array(
                    'colBank' => $colBank,
                    "accountNo" => $accountnumber, // AccountNumber
                    "bookDt" => $bookDt_convert, // Transaction Date
                    "description" => $description, // description
                    "credit" => $credit, // Credit
                    "debit" => $debit, // Debit
                    "ledger_bal" => $ledger_bal, // Running Balance
                    "chequeNo" => $chequeNo, // chqNo
                    "branchCode" => $branchCode, // branchCode
                    "isActive" => 1, //
                    "createdBy" => Auth::id()
                );
                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '') {

                    DB::table('MFL_Inward_BankStatement_Axis')->insert($data);
                }
            }

            return response()->json(['message' => 'Success'], 200);

        } catch (CustomModelNotFoundException $exception) {
            return $exception->render($exception);
        }

    }

    // bankStatementAxisUpload Ends


    // IDFC bankStatementIDFCUpload



    public function bankStatementIDFCUpload(Request $request) {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        try {

            $file = $request->file('file');
            $destinationPath = storage_path('app/public/commercial/BankStatement/IDFC');
            $file_1_name = Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/commercial/BankStatement/IDFC/') . $file_1_name;

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            ;
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

            $error_msgs_arr = array();

            for ($i = 2; $i <= $arrayCount; $i++) {

                $colBank = config('constants.IDFC.BankStatementName'); // bankName
                $accountnumber = trim($worksheet[$i]["A"]); // AccountNumber
                //$bookDt = trim($worksheet[$i]["B"]); // Transaction Date
                $bookDt = Carbon::parse(strtotime(trim($worksheet[$i]["B"])));
                $bookDt_convert = $bookDt->format('Y-m-d');
                $description = trim($worksheet[$i]["D"]); // Narrative
                if (trim($worksheet[$i]["H"] == "")) {
                    $credit = "0.00";
                } else {
                    $credit = trim($worksheet[$i]["H"]);
                } //Credit
                if (trim($worksheet[$i]["G"] == "")) {
                    $debit = "0.00";
                } else {
                    $debit = trim($worksheet[$i]["G"]);
                } // Debit
                if (trim($worksheet[$i]["I"] == "")) {
                    $ledger_bal = "0.00";
                } else {
                    $ledger_bal = trim($worksheet[$i]["I"]);
                } //Running Balance
                $cr_dt = trim($worksheet[$i]["C"]); // Payment date
                $reference_no = trim($worksheet[$i]["E"]); // Customer Reference No
                $chequeNo = trim($worksheet[$i]["F"]); // Cheque No

                $data = array(
                    'colBank' => $colBank,
                    "accountNo" => $accountnumber, // AccountNumber
                    "bookDt" => $bookDt_convert, // Transaction Date
                    "description" => $description, // description
                    "credit" => $credit, // Credit
                    "debit" => $debit, // Debit
                    "ledger_bal" => $ledger_bal, // Running Balance
                    "crDt" => $cr_dt, // Payment date
                    "refNo" => $reference_no, // Customer Reference No
                    "chequeNo" => $chequeNo, // chqNo
                    "isActive" => 1, //
                    "createdBy" => Auth::id()
                );
                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '') {

                    DB::table('MFL_Inward_BankStatement_IDFC')->insert($data);
                }



            }

            return response()->json(['message' => 'Success'], 200);

        } catch (CustomModelNotFoundException $exception) {
            return $exception->render($exception);
        }
    }




    // IDFC bankStatementSBIUpload



    public function bankStatementSBIUpload(Request $request) {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        try {

            $file = $request->file('file');
            $destinationPath = storage_path('app/public/commercial/BankStatement/SBI');
            $file_1_name = Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/commercial/BankStatement/SBI/') . $file_1_name;

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            ;
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

            $error_msgs_arr = array();

            for ($i = 2; $i <= $arrayCount; $i++) {

                $colBank = config('constants.SBI.BankStatementName'); // bankName
                $accountnumber = trim($worksheet[$i]["A"]); // AccountNumber
                $bookDt = trim($worksheet[$i]["B"]); // Value Date
                $description = trim($worksheet[$i]["C"]); // Description
                $chequeNo = trim($worksheet[$i]["D"]); // Cheque No
                if (trim($worksheet[$i]["G"] == "") || empty(trim($worksheet[$i]["G"]))) {
                    $credit = "0.00";
                } else {
                    $credit = trim($worksheet[$i]["G"]);
                } //Credit
                if (trim($worksheet[$i]["F"] == "") || empty(trim($worksheet[$i]["F"]))) {
                    $debit = "0.00";
                } else {
                    $debit = trim($worksheet[$i]["F"]);
                } // Debit
                if (trim($worksheet[$i]["H"] == "")) {
                    $ledger_bal = "0.00";
                } else {
                    $ledger_bal = trim($worksheet[$i]["H"]);
                } //Balance
                $branchCode = trim($worksheet[$i]["E"]); // Brach Code

                $data = array(
                    'colBank' => $colBank,
                    "accountNo" => $accountnumber, // AccountNumber
                    "bookDt" => $bookDt, // Transaction Date
                    "description" => $description, // description
                    "credit" => $credit, // Credit
                    "debit" => $debit, // Debit
                    "ledger_bal" => $ledger_bal, // Balance
                    "branchCode" => $branchCode, // branchCode
                    "chequeNo" => $chequeNo, // chqNo
                    "isActive" => 1, //
                    "createdBy" => Auth::id()
                );

                //dd(trim($worksheet[$i]["F"]));

                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '') {

                    DB::table('MFL_Inward_BankStatement_SBI')->insert($data);
                }
            }
            return response()->json(['message' => 'Success'], 200);

        } catch (CustomModelNotFoundException $exception) {
            return $exception->render($exception);
        }
    }


    // bankStatementSBIUpload Ends
}