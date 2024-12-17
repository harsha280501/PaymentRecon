<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AllBankCash extends Controller {



    // MFL_Inward_Staging_MFL_Inward_AllBankCashMIS_Table
        /**
     * Run all stages sequentially and stream the responses.
     */
    public function __invoke() {
        try {
            // Updating the records
            $dataset = DB::statement('MFL_Inward_Staging_MFL_Inward_AllBankCashMIS_Table');

            if(!$dataset) {
                return response()->json([
                    'status' => 500,
                    'message' => "Something went wrong",
                ], 500);
            }

            return response()->json([
                'status' => 200,
                'message' => "Successful",
            ], 200);

        } catch (\Throwable $th) {
            // throw an error incase something fails
            return response()->json([
                'status' => $th->getCode(),
                'message' => $th->getMessage()
            ], 500);
        }
    }
}