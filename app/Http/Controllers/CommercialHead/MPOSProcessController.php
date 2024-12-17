<?php

namespace App\Http\Controllers\CommercialHead;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class MPOSProcessController extends Controller {



    protected $fileStoragePath;


    public function __construct() {
        $this->fileStoragePath = storage_path('app/public/reconciliation/cash_to_bank_statement-reconciliation');
    }


    public function MPOSCardReconApproval(Request $request, string $id) {

        try {

            DB::beginTransaction();
            // creating a builder
            $builder = DB::table('MFL_Outward_MPOSCardSalesReco')
                ->where('mposCardSalesRecoUID', $id);



            // createing a sub builder for approval process
            $subBuiled = DB::table('MLF_Outward_MPOSCardSalesReco_ApprovalProcess')
                ->where('mposCardSalesRecoUID', $id);


            // updating the status manually
            $subBuiled->update([
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'remarks' => $request->remarks
            ]);

            // updating the main table
            $builder->update([
                'status' => $request->approvalStatus == 'approve' ? 'Matched' : 'Not Matched',
                'reconStatus' => $request->approvalStatus
            ]);


            if ($request->approvalStatus != 'approve') {
                DB::commit();
                return response()->json(['message' => 'Success'], 200);
            }

            // getting the sales amount
            $cashSale = $builder->first();
            // Get records collection amount

            // get Adj amount from builder
            $adjustmentAmount = $cashSale->adjustmentAmount;
            // sum the difference and adj amount 
            $reconDifference = $cashSale->tenderAmount - ($cashSale->depositAmount + $adjustmentAmount);

            $builder->update([
                'reconDifference' => $reconDifference
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
        // main return
        return response()->json(['message' => 'Success'], 200);
    }

    public function MPOSWalletReconApproval(Request $request, string $id) {

        try {

            DB::beginTransaction();
            // creating a builder
            $builder = DB::table('MFL_Outward_MPOSWalletSalesReco')
                ->where('mposWalletSalesRecoUID', $id);



            // createing a sub builder for approval process
            $subBuiled = DB::table('MLF_Outward_MPOSWalletSalesReco_ApprovalProcess')
                ->where('mposWalletSalesRecoUID', $id);


            // updating the status manually
            $subBuiled->update([
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'remarks' => $request->remarks
            ]);

            // updating the main table
            $builder->update([
                'status' => $request->approvalStatus == 'approve' ? 'Matched' : 'Not Matched',
                'reconStatus' => $request->approvalStatus
            ]);


            if ($request->approvalStatus != 'approve') {
                DB::commit();
                return response()->json(['message' => 'Success'], 200);
            }

            // getting the sales amount
            $cashSale = $builder->first();
            // Get records collection amount

            // get Adj amount from builder
            $adjustmentAmount = $cashSale->adjustmentAmount;
            // sum the difference and adj amount 
            $reconDifference = $cashSale->tenderAmount - ($cashSale->depositAmount + $adjustmentAmount);

            $builder->update([
                'reconDifference' => $reconDifference
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
        // main return
        return response()->json(['message' => 'Success'], 200);
    }




}
