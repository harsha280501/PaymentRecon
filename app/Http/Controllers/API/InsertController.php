<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;


class InsertController extends Controller {


    public function __invoke(Request $request) {

        // validation
        $validate = Validator::make($request->only(['proc_type', 'inserttype']), [
            "proc_type" => 'required',
            "inserttype" => 'required',
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
            // Begin the transaction to update the records
            \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                // Updating the records
                \Illuminate\Support\Facades\DB::statement("PAYMENT_MIS_INWARD_DATA :proc_type, :inserttype", [
                    "proc_type" => $request->proc_type,
                    "inserttype" => $request->inserttype
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
