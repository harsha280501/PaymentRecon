<?php

namespace App\Http\Controllers\API\UpdateApis;

use App\Http\Controllers\Controller;
use App\Models\Masters\InwardCardMISHDFC;
use App\Models\MFLInwardCashMISAxisPos;
use App\Models\MFLinwardCashMISIciciPos;
use App\Models\MFLInwardCashMISIdfcPos;
use App\Models\MFLInwardCashMISSBIPos;
use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CashDepositController extends Controller {

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) {

        // validation
        $validate = Validator::make($request->only(['from', 'to']), [
            "from" => 'required',
            "to" => 'required',
        ]);

        // failed validation
        if ($validate->fails()) {
            // returning failed validation response
            return response()->json([
                'status' => 409,
                'message' => $validate->errors()
            ], 409);
        }

        try {

            DB::beginTransaction();
            // fetching the main response
            DB::statement('PaymentMIS_API_Insert_CASH_DEPOSIT_RECO :from, :to', [
                "from" => $request->from,
                "to" => $request->to
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }

        DB::commit();
        // returning a success response
        return response()->json([
            'status' => 201,
            'message' => "Success"
        ], 201);
    }
}