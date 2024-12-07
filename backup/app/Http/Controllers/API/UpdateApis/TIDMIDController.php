<?php

namespace App\Http\Controllers\API\UpdateApis;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TIDMIDController extends Controller {

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) {

        // validation
        $validate = Validator::make($request->only(['bank']), [
            "bank" => 'required|string|min:3|in:HDFC,ICICI,AMEX,SBI,UPIH,PHONEPAY,PHONEPAYEXCELSTOREID,SBICashSUN,SBICashSAT,SBICash2VanI,SBICash2Van,HDFCCard ClosureDate,UPI ClosureDate,SBICARD ClosureDate,AMEXCARD ClosureDate',
        ]);

        // failed validation
        if ($validate->fails()) {
            return response()->json([
                'status' => 409,
                'message' => $validate->errors()
            ], 409);
        }

        try {
            // Begin the transaction to update the records
            \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                // Updating the records
                \Illuminate\Support\Facades\DB::statement('PaymentMIS_API_Update_TID_MID_Card :bank', [
                    'bank' => $request->bank
                ]);
                // commit is required so the database actions only saves if the query ran without any errors
                \Illuminate\Support\Facades\DB::commit();
            });

            // when everything is successful
            return response()->json([
                'status' => 201,
                'message' => "The database cheerfully confirmed: Query successful, data at your service!"
            ], 201);

        } catch (\Throwable $th) {
            // throw an error incase something fails
            return response()->json([
                'status' => $th->getCode(),
                'message' => "The database sighed in disappointment: Query failed, data slipping through the fingertips of fate."
            ], 500);
        }
    }
}