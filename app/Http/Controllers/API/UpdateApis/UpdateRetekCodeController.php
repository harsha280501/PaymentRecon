<?php

namespace App\Http\Controllers\API\UpdateApis;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UpdateRetekCodeController extends Controller
{
    public function SalestableRetekcode(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('UpdateRetekCodeForSalesETL');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed successful"
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


   

    public function BrandMissingRemarks(Request $request)
    {
    try {

        // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('UpdateBrandDescAndMissingRemarks');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed successful"
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

    public function UpdateRetekcode(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('UpdateRetekCode');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed successful"
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

    public function Salesmail(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('PaymentMIS_PROC_MAIL_FOR_SALESDATASET');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed successful"
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


    public function storeIDTransaction(Request $request)
{
    // Validate the request to ensure procType is provided
    $request->validate([
        'procType' => 'required|string'
    ]);

    $procType = $request->input('procType');

    try {
        // Begin the transaction
        DB::beginTransaction();

        // Call the stored procedure with the procType parameter
        DB::statement('EXEC PaymentMIS_PROC_INSERT_COMMERCIALHEAD_StoreID_Missing_Transaction @procType = :procType', [
            'procType' => $procType
        ]);

        // Commit the transaction
        DB::commit();

        // Return success response
        return response()->json([
            'status' => 201,
            'message' => "Executed successfully"
        ], 201);
    } catch (\Throwable $th) {
        // Rollback the transaction in case of error
        DB::rollBack();
        // Return error response
        return response()->json([
            'status' => $th->getCode(),
            'message' => "Query failed: " . $th->getMessage()
        ], 500);
    }
}

public function CASHRGTSNEFT(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('PaymentMIS_API_Insert_CASH_DEPOSIT_RECO');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "RTGS&NEFT Inserted"
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

public function TruncateTables(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('PaymentMIS_API_Truncate_Table');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Table's Truncated!"
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

    public function WalletRecon(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_SALESWALLETRECO');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed Successfully"
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

    public function CashRecon(Request $request)
    {
        // Validate the request to ensure procType is provided
        $request->validate([
            'robot' => 'required|string'
        ]);
    
        $robot = $request->input('robot');
    
        try {
            // Begin the transaction
            DB::beginTransaction();
    
            // Call the stored procedure with the procType parameter
            DB::statement('EXEC sp_Insert_CashReconciliation @robot = :robot', [
                'robot' => $robot
            ]);
    
            // Commit the transaction
            DB::commit();
    
            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed Successfully"
            ], 201);
        } catch (\Throwable $th) {
            // Rollback the transaction in case of error
            DB::rollBack();
            // Return error response
            return response()->json([
                'status' => $th->getCode(),
                'message' => "Query failed: " . $th->getMessage()
            ], 500);
        }
    }

    public function AllTenderRecon(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('RECON_ALLTENDER_Reconciliation_INSERT_FROMRECO_TABLES');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed Successfully"
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

   

    public function InsertnewStoreID(Request $request)
    {
        // Validate the request to ensure procType is provided
        $request->validate([
            'procType' => 'required|string'
        ]);
    
        $procType = $request->input('procType');
    
        try {
            // Begin the transaction
            DB::beginTransaction();
    
            // Call the stored procedure with the procType parameter
            DB::statement('EXEC PaymentMIS_INSERT_NEW_STOREID @procType = :procType', [
                'procType' => $procType
            ]);
    
            // Commit the transaction
            DB::commit();
    
            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed Successfully"
            ], 201);
        } catch (\Throwable $th) {
            // Rollback the transaction in case of error
            DB::rollBack();
            // Return error response
            return response()->json([
                'status' => $th->getCode(),
                'message' => "Query failed: " . $th->getMessage()
            ], 500);
        }
    }

   
    public function ReconDate(Request $request)
    {
        // Validate the request to ensure procType is provided
        $request->validate([
            'reconcilDate' => 'required'
        ]);
    
        $reconcilDate = $request->input('reconcilDate');
    
        try {
            // Begin the transaction
            DB::beginTransaction();
    
            // Call the stored procedure with the procType parameter
            DB::statement('EXEC PaymentMIS_UpdateReconcilUptoDate @reconcilDate = :reconcilDate', [
                'reconcilDate' => $reconcilDate
            ]);
    
            // Commit the transaction
            DB::commit();
    
            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed Successfully"
            ], 201);
        } catch (\Throwable $th) {
            // Rollback the transaction in case of error
            DB::rollBack();
            // Return error response
            return response()->json([
                'status' => $th->getCode(),
                'message' => "Query failed: " . $th->getMessage()
            ], 500);
        }
    }
    public function AllWallet(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_INSERT_AllWalletMIS');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed Successfully"
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
    public function AllBankCard(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('PaymentMIS_PROC_COMMERCIALHEAD_ALLBANKMIS_CARD');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed Successfully"
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
    public function CardRecon(Request $request)
    {
        try {
            // Begin the transaction
            DB::beginTransaction();

            // Call the stored procedure
            DB::statement('RECON_CARD_MFL_Outward_CardSalesReco');

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed Successfully"
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
    public function DirectDepositToStage(Request $request)
    {
        // Validate the request to ensure procType is provided
        $request->validate([
            'proctype' => 'required|string'
        ]);
    
        $procType = $request->input('proctype');
    
        try {
            // Begin the transaction
            DB::beginTransaction();
    
            // Call the stored procedure with the procType parameter
            DB::statement('EXEC PaymentMIS_Insert_DirectDeposits @proctype = :proctype', [
                'proctype' => $procType
            ]);
    
            // Commit the transaction
            DB::commit();
    
            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed Successfully"
            ], 201);
        } catch (\Throwable $th) {
           
            DB::rollBack();
           
            return response()->json([
                'status' => $th->getCode(),
                'message' => "Query failed: " . $th->getMessage()
            ], 500);
        }
    }
    public function CashDepositToAllbankCash(Request $request)
    {
        // Validate the request to ensure procType is provided
        $request->validate([
            'proctype' => 'required|string'
        ]);
    
        $procType = $request->input('proctype');
    
        try {
            // Begin the transaction
            DB::beginTransaction();
    
            // Call the stored procedure with the procType parameter
            DB::statement('EXEC PaymentMIS_API_Insert_CASH_DEPOSIT_ALLCashMIS @proctype = :proctype', [
                'proctype' => $procType
            ]);
    
            // Commit the transaction
            DB::commit();
    
            // Return success response
            return response()->json([
                'status' => 201,
                'message' => "Executed Successfully"
            ], 201);
        } catch (\Throwable $th) {
           
            DB::rollBack();
           
            return response()->json([
                'status' => $th->getCode(),
                'message' => "Query failed: " . $th->getMessage()
            ], 500);
        }
    }
}


