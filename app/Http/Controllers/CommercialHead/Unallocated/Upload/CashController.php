<?php

namespace App\Http\Controllers\CommercialHead\Unallocated\Upload;

use App\Http\Controllers\Controller;
use App\Interface\MisReadLogsInterface;
use App\Models\BrandNotConsider;

// Request

use App\Models\Logs\UploadLog;

use Illuminate\Http\Request;



// Response
use Illuminate\Http\RedirectResponse;

// Model
use App\Models\MFLInwardCashMISAxisPos;
use App\Models\MFLInwardCashMISHdfcPos;
use App\Models\MFLinwardCashMISIciciPos;
use App\Models\MFLInwardCashMISIdfcPos;
use App\Models\MFLInwardCashMIS2SBIPos;
use App\Models\MFLInwardCashMISSBIMumbai;
use App\Models\MRepository;
use App\Models\MFLInwardStoreIDMissingTransactions;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Log;


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
// use Log;
use Illuminate\Support\Str;



class CashController extends Controller
{


    public function importUnallocatedCash(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv|max:120000'
        ]);


        Log::channel('store-missing-transactions')->debug('Starting importUnallocatedCard Excel Import');

        $file = $request->file('file');
        $destinationPath = storage_path('app/public/commercial/unallocated/cash/');

        $getorinilfilename = $file->getClientOriginalName();
        $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $file_1_name);
        $targetPath = storage_path('app/public/commercial/unallocated/cash/') . $file_1_name;

        $inputFileTypeIdentify = \PhpOffice\PhpSpreadsheet\IOFactory::identify($targetPath);
        $inputFileTypeFormat = ucwords($inputFileTypeIdentify);

        if ($inputFileTypeFormat == 'csv' || $inputFileTypeFormat == 'CSV' || $inputFileTypeFormat == 'Csv') {
            $inputFileType = 'Csv';
        }

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);

        $spreadsheet = $reader->load($targetPath);

        $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet        


        try {

            for ($i = 2; $i <= $arrayCount; $i++) {

                $salesDate = '';
                $depositDate = '';

                $uniqueID = trim(str_replace("'", '', $worksheet[$i]["A"])); //Unique ID
                Log::channel('store-missing-transactions')->debug('Store ID uniqueID', ['uniqueID' => $uniqueID]);

                if (MFLInwardStoreIDMissingTransactions::where('storeMissingUID', $uniqueID)->exists()) {


                    Log::channel('store-missing-transactions')->debug('Inside the LOOP', ['storeMissingUID' => $uniqueID]);



                    if (trim(str_replace("'", '', $worksheet[$i]["B"])) != '') {
                        $salesDate = Carbon::parse(trim(str_replace("'", '', $worksheet[$i]["B"])))->format('Y-m-d'); // SalesDate
                    }

                    if (trim(str_replace("'", '', $worksheet[$i]["C"])) != '') {
                        $depositDate = Carbon::parse(trim(str_replace("'", '', $worksheet[$i]["C"])))->format('Y-m-d'); // Deposit Date
                    }
                    logger('lkjhgfd');

                    $storeID = trim(str_replace("'", '', $worksheet[$i]["D"])); //store ID

                    // dd($storeID);
                    $store = Store::where('Store ID', $storeID)->first();

                    if ($store) {
                        // get the user brand
                        // and append the data in the table


                        Log::channel('store-missing-transactions')->debug('Inside the Store IDLOOP Start', ['storeUID' => $storeID]);

                        $retekCode = trim(str_replace("'", '', $worksheet[$i]["E"])); //Retek Code
                        $tid = trim(str_replace("'", '', $worksheet[$i]["F"])); //TID
                        $collectionBank = trim(str_replace("'", '', $worksheet[$i]["H"])); //COllection Bank
                        $deposit_amount = ExcelUploadGeneralService::convertPriceFormatUsingNumeric(str_replace(',', '', $worksheet[$i]["J"])); // SLIP AMOUNT
                        logger($deposit_amount);

                        $userId = auth()->user()->userUID;


                        $missingTransaction = MFLInwardStoreIDMissingTransactions::find($uniqueID);

                        $missingTransaction->salesDate = $salesDate;
                        $missingTransaction->depositDate = $depositDate;
                        $missingTransaction->storeID = $storeID;
                        $missingTransaction->retekCode = $retekCode;
                        $missingTransaction->tid = $tid;
                        $missingTransaction->colBank = $collectionBank;
                        $missingTransaction->depositAmount = $deposit_amount;

                        $missingTransaction->brand = $store->{'Brand Desc'};


                        $missingTransaction->missingRemarks = 'Valid';
                        $missingTransaction->unAllocatedStatus = 'Valid';
                        $missingTransaction->unAllocatedRemarks = "Imported by Excel";
                        $missingTransaction->unAllocatedCorrectionDate = now()->format('Y-m-d');
                        $missingTransaction->isActive = 1;
                        $missingTransaction->modifiedBy = $userId;
                        $missingTransaction->modifiedDate = now()->format('Y-m-d');
                        $missingTransaction->update();

                        $collectionBankSlug = str::slug($collectionBank);

                        $bankModels = [
                            'axis-cash' => [MFLInwardCashMISAxisPos::class, 'CasMISAxisPosUID'],
                            'hdfc' => [MFLInwardCashMISHdfcPos::class, 'CashMISHdfcPosUID'],
                            'icici-cash' => [MFLinwardCashMISIciciPos::class, 'CashMISIciciPosUID'],
                            'sbicashmis' => [MFLInwardCashMIS2SBIPos::class, 'CashMISSbiPosUID'],
                            'sbicashmumbai' => [MFLInwardCashMISSBIMumbai::class, 'CashMISSbiMumUID'],
                            'idfc-cash' => [MFLInwardCashMISIdfcPos::class, 'CashMISIdfcPosUID'],
                        ];

                        if (array_key_exists($collectionBankSlug, $bankModels)) {
                            [$model, $uidField] = $bankModels[$collectionBankSlug];

                            // Use the dynamic model and UID field for the update
                            $updateCol = $model::where($uidField, $missingTransaction->UID)->update([
                                'storeID' => $storeID,
                                'retekCode' => $retekCode,
                                'brand' => $store->{'Brand Desc'},
                                'missingRemarks' => 'Valid',
                            ]);
                        } else {
                            return 'Wrong area.';
                        }

                        // $uniqueID find MFL_Inward_CardMIS_SbiPos(unquieID)
                        // storeID,retexkCode ->update
                        // 

                        Log::channel('store-missing-transactions')->debug('Inside the Store LOOP END::', ['storeUID' => $storeID]);
                    }

                    Log::channel('store-missing-transactions')->debug('Inside the LOOP END ', ['uniqueID' => $uniqueID]);
                }
            }

            // finializing the logs           
            return response()->json(['message' => 'Success'], 200);
        } catch (\Throwable $exception) {

            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
