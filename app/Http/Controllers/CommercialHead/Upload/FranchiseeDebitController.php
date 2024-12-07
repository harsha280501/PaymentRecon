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
use App\Models\MFranchiseeDebit;
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



class FranchiseeDebitController extends Controller {


    public function __construct(
        public MisReadLogsInterface $repository
    ) {
    }


    public function debits(Request $request) {


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
        if (MFranchiseeDebit::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
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
            "table" => "mFranchiseDebit",
            "bank" => "Franchesee Debit",
            "dataset" => $worksheet
        ]);


        // creating initialized Log Records
        $this->repository->initializeLog();


        
        
        try {
            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {
                
                $data = [
                    'storeID' => $worksheet[$i]["B"],
                    'brand' => $worksheet[$i]["C"],
                    'colBank' => $worksheet[$i]["D"],
                    'salesPeriod' => $this->format($worksheet[$i]["E"]),
                    'dateOfDebit' => $this->format($worksheet[$i]["F"]),
                    'docNo' => $worksheet[$i]["G"],
                    'debit' => $worksheet[$i]["H"],
                    "filename" => $file_1_name,
                    "createdBy" => auth()->user()->userUID,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                ];

                $attributes = [
                    'storeID' => $worksheet[$i]["B"],
                    'brand' => $worksheet[$i]["C"],
                    'colBank' => $worksheet[$i]["D"],
                    'salesPeriod' => $this->format($worksheet[$i]["E"]),
                    'dateOfDebit' => $this->format($worksheet[$i]["F"]),
                    'docNo' => $worksheet[$i]["G"],
                    'debit' => $worksheet[$i]["H"],
                    "filename" => $file_1_name,
                ];

                if (MFranchiseeDebit::updateOrInsert($attributes, $data)) {
                    $this->repository->increamentInsertedCount();
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





    
    public function format(string|null $date) {

        if(!$date) {
            return null;
        }

        $_string = preg_replace('/[^\w]/', '-', $date);

        try {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($_string)->format('Y-m-d');
            } catch (\Throwable $th) {
                return Carbon::parse($_string)->format('Y-m-d');
            }
        } catch (\Throwable $th) {
            return Carbon::createFromFormat('m-d-Y', $_string)->format('Y-m-d');
        }
    }


}
