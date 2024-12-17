<?php

namespace App\Http\Controllers\API\UpdateApis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReconciliationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function CardStage1Reconciliation(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('EXEC ZZ_MFL_Outward_CardSalesReco_STAGE1_INSERT');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "CardSalesReco_STAGE1_INSERT Query Executed successful"
            ], 201);

        } catch (\Throwable $th) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Return error response
            return response()->json([
                'status' => $th->getCode(),
                'message' => "Query failed"
            ], 500);
        }
    }

    public function CardStage2Reconciliation(Request $request)
    {
        try {
            // Begin the transaction
            // DB::beginTransaction();

            // Call the stored procedure
            DB::statement('EXEC ZZ_MFL_Outward_CardSalesReco_STAGE2_INSERT');

            // Commit the transaction
            // DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "CardSalesReco_STAGE2_INSERT Query Executed successful"
            ], 201);

        } catch (\Throwable $th) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Return error response
            return response()->json([
                'status' => $th->getCode(),
                'message' => "Query failed"
            ], 500);
        }
    }

    public function WalletReconciliation(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('EXEC PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_SALESWALLETRECO');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Wallet Reconcilation Query Executed successful"
            ], 201);

        } catch (\Throwable $th) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Return error response
            return response()->json([
                'status' => $th->getCode(),
                'message' => "Query failed"
            ], 500);
        }
    }

    public function CashStage1Reconciliation(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('EXEC ZZ_MFL_Outward_CASHReco_STAGE1_INSERT');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "CASHReco_STAGE1_INSERT  Query Executed successful"
            ], 201);

        } catch (\Throwable $th) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Return error response
            return response()->json([
                'status' => $th->getCode(),
                'message' => "Query failed"
            ], 500);
        }
    }

    public function CashStage2Reconciliation(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('EXEC ZZ_MFL_Outward_CASHReco_STAGE2_INSERT');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "CASHReco_STAGE2_INSERT  Query Executed successful"
            ], 201);

        } catch (\Throwable $th) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Return error response
            return response()->json([
                'status' => $th->getCode(),
                'message' => "Query failed"
            ], 500);
        }
    }
}
