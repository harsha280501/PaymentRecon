<?php

namespace App\Http\Controllers\CommercialHead\Upload;

use App\Http\Controllers\Controller;
use App\Interface\MisReadLogsInterface;
use Illuminate\Http\Request;
use App\Models\MFLInwardCashMIS2SBIPos;
use App\Services\ParseDateService;
use App\Traits\GenerateTotalHTML;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SBI94429Controller extends Controller {

    use GenerateTotalHTML;

    public function __construct(public MisReadLogsInterface $repository) {

    }

    /**
     * SBI Uploads
     * @return \Illuminate\Http\JsonResponse
     */
    public function importSBICashData(Request $request) {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:25048'
        ]);

        $file = $request->file('file');
        $destinationPath = storage_path('app/public/commercial/SbiCashNew');
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/SbiCashNew/') . $file_1_name;


        if (MFLInwardCashMIS2SBIPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
            return response()->json(['message' => 'The Filename already exists on the Database'], 409);

        }



        $inputFileTypeIdentify = \PhpOffice\PhpSpreadsheet\IOFactory::identify($targetPath);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileTypeIdentify);
        $reader->setReadDataOnly(true);

        $spreadsheet = $reader->load($targetPath);
        $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $arrayCount = count($worksheet);

        // setting the inserted count to zero
        $this->repository->startFrom(2);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_inward_CashMIS2_SBIPos",
            "bank" => "SBICASHMIS2",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {

            for ($i = $this->repository->startFrom; $i <= $arrayCount; $i++) {

                $deposit_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["B"]), 'SBI Cash MIS'); // Input Date
                // dd($deposit_dt);
                $chequeDate = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["A"]), 'SBI Cash MIS'); // Cheque Date
                $retekCode = trim($worksheet[$i]["C"]); // Retek Code
                $storeID = trim($worksheet[$i]["D"]); // Store ID
                $deposit = trim(str_replace(',', '', $worksheet[$i]["E"])); // Deposit
                $reference = trim($worksheet[$i]["F"]); // Reference
                $creditAccountNumber = trim($worksheet[$i]["G"]); // Credit Account Number
                // $collectionBank = trim($worksheet[$i]["H"]); // Collection Bank
                // $brand = $storedata['Brand Desc'];
                $userId = Auth::id();

                // Data to insert
                $data = [
                    "chequeDate" => $chequeDate,
                    "depositDt" => $deposit_dt,
                    "retekCode" => $retekCode,
                    "storeID" => $storeID,
                    "depositAmount" => $deposit,
                    // "brand" => $brand,
                    "uniqueReferenceNumber" => $reference,
                    "creditAccountNumber" => $creditAccountNumber,
                    "colBank" => 'SBICASHMIS',
                    "filename" => $file_1_name,
                    "createdBy" => $userId,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')
                ];

                // if (!empty($valueDate) && !empty($storeID)) {
                MFLInwardCashMIS2SBIPos::insert($data);
                $this->repository->increamentInsertedCount();
                // }
            }

            // finializing the logs
            $this->repository->finializeLog();
            return response()->json([
                'message' => 'Success',
                "data" => $this->generateHTML(function () use ($getorinilfilename) {
                    return MFLInwardCashMIS2SBIPos::select(
                        'depositAmount',
                        'missingRemarks',
                        DB::raw('ISNULL(depositDt, NULL) as depositDt'),
                        DB::raw('ISNULL(chequeDate, NULL) as crDt')
                    )->where('filename', 'like', '%' . $getorinilfilename . '%')->get();
                })
            ], 200);

        } catch (\Throwable $exception) {
            $this->repository->failedLog($exception);
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

}
