<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MailingList extends Controller {

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) {

        try {
            // main dataset for the function
            $_mtd = $this->dataset('_MTD');
            $_ytd = $this->dataset('_YTD');

            // get the file path
            $_mtd_path = $this->excel($_mtd, [
                'Month to Date (2024-06-01 - ' . now()->format('d-m-Y') . ')'
            ], [
                "Store ID","Sales Count","Bank Drop Count","Deposit Slip Number"
            ]);


            $_ytd_path = $this->excel($_ytd, [
                'Year to Date (2023-04-01 - ' . now()->format('d-m-Y') . ')'
            ], [
                "Store ID","Sales Count","Bank Drop Count","Deposit Slip Number"
            ]);
            
            $_path = $_mtd_path . ';' . $_ytd_path; // join the file path to send multiple files

            // send the file vie mail
            DB::statement('PaymentMIS_API_BANKDROP_MailList :procType, :path', [
                'procType' => "_mail",
                'path' => $_path
            ]);

        } catch (\Throwable $th) {

            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
        // returning a success response
        return response()->json([
            'status' => 201,
            'message' => "Success"
        ], 201);
    }




    /**
     * Get the downloadable data
     * @param string $procType
     * @return array
     */
    protected function dataset(string $procType) {
        return DB::select('PaymentMIS_API_BANKDROP_MailList :procType, :path', [
            'procType' => $procType,
            'path' => null
        ]);
    }





    /**
     * Export the dataset as a csv file
     * @param [type] $data
     * @param array $headers
     * @return string
     */
    protected function excel(array $data, array $head = [], array $headers = []) {

        $export_file_name = trim($head[0]) . md5('Tmp_DownloadFile_' . rand(100000000, 100000000000000000) . '_' . Carbon::now()->format('d-m-Y H:i:s'));
        $filePath = public_path() . '/' . $export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists
        fputcsv($file, $head); // adding headers to the excel
        fputcsv($file, $headers); // adding headers to the excel

        foreach ($data as $row) {
            $row = (array) $row;
            fputcsv($file, $row);
        }

        fclose($file);
        return $filePath;
    }
}