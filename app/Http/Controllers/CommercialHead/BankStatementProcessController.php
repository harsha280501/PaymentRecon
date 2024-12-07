<?php

namespace App\Http\Controllers\CommercialHead;

use App\Http\Controllers\Controller;
use App\Models\Process\MPOS\Cash\CashBankRecon;
use App\Models\Process\MPOS\Cash\CashBankReconApproval;
use App\Models\Process\MPOS\Cash\CashRecon;
use App\Models\Process\MPOS\Cash\CashReconApproval;
use App\Models\Process\SAP\CardRecon;
use App\Models\Process\SAP\CardReconApproval;
use App\Models\Process\SAP\WalletRecon;
use App\Models\Process\SAP\WalletReconApproval;
use App\Services\GeneralService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class BankStatementProcessController extends Controller {



    protected $fileStoragePath;


    public function __construct() {
        $this->fileStoragePath = storage_path('app/public/reconciliation/cash_to_bank_statement-reconciliation');
    }

    /**
     * Get a random file name
     * @param string $originalFileName
     * @param string $extension
     * @return string
     */
    protected function fileName(string $originalFileName, string $extension) {
        return $originalFileName . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $extension;
    }



    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-head.process.bank-statement-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }


    /**
     * Cash mis bank statement approval process
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return JsonResponse|mixed
     */
    public function cashBankReconApproval(Request $request, string $id) {

        try {

            DB::beginTransaction();
            // creating a builder
            $builder = DB::table('MFL_Outward_CashMISBkStReco')
                ->where('cashMisBkStRecoUID', $id);



            // createing a sub builder for approval process
            $subBuiled = DB::table('MLF_Outward_CashMISBankStReco_ApprovalProcess')
                ->where('cashMisBkStRecoUID', $id);


            // updating the status manually
            $subBuiled->update([
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now()
            ]);

            // updating the main table
            $builder->update([
                'status' => $request->approvalStatus == 'approve' ? 'Matched' : 'Not Matched',
                'reconStatus' => $request->approvalStatus,
                'approvalRemarks' => $request->remarks
            ]);


            if ($request->approvalStatus != 'approve') {
                DB::commit();
                return response()->json(['message' => 'Success'], 200);
            }

            // getting the sales amount
            $cashSale = $builder->first();
            // Get records collection amount

            // get Adj amount from builder
            $adjustmentAmount = $cashSale->adjAmount;
            // sum the difference and adj amount 
            $reconDifference = $cashSale->creditAmount - ($cashSale->depositAmount + $adjustmentAmount);

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



    /**
     * Card to bank approval
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return JsonResponse|mixed
     */
    public function cardBankReconApproval(Request $request, string $id) {


        try {

            DB::beginTransaction();
            // creating a builder
            $builder = DB::table('MFL_Outward_CardMISBankStReco')
                ->where('cardMisBankStRecoUID', $id);



            // createing a sub builder for approval process
            $subBuiled = DB::table('MLF_Outward_CardMISBankStReco_ApprovalProcess')
                ->where('cardMisBkStRecoUID', $id);


            // dd($builder->get(), $subBuiled->get());
            // updating the status manually
            $subBuiled->update([
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now()
            ]);

            // updating the main table
            $builder->update([
                'status' => $request->approvalStatus == 'approve' ? 'Matched' : 'Not Matched',
                'reconStatus' => $request->approvalStatus,
                'approvalRemarks' => $request->remarks
            ]);


            if ($request->approvalStatus != 'approve') {
                DB::commit();
                return response()->json(['message' => 'Success'], 200);
            }

            // getting the sales amount
            $cashSale = $builder->first();
            // get Adj amount from builder
            $adjustmentAmount = floatval($cashSale->adjAmount);
            // sum the difference and adj amount 
            $reconDifference = floatval($cashSale->creditAmount) - (floatval($cashSale->depositAmount) + floatval($adjustmentAmount));

            $builder->update([
                'reconDifference' => $reconDifference ? floatval(number_format($reconDifference, 2, null, null)) : 0
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
        // main return
        return response()->json(['message' => 'Success'], 200);
    }




    public function walletBankReconApproval(Request $request, string $id) {


        try {

            DB::beginTransaction();
            // creating a builder
            $builder = DB::table('MFL_Outward_WalletMISBankStReco')
                ->where('walletMisBankStRecoUID', $id);

            // createing a sub builder for approval process
            $subBuiled = DB::table('MLF_Outward_WalletMISBankStReco_ApprovalProcess')
                ->where('walletMisBkStRecoUID', $id);

            // updating the status manually
            $subBuiled->update([
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
            ]);



            // updating the main table
            $builder->update([
                'status' => $request->approvalStatus == 'approve' ? 'Matched' : 'Not Matched',
                'reconStatus' => $request->approvalStatus,
                'approvalRemarks' => $request->remarks
            ]);


            if ($request->approvalStatus != 'approve') {
                DB::commit();
                return response()->json(['message' => 'Success'], 200);
            }

            // getting the sales amount
            $cashSale = $builder->first();

            $adjustmentAmount = floatval($cashSale->adjAmount);
            // sum the difference and adj amount 
            $reconDifference = floatval($cashSale->creditAmount) - (floatval($cashSale->depositAmount) + floatval($adjustmentAmount));

            $builder->update([
                'reconDifference' => $reconDifference ? floatval(number_format($reconDifference, 2, null, null)) : 0
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
        // main return
        return response()->json(['message' => 'Success'], 200);
    }





    /**
     * UPI to Bank statement reconciliation
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return JsonResponse|mixed
     */
    public function UPIBankReconApproval(Request $request, string $id) {


        try {

            DB::beginTransaction();
            // creating a builder
            $builder = DB::table('MFL_Outward_CardMISBankStReco')
                ->where('cardMisBankStRecoUID', $id);

            // createing a sub builder for approval process
            $subBuiled = DB::table('MLF_Outward_CardMISBankStReco_ApprovalProcess')
                ->where('cardMisBkStRecoUID', $id);

            // updating the status manually
            $subBuiled->update([
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now()
            ]);

            // updating the main table
            $builder->update([
                'status' => $request->approvalStatus == 'approve' ? 'Matched' : 'Not Matched',
                'reconStatus' => $request->approvalStatus,
                'approvalRemarks' => $request->remarks

            ]);


            if ($request->approvalStatus != 'approve') {
                DB::commit();
                return response()->json(['message' => 'Success'], 200);
            }

            // getting the sales amount
            $cashSale = $builder->first();

            $adjustmentAmount = floatval($cashSale->adjAmount);
            // sum the difference and adj amount 
            $reconDifference = floatval($cashSale->creditAmount) - (floatval($cashSale->depositAmount) + floatval($adjustmentAmount));

            $builder->update([
                'reconDifference' => $reconDifference ? floatval(number_format($reconDifference, 2, null, null)) : 0
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