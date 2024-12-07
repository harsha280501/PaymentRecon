<?php

namespace App\Http\Controllers\CommercialHead\BankStatementUpload;

use App\Http\Controllers\Controller;
use App\Interface\BankStatementReadLogsInterface;
use App\Models\Logs\UploadLog;
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
use App\Models\MFLInwardBankStatementSBI;
use App\Services\Upload\ExcelBankStatement;



class SBIController extends Controller {

    public function __construct(
        public BankStatementReadLogsInterface $repository
    ) {
    }

    public function bankStatementSBIUpload(Request $request) {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        $file = $request->file('file');
        $destinationPath = storage_path('app/public/commercial/BankStatement/SBI');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/BankStatement/SBI/') . $file_1_name;


        // checking if the filename is in the db
        if (MFLInwardBankStatementSBI::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
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
            "table" => "MFL_Inward_BankStatement_SBI",
            "bank" => "SBI BankStatement",
            "dataset" => $worksheet
        ]);


        // creating initialized Log Records
        $this->repository->initializeLog();

        try {

            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $colBank = config('constants.SBI.BankStatementName'); // bankName
                $accountnumber = trim(str_replace("'", '', $worksheet[$i]["A"])); // AccountNumber 

                $deposit_dt = ExcelBankStatement::convertDateForForBankSt(trim(str_replace("'", '', $worksheet[$i]["B"])), 'SBI Bank Statement'); // bookDt 
                $creditDate = ExcelBankStatement::convertDateForForBankSt(trim(str_replace("'", '', $worksheet[$i]["C"])), 'SBI Bank Statement'); // creditDate  
                $description = trim(str_replace("'", '', $worksheet[$i]["D"])); // Description
                $reference_no = trim(str_replace("'", '', $worksheet[$i]["E"])); // Remarks /Reference
                $debit = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', trim($worksheet[$i]["F"]))); //Debit
                $credit = ExcelBankStatement::convertPriceFormatNumeric(str_replace(',', '', trim($worksheet[$i]["G"]))); //Credit
                $branchCode = trim(str_replace("'", '', $worksheet[$i]["H"])); // Brach Code

                $data = array(
                    "colBank" => $colBank,
                    "accountNo" => $accountnumber, // AccountNumber
                    "depositDate" => $deposit_dt, // Transaction Date
                    "creditDate" => $creditDate, // creditDate
                    "description" => $description, // description
                    "remaksReferenceNo" => $reference_no, // reference_no
                    "debit" => $debit, // Debit
                    "credit" => $credit, // Credit   
                    "transactionBr" => $branchCode, // branchCode
                    "filename" => $file_1_name,
                    "createdBy" => Auth::id(),
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                );

                $attributes = [
                    "colBank" => $colBank,
                    "accountNo" => $accountnumber, // AccountNumber
                    "depositDate" => $deposit_dt, // Transaction Date
                    "creditDate" => $creditDate, // creditDate
                    "description" => $description, // description
                    "remaksReferenceNo" => $reference_no, // reference_no
                    "debit" => $debit, // Debit
                    "credit" => $credit, // Credit   
                    "transactionBr" => $branchCode, // branchCode                                          
                    "createdBy" => Auth::id()
                ];

                if (trim($worksheet[$i]["A"]) != '' && trim($worksheet[$i]["B"]) != '') {
                    if (MFLInwardBankStatementSBI::updateOrInsert($attributes, $data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }
            }

            // finializing the logs
            $this->repository->finializeLog();
            return response()->json(['message' => 'Success'], 200);

        } catch (\Throwable $exception) {

            // updating the log to write the error
            $this->repository->failedLog($exception);
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
