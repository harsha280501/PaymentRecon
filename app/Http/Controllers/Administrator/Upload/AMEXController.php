<?php

namespace App\Http\Controllers\Administrator\Upload;

use App\Http\Controllers\Controller;

// Request

use Illuminate\Http\Request;


// Response

use Illuminate\Http\RedirectResponse;

// Model

use App\Models\MRepository;
use App\Models\MFLInwardCardMISHdfcPos;
use App\Models\MFLInwardUPIMISHdfcPos;
use App\Models\MFLInwardCardMISAmexPos;
use App\Models\MAmexMID;


// Exception

use Exception;

// Services

use App\Services\GeneralService;
use App\Services\ParseDateService;
use App\Services\ExcelUploadGeneralService;

// Others

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Log;
use Illuminate\Support\Facades\Config;



class AMEXController extends Controller {

    public function AmexData(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        try {

            $file = $request->file('file');

            // Load the Excel file using PhpSpreadsheet

            $destinationPath = storage_path('app/public/admin/amexdata');
            $getorinilfilename = $file->getClientOriginalName();
            $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/admin/amexdata/') . $file_1_name;
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

            $error_msgs_arr = array();



            for ($i = 11; $i <= $arrayCount; $i++) {


                $col_bank = config('constants.AMEX.cardBankName'); // bankName

                $input_file_name = $request->file('file')->getClientOriginalName();
                $fileName = pathinfo($input_file_name, PATHINFO_FILENAME);
                $namearr = explode("_", $fileName);
                if (count($namearr) > 1) {
                    $acct_no = $namearr[0];
                }
                if (count($namearr) == 1) {
                    $namearr = explode("_", $fileName);
                    $acct_no = $namearr[0];
                }


                $tid = trim(str_replace("'", '', $worksheet[$i]["N"])); // Terminal ID
                $mid = trim(str_replace("'", '', $worksheet[$i]["C"])); // Submitting merchant number

                $retekCode = ExcelUploadGeneralService::getReteckCodeUsingTIDForAMEX($mid);
                $storeID = ExcelUploadGeneralService::getStoreUDUsingRetekForAMEX($retekCode);


                $deposit_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["A"])), 'Amex Card'); // DEPOSIT DATE
                $cr_dt = ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["B"])), 'Amex Card'); // DEPOSIT DATE

                //$deposit_amount = trim($worksheet[$i]["D"]); // Charge amount

                $deposit_amount_receive = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["D"])));
                $deposit_spilit = explode(" ", $deposit_amount_receive);
                //dd(count($deposit_spilit));
                if (count($deposit_spilit) > 1) {
                    $currency = $deposit_spilit[0];
                    $deposit_amount = $deposit_spilit[1];
                } else {
                    $currency = "NULL";
                    $deposit_amount = $deposit_amount_receive;
                }

                $settl_amount_receive = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', trim($worksheet[$i]["E"])));
                $settl_spilit = explode(" ", $settl_amount_receive);
                if (count($settl_spilit) > 1) {
                    $currency = $settl_spilit[0];
                    $settl_amount = $settl_spilit[1];
                } else {
                    $currency = "NULL";
                    $settl_amount = $settl_amount_receive;
                }


                $Gl_txn = trim(str_replace("'", '', $worksheet[$i]["H"])); // Charge reference number
                $card_number = trim(str_replace("'", '', $worksheet[$i]["G"])); // Card member number
                $transaction_type = trim(str_replace("'", '', $worksheet[$i]["M"])); // Type
                $approv_code = trim(str_replace("'", '', $worksheet[$i]["L"])); // Approval code
                $arn_no = trim(str_replace("'", '', $worksheet[$i]["O"])); // Acquirer Reference Number
                $mid_city = trim(str_replace("'", '', $worksheet[$i]["F"])); // Submitting location ID

                $userId = Auth::id();

                $data = array(
                    "storeID" => $storeID,
                    "retekCode" => $retekCode,
                    "colBank" => $col_bank,
                    "acctNo" => $acct_no,
                    "tid" => $tid,
                    "mid" => $mid,
                    "depositDt" => $deposit_dt,
                    "crDt" => $cr_dt,
                    "depositAmount" => $deposit_amount,
                    "currency" => $currency,
                    "GlTxn" => $Gl_txn,
                    "cardNumber" => $card_number,
                    "transactionType" => $transaction_type,
                    "approvCode" => $approv_code,
                    "settlAmount" => $settl_amount,
                    "arnNo" => $arn_no,
                    "midCity" => $mid_city,
                    "filename" => $file_1_name,
                    "createdBy" => $userId
                );

                $attributes = [

                    "storeID" => $storeID,
                    "retekCode" => $retekCode,
                    "colBank" => $col_bank,
                    "acctNo" => $acct_no,
                    "tid" => $tid,
                    "mid" => $mid,
                    "depositDt" => $deposit_dt,
                    "crDt" => $cr_dt,
                    "depositAmount" => $deposit_amount,
                    "currency" => $currency,
                    "GlTxn" => $Gl_txn,
                    "cardNumber" => $card_number,
                    "transactionType" => $transaction_type,
                    "approvCode" => $approv_code,
                    "settlAmount" => $settl_amount,
                    "arnNo" => $arn_no,
                    "midCity" => $mid_city,
                    "createdBy" => $userId

                ];
                if ($deposit_dt != '' && $cr_dt != '') {

                    MFLInwardCardMISAmexPos::updateOrInsert($attributes, $data);

                }

            }


            return response()->json(['message' => 'Success'], 200);

        } catch (\Throwable $exception) {
            dd($exception);
            throw new Exception('Something went wrong');
        }
    }




}
