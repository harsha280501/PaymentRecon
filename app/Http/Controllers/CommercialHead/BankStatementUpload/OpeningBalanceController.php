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
use App\Models\BankStatements\MFLInwardOpeningBalance;

// Others
use App\Services\GeneralService;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Services\Upload\ExcelBankStatement;
use Rap2hpoutre\FastExcel\FastExcel;




class OpeningBalanceController extends Controller {



     /**
     * Sanitize a value by trimming and removing single quotes.
     */
    private function sanitizeValue($value)
    {
        return trim(str_replace("'", '', $value));
    }


    private function convertBankDate($date, $format)
    {
        if ($date instanceof \DateTimeImmutable) {

            return ExcelBankStatement::convertDateForForBankSt($date->format('Y-m-d'), $format);
        }
        return ExcelBankStatement::convertDateForForBankSt($this->sanitizeValue($date), $format);
    }

    /**
     * Upload and process SBI bank statements.
     */
    public function openingBalanceUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:9048'
        ]);

        $file = $request->file('file');
        $destinationPath = public_path('commercial/BankStatement/OpeningBalance');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $originalFilename = $file->getClientOriginalName();
        $file_1_name = $originalFilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        try {
            $file->move($destinationPath, $file_1_name);
            $targetPath = $destinationPath . DIRECTORY_SEPARATOR . $file_1_name;

            // Check for duplicate file in the database
            if (MFLInwardOpeningBalance::where('filename', 'like', '%' . $originalFilename . '%')->exists()) {
                return response()->json(['message' => 'The filename already exists in the database.'], 409);
            }

            $rows = (new FastExcel)->import($targetPath);
            $dataToInsert = [];
            $counter = 0;
            // batchSize=13/2100=161.5 approx
            // Adjusted batch size based on the 2,100 parameter limit
            $batchCount = 100;

            foreach ($rows as $row) {
                $dataToInsert[] = [
                    "storeID" => $this->sanitizeValue($row[array_keys($row)[0]] ?? ''),
                    "retekCode" => $this->sanitizeValue($row[array_keys($row)[1]] ?? ''),                    
                    "openingBalanceDate" => $this->convertBankDate($row[array_keys($row)[2]] ?? '', 'SBI Bank Statement'),
                    "openingBalanceYear" => $this->sanitizeValue($row[array_keys($row)[3]] ?? ''),
                    "cashOpBalance" => ExcelBankStatement::convertPriceFormatNumeric($this->sanitizeValue($row[array_keys($row)[4]] ?? '')),
                    "cardOpBalance" => ExcelBankStatement::convertPriceFormatNumeric($this->sanitizeValue($row[array_keys($row)[5]] ?? '')),
                    "upiOpBalance" => ExcelBankStatement::convertPriceFormatNumeric($this->sanitizeValue($row[array_keys($row)[6]] ?? '')),
                    "walletOpBalance" => ExcelBankStatement::convertPriceFormatNumeric($this->sanitizeValue($row[array_keys($row)[7]] ?? '')),
                    "totalOpBalance" => ExcelBankStatement::convertPriceFormatNumeric($this->sanitizeValue($row[array_keys($row)[8]] ?? '')),
                    "openBalanceRemarks" => $this->sanitizeValue($row[array_keys($row)[9]] ?? ''),
                    "filename" => $file_1_name,
                    'isActive' => '1',
                    "createdBy" => Auth::id(),                    
                    'createdDate' => now()->format('Y-m-d H:i:s'),
                ];

                if (++$counter % $batchCount == 0) {
                    if (!empty($dataToInsert)) {
                        MFLInwardOpeningBalance::insert($dataToInsert);
                        $dataToInsert = [];
                    }
                }
            }

            // Insert any remaining data after the loop
            if (!empty($dataToInsert)) {
                MFLInwardOpeningBalance::insert($dataToInsert);
            }

            return response()->json(['message' => 'Success'], 200);

        } catch (\Exception $exception) {
            // Log the exception for debugging
            Log::error('File processing error: ' . $exception->getMessage());
            return response()->json(['message' => 'An error occurred while processing the file.'], 500);
        }
    }




}
