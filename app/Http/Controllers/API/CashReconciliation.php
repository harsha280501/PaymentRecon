<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CashReconciliation extends Controller {



 
        /**
     * Run all stages sequentially and stream the responses.
     */
    public function __invoke()
    {
        $stages = ['stage1', 'stage2', 'stage3', 'stage4', 'stage5', 'stage6'];

        return new StreamedResponse(function () use ($stages) {
            
            ob_start();

            foreach ($stages as $stage) {
                try {
                    // Dynamically call the stage methods
                    $response = $this->$stage();

                    if ($response->getData()->status == 500) {
                        echo "Error in $stage: " . $response->getData()->message;
                        break;
                    }


                    // Stream the response
                    echo "Completed $stage: " . $response->getData()->message;
                    echo "\n"; // Add a newline for readability

                    ob_flush();
                    flush();
                    
                } catch (\Throwable $th) {
                    // Stream the error response
                    echo "Error in $stage: " . $th->getMessage();
                    echo "\n"; // Add a newline for readability
                    ob_flush();
                    flush();
                }
            }

            ob_end_flush();
        });
    }







    /**
     * Handle the incoming request.
     */
    public function stage1() {

        try {

            DB::beginTransaction();

            $res = DB::statement('MFL_Inward_Staging_MFL_Inward_AllBankCashMIS_Stage_1');

            if (!$res) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong, Please Try Again!..'
                ], 500);
            }

            DB::commit();
            return response()->json([
                "status" => 201,
                "message" => "Successfully!.."
            ]);


        } catch (\Throwable $th) {

            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }



    /**
     * Handle the incoming request.
     */
    public function stage2() {

        try {

            DB::beginTransaction();

            $res = DB::statement('MFL_Inward_Staging_MFL_Inward_MPOS_SalesETL_1');

            if (!$res) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong, Please Try Again!..'
                ], 500);
            }

            DB::commit();
            return response()->json([
                "status" => 201,
                "message" => "Successfully!.."
            ]);


        } catch (\Throwable $th) {

            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * Handle the incoming request.
     */
    public function stage3() {

        try {

            DB::beginTransaction();

            $res = DB::statement('MFL_Inward_Staging_MFL_Outward_MPOSCashTenderBankDropCashMISReco_1');

            if (!$res) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong, Please Try Again!..'
                ], 500);
            }

            DB::commit();
            return response()->json([
                "status" => 201,
                "message" => "Successfully!.."
            ]);


        } catch (\Throwable $th) {

            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }



    /**
     * Handle the incoming request.
     */
    public function stage4() {

        try {

            DB::beginTransaction();

            $res = DB::statement('MFL_Inward_Staging_MFL_Inward_AllBankCashMIS_Stage_2');

            if (!$res) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong, Please Try Again!..'
                ], 500);
            }

            DB::commit();
            return response()->json([
                "status" => 201,
                "message" => "Successfully!.."
            ]);


        } catch (\Throwable $th) {

            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }



    /**
     * Handle the incoming request.
     */
    public function stage5() {

        try {

            DB::beginTransaction();

            $res = DB::statement('MFL_Inward_Staging_MFL_Outward_MPOSCashTenderBankDropCashMISReco_2');

            if (!$res) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong, Please Try Again!..'
                ], 500);
            }

            DB::commit();
            return response()->json([
                "status" => 201,
                "message" => "Successfully!.."
            ]);


        } catch (\Throwable $th) {

            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }



    /**
     * Handle the incoming request.
     */
    public function stage6() {

        try {

            DB::beginTransaction();

            $res = DB::statement('MFL_Inward_MFL_Outward_MPOSCashTenderBankDropCashMISReco_Final');

            if (!$res) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong, Please Try Again!..'
                ], 500);
            }

            DB::commit();
            return response()->json([
                "status" => 201,
                "message" => "Successfully!.."
            ]);


        } catch (\Throwable $th) {

            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}