<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class SelectMISApi extends Controller {
    public function __invoke(Request $request) {
        // validation
        $validate = Validator::make($request->only(['filename', 'bank']), [
            "filename" => 'required|string|min:3',
            "bank" => 'required|string|min:3',
        ]);

        // failed validation
        if ($validate->fails()) {
            return response()->json([
                'status' => 409,
                'message' => $validate->errors()
            ], 409);
        }

        try {
            // Updating the records
            $dataset = \Illuminate\Support\Facades\DB::select('PaymentMIS_API_SELECT_UPLOADED_FILE :FileName, :Bank', [
                'FileName' => $request->filename,
                'Bank' => $request->bank
            ]);

            // when everything is successful
            return response()->json([
                'status' => 200,
                'message' => "Successful",
                'data' => $dataset
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
