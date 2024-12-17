<?php

namespace App\Http\Controllers\CommercialHead\BankStatementUpload;

use App\Http\Controllers\Controller;
use App\Interface\BankStatementReadLogsInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\MFLInwardBankStatementICICI;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Services\Upload\ExcelBankStatement;

class ICICIController extends Controller
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
     * Handle the upload of ICICI bank statements.
     */
    public function bankStatementICICIUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,txt|max:9048',
        ]);

        $file = $request->file('file');
        $destinationPath = public_path('commercial/BankStatement/ICICI');
        $originalFilename = $file->getClientOriginalName();
        $file_1_name = $originalFilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        try {
            $file->move($destinationPath, $file_1_name);
            $targetPath = $destinationPath . DIRECTORY_SEPARATOR . $file_1_name;

            // Check if file already exists in the database
            if (MFLInwardBankStatementICICI::where('filename', 'like', '%' . $originalFilename . '%')->exists()) {
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
                    "colBank" => config('constants.ICICI.BankStatementName'),
                    "accountNo" => $this->sanitizeValue($row[array_keys($row)[0]] ?? ''),
                    "depositDate" => $this->convertBankDate($row[array_keys($row)[1]] ?? '', 'ICICI Bank Statement'),
                    "creditDate" => $this->convertBankDate($row[array_keys($row)[2]] ?? '', 'ICICI Bank Statement'),
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
                        MFLInwardBankStatementICICI::insert($dataToInsert);
                        $dataToInsert = [];
                    }
                }
            }
            // Insert any remaining data after the loop
            if (!empty($dataToInsert)) {
                MFLInwardBankStatementICICI::insert($dataToInsert);
            }
            return response()->json(['message' => 'Success'], 200);

        } catch (\Exception $exception) {
            Log::error('File processing error: ' . $exception->getMessage());
            return response()->json(['message' => 'An error occurred while processing the file.'], 500);
        }
    }
}
