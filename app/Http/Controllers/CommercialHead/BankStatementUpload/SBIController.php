<?php

namespace App\Http\Controllers\CommercialHead\BankStatementUpload;

use App\Http\Controllers\Controller;
use App\Interface\BankStatementReadLogsInterface;
use App\Models\Logs\UploadLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\MFLInwardBankStatementSBI;
use App\Services\Upload\ExcelBankStatement;
use Rap2hpoutre\FastExcel\FastExcel;

class SBIController extends Controller
{
    public function __construct(public BankStatementReadLogsInterface $repository)
    {
    }

    /**
     * Sanitize a value by trimming and removing single quotes.
     */
    private function sanitizeValue($value)
    {
        return trim(str_replace("'", '', $value));
    }

    /**
     * Convert bank date to the required format.
     */
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
    public function bankStatementSBIUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,txt|max:9048'
        ]);

        $file = $request->file('file');
        $destinationPath = public_path('commercial/BankStatement/SBI');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $originalFilename = $file->getClientOriginalName();
        $file_1_name = $originalFilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();

        try {
            $file->move($destinationPath, $file_1_name);
            $targetPath = $destinationPath . DIRECTORY_SEPARATOR . $file_1_name;

            // Check for duplicate file in the database
            if (MFLInwardBankStatementSBI::where('filename', 'like', '%' . $originalFilename . '%')->exists()) {
                return response()->json(['message' => 'The filename already exists in the database.'], 409);
            }

            $rows = (new FastExcel)->import($targetPath);
            $dataToInsert = [];
            $counter = 0;
            // batchSize=13/2100=161.5 approx
            // Adjusted batch size based on the 2,100 parameter limit
            $batchCount = 160;

            foreach ($rows as $row) {
                $dataToInsert[] = [
                    "colBank" => config('constants.SBI.BankStatementName'),
                    "accountNo" => $this->sanitizeValue($row[array_keys($row)[0]] ?? ''),
                    "depositDate" => $this->convertBankDate($row[array_keys($row)[1]] ?? '', 'SBI Bank Statement'),
                    "creditDate" => $this->convertBankDate($row[array_keys($row)[2]] ?? '', 'SBI Bank Statement'),
                    "description" => $this->sanitizeValue($row[array_keys($row)[3]] ?? ''),
                    "remaksReferenceNo" => $this->sanitizeValue($row[array_keys($row)[4]] ?? ''),
                    "debit" => ExcelBankStatement::convertPriceFormatNumeric($this->sanitizeValue($row[array_keys($row)[5]] ?? '')),
                    "credit" => ExcelBankStatement::convertPriceFormatNumeric($this->sanitizeValue($row[array_keys($row)[6]] ?? '')),
                    "transactionBr" => $this->sanitizeValue($row[array_keys($row)[7]] ?? ''),
                    "filename" => $file_1_name,
                    "createdBy" => Auth::id(),
                    'isActive' => '1',
                    'createdDate' => now()->format('Y-m-d H:i:s'),
                ];

                if (++$counter % $batchCount == 0) {
                    if (!empty($dataToInsert)) {
                        MFLInwardBankStatementSBI::insert($dataToInsert);
                        $dataToInsert = [];
                    }
                }
            }

            // Insert any remaining data after the loop
            if (!empty($dataToInsert)) {
                MFLInwardBankStatementSBI::insert($dataToInsert);
            }

            return response()->json(['message' => 'Success'], 200);

        } catch (\Exception $exception) {
            // Log the exception for debugging
            Log::error('File processing error: ' . $exception->getMessage());
            return response()->json(['message' => 'An error occurred while processing the file.'], 500);
        }
    }

}
