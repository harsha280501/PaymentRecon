<?php

namespace App\Http\Controllers\CommercialHead\BankStatementUpload;

use App\Http\Controllers\Controller;

// Request

use App\Interface\BankStatementReadLogsInterface;
use App\Models\Logs\UploadLog;
use Illuminate\Http\Request;

// Response

use Illuminate\Http\RedirectResponse;

//Models
use App\Models\MFLInwardBankStatementHDFC;

// Others
use App\Services\GeneralService;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Services\Upload\ExcelBankStatement;




class HDFCController extends Controller {


    public function __construct(
        public BankStatementReadLogsInterface $repository
    ) {
    }

    public function bankStatementHDFCUpload(Request $request) {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);



        $file = $request->file('file');
        $destinationPath = storage_path('app/public/commercial/BankStatement/HDFC');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/BankStatement/HDFC/') . $file_1_name;

        // checking if the filename is in the db
        if (MFLInwardBankStatementHDFC::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
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
            "table" => "MFL_Inward_BankStatement_HDFC",
            "bank" => "HDFC BankStatement",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();


        try {

            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $colBank = config('constants.HDFC.BankStatementName'); // bankName
                $accountnumber = trim($worksheet[$i]["A"]);
                // AccountNumber

                $deposit_dt = ExcelBankStatement::convertDateForForBankSt(trim($worksheet[$i]["B"]), 'HDFC Bank Statement'); // deposit_dt
                $creditDate = ExcelBankStatement::convertDateForForBankSt(trim($worksheet[$i]["C"]), 'HDFC Bank Statement'); // creditDate
                $description = trim($worksheet[$i]["D"]); // description
                $remaksReferenceNo = trim($worksheet[$i]["E"]); // Remarks /Reference
                $debit = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["F"])); //Debit
                $credit = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', $worksheet[$i]["G"])); //Credit
                $transaction_br = trim($worksheet[$i]["H"]); // Txn Branch / Code               


                $data = array(
                    "colBank" => $colBank,
                    "accountNo" => $accountnumber, // accountNo
                    "depositDate" => $deposit_dt, // deposit_dt 
                    "creditDate" => $creditDate, // creditDate
                    "description" => $description, // description
                    "remaksReferenceNo" => $remaksReferenceNo, // remaksReferenceNo                     
                    "debit" => $debit, // debit
                    "credit" => $credit, // credit
                    "transactionBr" => $transaction_br, // transactionBr                      
                    "filename" => $file_1_name,
                    "createdBy" => Auth::id(),
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );

                $attributes = [

                    "colBank" => $colBank,
                    "accountNo" => $accountnumber, // accountNo
                    "depositDate" => $deposit_dt, // deposit_dt 
                    "creditDate" => $creditDate, // creditDate
                    "description" => $description, // description
                    "remaksReferenceNo" => $remaksReferenceNo, // remaksReferenceNo                     
                    "debit" => $debit, // debit
                    "credit" => $credit, // credit
                    "transactionBr" => $transaction_br, // transactionBr 
                    "createdBy" => Auth::id()

                ];
                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '') {
                    if (MFLInwardBankStatementHDFC::updateOrInsert($attributes, $data)) {
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
     * Get the file extensions
     * @param string $filename
     * @return string
     */
    public function getFileType(string $filename): string {
        return isset(explode('.', $filename)[1]) ? explode('.', $filename)[1] : null;
    }




}
