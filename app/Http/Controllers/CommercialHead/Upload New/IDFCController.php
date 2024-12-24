<?php

namespace App\Http\Controllers\CommercialHead\Upload;

use App\Http\Controllers\Controller;

use App\Interface\MisReadLogsInterface;
use App\Models\BrandNotConsider;
use App\Models\Logs\UploadLog;
use App\Services\ParseDateService;
use App\Services\ExcelUploadGeneralService;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;


use App\Models\MFLInwardCashMISIdfcPos;
use App\Traits\GenerateTotalHTML;
use Illuminate\Support\Facades\DB;

class IDFCController extends Controller {

    use GenerateTotalHTML;


    public function __construct(
        public MisReadLogsInterface $repository
    ) {
    }



    /**
     * Summary of IDFCUpload
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return \Illuminate\Http\JsonResponse
     */

    public function IDFCUpload(Request $request) {

        // Validating the given file extension
        $request->validate([
            'file' => 'mimes:xlsx,xls'
        ]);


        // Retrieve the uploaded file
        $file = $request->file('file');

        // Move the uploaded filee to a temporary location
        $destinationPath = storage_path('app/public/commertial/idfcdata');
        //$file_1_name = time() . '.' . $file->getClientOriginalExtension();
        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();


        // checking if the filename is in the db
        if (MFLInwardCashMISIdfcPos::where('filename', 'like', '%' . $getorinilfilename . '%')->exists()) {
            return response()->json(['message' => 'The Filename already exists on the Database'], 409);
        }



        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commertial/idfcdata/') . $file_1_name;




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
        $arrayCount = count($worksheet);

        $startOfLine = $this->getFirstLine(collect($worksheet));

        // setting the inserted count to zero
        $this->repository->startFrom(intval($startOfLine) + 1);

        // configuring the datasets
        $this->repository->configure([
            "filename" => $file_1_name,
            "table" => "MFL_Inward_CashMIS_IdfcPos",
            "bank" => "IDFC Cash",
            "dataset" => $worksheet
        ]);

        // creating initialized Log Records
        $this->repository->initializeLog();

        try {

            for ($i = intval($startOfLine) + 1; $i <= $arrayCount; $i++) {



                $col_bank = config('constants.IDFC.cardBankName'); // bankName   
                $pkup_pt_code = trim($worksheet[$i]["D"]); //PICKUP POINT CODE

                $storedata = ExcelUploadGeneralService::getReteckStoreIDForAllCashUpload($pkup_pt_code);
                $retekCode = $storedata['RETEK Code'];
                $storeID = $storedata['Store ID'];
                $brand = $storedata['Brand Desc'];


                $tranType = trim($worksheet[$i]["L"]); // TRANSACTION TYPE
                $drCr = trim($worksheet[$i]["O"]); // CREDIT_DEBIT
                $custCode = trim($worksheet[$i]["A"]); // CUSTOMER CODE
                $prdCode = trim($worksheet[$i]["B"]); // PRODUCT CODE
                $locationName = trim($worksheet[$i]["C"]); // PICK UP LOCATION

                $deposit_dt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["G"]), 'IDFC Cash MIS'); // DEPOSIT DATE
                $adjDt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["P"]), 'IDFC Cash MIS'); // ADJUSTMENT DATE
                $crDt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["K"]), 'IDFC Cash MIS'); // ARRANGEMENT CREDIT DATE

                $depSlipNo = trim($worksheet[$i]["E"]); // PICK UP LOCATION
                $depositAmount = trim(str_replace(',', '', $worksheet[$i]["F"])); // DEPOSIT SLIP AMOUNT
                $returnReason = trim($worksheet[$i]["E"]); // PICK UP LOCATION
                $hirCode = trim($worksheet[$i]["Y"]); // PICK UP LOCATION
                $divisionCode = trim($worksheet[$i]["X"]); // PICK UP LOCATION

                $recDt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["Q"]), 'IDFC Cash MIS'); // recDt DATE
                $rtnDt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["S"]), 'IDFC Cash MIS'); // DEPOSIT DATE
                $revDt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["AL"]), 'IDFC Cash MIS'); // DEPOSIT DATE
                $realisationDt = ParseDateService::convertDateFormatUsingDB(trim($worksheet[$i]["R"]), 'IDFC Cash MIS'); // DEPOSIT DATE

                $subCustomerCode = trim($worksheet[$i]["Z"]); // PICK UP LOCATION
                $dS_Addl_InfoCode1 = trim($worksheet[$i]["AA"]); // PICK UP LOCATION
                $dS_Addl_InfoCode2 = trim($worksheet[$i]["AB"]); // PICK UP LOCATION
                $dS_Addl_InfoCode3 = trim($worksheet[$i]["AC"]); // PICK UP LOCATION

                $instNo = trim($worksheet[$i]["H"]); // PICK UP LOCATION
                $instAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["J"]));

                //trim(str_replace(',', '',$worksheet[$i]["J"])); // INSTRUMENT AMOUNT
                $instAmtBreakup = trim($worksheet[$i]["AM"]); // PICK UP LOCATION


                $adjAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["J"]));
                $recoveredAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["AI"])); //RECOVERED AMOUNT
                $reversalAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["AK"])); //REVERSAL AMOUNT
                $returnAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["AJ"])); //RETURN RECOVERY AMOUNT

                $drnBk = trim($worksheet[$i]["I"]); // drnBk
                $instAmtBreakup = trim($worksheet[$i]["AM"]); // PICK UP LOCATION

                $insAddl_InfoCode1 = trim($worksheet[$i]["AD"]); // PICK UP LOCATION
                $insAddl_InfoCode2 = trim($worksheet[$i]["AE"]); // PICK UP LOCATION
                $insAddl_InfoCode3 = trim($worksheet[$i]["AF"]); // PICK UP LOCATION
                $insAddl_InfoCode4 = trim($worksheet[$i]["AG"]); // PICK UP LOCATION
                $insAddl_InfoCode5 = trim($worksheet[$i]["AH"]); // PICK UP LOCATION

                $pooledDeptAmt = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["M"])); // POOLED AMOUNT
                $pooledAcNo = trim($worksheet[$i]["AN"]); // PICK UP LOCATION
                $remarks1 = trim($worksheet[$i]["U"]); // PICK UP LOCATION
                $remarks2 = trim($worksheet[$i]["V"]); // PICK UP LOCATION
                $remarks3 = trim($worksheet[$i]["W"]); // PICK UP LOCATION

                $userId = Auth::id();

                // assigning missing status from config constants file
                $missingStatus = config('constants.missingStatus.StoreID');

                // getting the Not considered brands
                $NotconsiderArrayBrand = BrandNotConsider::select('brand')->where('isActive', '=', 1)->pluck('brand')->toArray();


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
                    'pkupPtCode' => $pkup_pt_code,
                    'tranType' => $tranType,
                    'drCr' => $drCr,
                    'custCode' => $custCode,
                    'prdCode' => $prdCode,
                    'locationName' => $locationName,
                    'depositDt' => $deposit_dt,
                    'adjDt' => $adjDt,
                    'crDt' => $crDt,
                    'depSlipNo' => $depSlipNo,
                    'depositAmount' => $depositAmount,
                    'returnReason' => $returnReason,
                    'hirCode' => $hirCode,
                    'recDt' => $recDt,
                    'rtnDt' => $rtnDt,
                    'revDt' => $revDt,
                    'realisationDt' => $realisationDt,
                    'divisionCode' => $divisionCode,
                    'subCustomerCode' => $subCustomerCode,
                    'dS_Addl_InfoCode1' => $dS_Addl_InfoCode1,
                    'dS_Addl_InfoCode2' => $dS_Addl_InfoCode2,
                    'dS_Addl_InfoCode3' => $dS_Addl_InfoCode3,
                    'instNo' => $instNo,
                    'instAmt' => $instAmt,
                    'instAmtBreakup' => $instAmtBreakup,
                    'adjAmt' => $adjAmt,
                    'recoveredAmt' => $recoveredAmt,
                    'reversalAmt' => $reversalAmt,
                    'drnBk' => $drnBk,
                    'returnAmt' => $returnAmt,
                    'insAddl_InfoCode1' => $insAddl_InfoCode1,
                    'insAddl_InfoCode2' => $insAddl_InfoCode2,
                    'insAddl_InfoCode3' => $insAddl_InfoCode3,
                    'insAddl_InfoCode4' => $insAddl_InfoCode4,
                    'insAddl_InfoCode5' => $insAddl_InfoCode5,
                    'remarks1' => $remarks1,
                    'remarks2' => $remarks2,
                    'remarks3' => $remarks3,
                    'pooledAcNo' => $pooledAcNo,
                    'pooledDeptAmt' => $pooledDeptAmt,
                    "filename" => $file_1_name,
                    "missingRemarks" => $missingStatus,
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d')

                );



                if ($custCode != '' && $prdCode != '') {
                    if (MFLInwardCashMISIdfcPos::Insert($data)) {
                        $this->repository->increamentInsertedCount();
                    }
                }
            }
            // finializing the logs
            $this->repository->finializeLog();
            return response()->json([
                'message' => 'Success',
                "data" => $this->generateHTML(function () use ($getorinilfilename) {
                    return MFLInwardCashMISIdfcPos::select(
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



    /**
     * Data extraction
     * @param mixed $row
     * @return array<string>
     */
    protected function extractDataFromWorksheetRow($row) {

        if (trim($row['J'] == "")) {
            $instAmt = "0.00";
        } else {
            trim($instAmt = $row['J']);
        }
        if (trim($row['N'] == "")) {
            $adjAmt = "0.00";
        } else {
            trim($adjAmt = $row['N']);
        }
        if (trim($row['AI'] == "")) {
            $recoveredAmt = "0.00";
        } else {
            trim($recoveredAmt = $row['AI']);
        }
        if (trim($row['AK'] == "")) {
            $reversalAmt = "0.00";
        } else {
            trim($reversalAmt = $row['AK']);
        }
        if (trim($row['AJ'] == "")) {
            $returnAmt = "0.00";
        } else {
            trim($returnAmt = $row['Aj']);
        }
        if (trim($row['M'] == "")) {
            $pooledDeptAmt = "0.00";
        } else {
            trim($pooledDeptAmt = $row['M']);
        }


        return [
            'colBank' => config('constants.IDFC.cardBankName'), // bankName   
            'pkupPtCode' => trim($row['D']),
            'tranType' => trim($row['L']),
            'drCr' => trim($row['O']),
            'custCode' => trim($row['A']),
            'prdCode' => trim($row['B']),
            'locationName' => trim($row['C']),
            'depositDt' => ParseDateService::processDate(trim($row['G'])),
            'adjDt' => null,
            'crDt' => trim($row['K']),
            'depSlipNo' => trim($row['E']),
            'depositAmount' => trim($row['F']),
            'returnReason' => trim($row['T']),
            'hirCode' => trim($row['Y']),
            'recDt' => trim($row['Q']),
            'rtnDt' => trim($row['S']),
            'revDt' => trim($row['AL']),
            'realisationDt' => trim($row['R']),
            'divisionCode' => trim($row['X']),
            'subCustomerCode' => trim($row['Z']),
            'dS_Addl_InfoCode1' => trim($row['AA']),
            'dS_Addl_InfoCode2' => trim($row['AB']),
            'dS_Addl_InfoCode3' => trim($row['AC']),
            'instNo' => trim($row['H']),
            'instAmt' => $instAmt,
            'instAmtBreakup' => trim($row['AM']),
            'adjAmt' => $adjAmt,
            'recoveredAmt' => $recoveredAmt,
            'reversalAmt' => $reversalAmt,
            'drnBk' => trim($row['I']),
            'returnAmt' => $returnAmt,
            'insAddl_InfoCode1' => trim($row['AD']),
            'insAddl_InfoCode2' => trim($row['AE']),
            'insAddl_InfoCode3' => trim($row['AF']),
            'insAddl_InfoCode4' => trim($row['AG']),
            'insAddl_InfoCode5' => trim($row['AH']),
            'remarks1' => trim($row['U']),
            'remarks2' => trim($row['V']),
            'remarks3' => trim($row['W']),
            'pooledAcNo' => trim($row['AN']),
            'pooledDeptAmt' => $pooledDeptAmt,
        ];
    }


    /**
     * Getting the first item that is not null
     * @param \Illuminate\Support\Collection $worksheet
     * @return TFirstDefault|TValue
     */
    protected function getFirstLine(Collection $worksheet) {
        return $worksheet->filter(function ($item) {
            return Arr::first($item) !== null;
        })->keys()->first();
    }

}