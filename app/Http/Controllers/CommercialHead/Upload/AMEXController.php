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


    public function __construct(
        public MisReadLogsInterface $repository
    ) {
    }


    public function AmexData(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        $file = $request->file('file');

        // Load the Excel file using PhpSpreadsheet
        $destinationPath = storage_path('app/public/commercial/amexdata');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/amexdata/') . $file_1_name;

        // checking if the filename is in the db
        if (MFLInwardCardMISAmexPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
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
        $this->repository->startFrom(11);


        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_Inward_CardMIS_AmexPos",
            "bank" => "Amex Card",
            "dataset" => $worksheet
        ]);


        // creating initialized Log Records
        $this->repository->initializeLog();

        try {
            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {
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
                // dd(ParseDateService::convertDateFormatUsingDB(trim(str_replace("'", '', $worksheet[$i]["A"])), 'Amex Card'));
                // Deposit Date
                $cr_dt = preg_replace('/[_\/\.\s]+/', '-', $worksheet[$i]["B"]);
                $cr_dt = strtotime($cr_dt);
                $cr_dt = date('Y-m-d', $cr_dt);
                

                $deposit_dt = preg_replace('/[_\/\.\s]+/', '-', $worksheet[$i]["A"]);
                $deposit_dt = $deposit_dt ?? strtotime($deposit_dt);
                $deposit_dt = $deposit_dt ?? date('Y-m-d', $deposit_dt);
                // dd($deposit_dt);

                if (!$deposit_dt) { # deposit isnull # check if the deposit date is null
                    $deposit_dt = Carbon::parse($cr_dt)->subDays(value: 1)->format('Y-m-d'); # dateadd(day, -1, getdate())
                    // dd($deposit_dt);
                }

                $storedata = ExcelUploadGeneralService::getReteckCodeUsingTIDForAMEX($tid, Carbon::parse(trim(str_replace("'", '', $deposit_dt))));

                $retekCode = $storedata['retekCode'];
                $storeID = $storedata['storeID'];
                $brand = $storedata['brand'];

                // credit Date
           



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

                // assigning missing status from config constants file
                $missingStatus = config('constants.missingStatus.StoreID');

                // getting the Not considered brands
                $NotconsiderArrayBrand = BrandNotConsider::select('brand')->where('isActive', '=', 1)->pluck('brand')->toArray();
				//dd($NotconsiderArrayBrand);                

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
                    "createdBy" => $userId,
                    "missingRemarks" => $missingStatus,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')   
                    
                );

                // $attributes = [
                //     "storeID" => $storeID,
                //     "retekCode" => $retekCode,
                //     "colBank" => $col_bank,
                //     "brand" => $brand,
                //     // "acctNo" => $acct_no,
                //     "tid" => $tid,
                //     "mid" => $mid,
                //     "depositDt" => $deposit_dt,
                //     "crDt" => $cr_dt,
                //     "depositAmount" => $deposit_amount,
                //     "cardNumber" =>$card_number,
                //     "GlTxn" =>$Gl_txn
                   
                // ];
                if ($deposit_dt != '' && $cr_dt != '') {
                    if (MFLInwardCardMISAmexPos::Insert($data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }

            }

            // finializing the logs
            $this->repository->finializeLog();
            return response()->json(['message' => 'Success'], 200);

        } catch (\Throwable $exception) {
            $this->repository->failedLog($exception);
            throw new Exception($exception->getMessage());
        }
    }
}
