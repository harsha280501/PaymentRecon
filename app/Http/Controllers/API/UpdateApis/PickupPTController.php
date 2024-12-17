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
use Illuminate\Support\Facades\Validator;
use Throwable;

class PickupPTController extends Controller {

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) {

        // validation
        $validate = Validator::make($request->only(['pickupCode', 'bankName']), [
            "pickupCode" => 'required',
            "bankName" => 'required',
        ]);

        // failed validation
        if ($validate->fails()) {
            // returning failed validation response
            return response()->json([
                'status' => 409,
                'message' => $validate->errors()
            ], 409);
        }

        // fetching the main response
        $response = $this->uploadedDataset($request->pickupCode, $request->bankName);


        // checking if something went wrong
        if (!$response) {
            return response()->json([
                'status' => 500,
                'store' => $this->dataset($request->pickupCode),
                'message' => "Something went Wrong"
            ], 500);
        }



        // returning a success response
        return response()->json([
            'status' => 201,
            // 'store' => $this->dataset($request->pickupCode),
            'message' => "Success"
        ], 201);
    }


    /**
     * Getting the Data from Store
     * @param string $code
     * @return mixed
     */
    protected function dataset($code) {

        // the given code is Retek code
        if (strlen($code) > 4) {
            return Store::where("RETEK Code", $code)
                ->get(['Store ID', 'RETEK Code'])
                    ?->first();
        }
        // main return if code is less than 4 digits
        return Store::where('Store ID', $code)
            ->get(['Store ID', 'RETEK Code'])
                ?->first();
    }



    /**
     * Updating the Records
     * @param string $code
     * @return mixed
     */
    protected function uploadedDataset($code, string $bank) {
        // store
        $storeDataset = $this->dataset(code: $code);

        // checking if store id is not null
        if ($storeDataset == null) {
            return false;
        }

        // getting the builder
        $builder = $this->builder($bank);

        // returning if false
        if (!$builder) {
            return false;
        }


        $mainBuilder = $builder
            ->where('storeID', null)
            ->orWhere('storeID', '')
            ->where('pkupPtCode', $code)
            ->where('colBank', $bank);

        // updating Datasets
        $datsets = $mainBuilder->update([
            'storeID' => $storeDataset->{'Store ID'},
            'retekCode' => $storeDataset->{'RETEK Code'}
        ]);

        return $datsets;
    }



    /**
     * Get the Approprite Table names
     * @param string $bank
     * @return \Illuminate\Database\Eloquent\Builder|bool
     */
    protected function builder(string $bank): Builder|bool {

        // fetching HDFC Cash Query
        if ($bank == 'HDFC Cash') {
            return InwardCardMISHDFC::query();
        }

        // fetching Axis Cash Query
        if ($bank == 'Axis Cash') {
            return MFLInwardCashMISAxisPos::query();
        }

        // fetching ICICI Cash Query
        if ($bank == 'ICICI Cash') {
            return MFLinwardCashMISIciciPos::query();
        }

        // fetching SBI Cash Query
        if ($bank == 'SBI Cash') {
            return MFLInwardCashMISSBIPos::query();
        }

        // fetching IDFC Cash Query
        if ($bank == 'IDFC') {
            return MFLInwardCashMISIdfcPos::query();
        }

        return false;

    }


}