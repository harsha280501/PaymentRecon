<?php

namespace App\Http\Controllers\CommercialHead;

use App\Http\Controllers\Controller;
use App\Models\Process\AllTenderReco;
use App\Models\Process\MPOS\Cash\CashBankRecon;
use App\Models\Process\MPOS\Cash\CashBankReconApproval;
use App\Models\Process\MPOS\Cash\CashRecon;
use App\Models\Process\MPOS\Cash\CashReconApproval;
use App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISReco;
use App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISRecoApproval;
use App\Models\Process\SAP\CardRecon;
use App\Models\Process\SAP\CardReconApproval;
use App\Models\Process\SAP\WalletRecon;
use App\Models\Process\SAP\WalletReconApproval;
use App\Services\GeneralService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;


class ProcessController extends Controller {



    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-head.process.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }



    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function MPOSRecon(): View {
        return view('app.commercial-head.process.mpos-recon-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }


    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function CardRecon(): View {
        return view('app.commercial-head.process.card-recon-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }


    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function UPIRecon(): View {
        return view('app.commercial-head.process.upi-recon-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }


    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function WalletRecon(): View {
        return view('app.commercial-head.process.wallet-recon-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }







    public function MPOSMainReconApproval(Request $request, string $id) {

        try {

            
            Log::channel('store-cashrecon')->info('Commercial Head Approval Recon Process: ', ['Item' => $id]);
            Log::channel('store-cashrecon')->info('Data Recieved: ', ['Data' => $request->all()]);

            DB::beginTransaction();
            // creating a builder
            $builder = MPOSCashTenderBankDropCashMISReco::where('CashTenderBkDrpUID', $id);
            


            // createing a sub builder for approval process
            $_records = MPOSCashTenderBankDropCashMISRecoApproval::where('CashTenderBkDrpUID', $id)
                ->where('approveStatus', '!=', 'Rejected');

            $records = MPOSCashTenderBankDropCashMISRecoApproval::where('CashTenderBkDrpUID', $id)
                ->where('approveStatus', 'Pending');


            $updatedRecords = [
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'modifiedDate' => now(),
                'cheadRemarks' => $request->remarks
            ];

            // updating the status manually
            $records->update($updatedRecords);
            Log::channel('store-cashrecon')->info('Reconciliation Entry Updation: ', ['Item' => $updatedRecords]);


            // if the approval status is rejected 
            if ($request->approvalStatus != 'Approved') {
                $builder->update([
                    "reconStatus" => "Rejected"
                ]);

                DB::commit();
                Log::channel('store-cashrecon')->info('Reconciliation Entry Rejected: ', ['reconStatus' => 'Rejected']);
                return response()->json(['message' => 'Success'], 200);
            }


            // getting the totals from the records
            $reconItem = $builder->first();
            $storeID = $reconItem->storeID;
            $creditDate = $reconItem->mposDate;
            $expSaleDate = !$creditDate ? $reconItem->expSaleDate : $creditDate;
            
            // $expSalesDate = !$creditDate ?  : $creditDate; # added

            $summedAdjustment = $_records->sum('amount');

            Log::channel('store-cashrecon')->info('Reconciliation Entry Approved: ', ['reconStatus' => 'Partial Entry Started']);

            $isDifferenceMatchedSummedAdjustment = (($reconItem->bankCashDifference - $summedAdjustment >= -100) && ($reconItem->bankCashDifference - $summedAdjustment <= 100));

 
            // updating the main table
            if ($isDifferenceMatchedSummedAdjustment == true) {

                Log::channel('store-cashrecon')->info('Reconciliation Entry Approved: ', ['reconStatus' => 'Partai Matched - Store Entry Created']);

                $matchedEntries = [
                    'cashMISStatus' => 'Matched',
                    'adjAmount' => $summedAdjustment,
                    'reconStatus' => "Approved",
                    'approvalRemarks' => $request->remarks
                ];
                // updating the main column
                $builder->update($matchedEntries);

                Log::channel('store-cashrecon')->info('Reconciliation Entry Approved: ', ['reconStatus' => $matchedEntries]);
                // update all tender
                AllTenderReco::where('storeID', $storeID)->where('salesDate', $expSaleDate)->update(['adjustmentCashTotal' => $summedAdjustment]);


                Log::channel('store-cashrecon')->info('Updating AllTender Reconcilation for this Specific entry:');
            } else {

                Log::channel('store-cashrecon')->info('Reconciliation Entry Approved');
                $builder->update([
                    "reconStatus" => "Pending"
                ]);
            }

            DB::commit();
            Log::channel('store-cashrecon')->info('Reconciliation Entry Successful');
            return response()->json(['message' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('store-cashrecon')->info('Something Went Wrong', ['Error', $th->getMessage()]);
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }






    public function cardReconApproval(Request $request, string $id) {
        try {
            DB::beginTransaction();
            Log::channel('store-cardrecon')->info('Commercial Head Approval Recon Process: ', ['Item' => $id]);
            Log::channel('store-cardrecon')->info('Data Recieved: ', ['Data' => $request->all()]);


            // creating a builder
            $builder = CardRecon::where('cardSalesRecoUID', $id);

            // createing a sub builder for approval process
            $_records = CardReconApproval::where('cardSalesRecoUID', $id)
                ->where('approveStatus', '!=', 'Rejected');

            $records = CardReconApproval::where('cardSalesRecoUID', $id)
                ->where('approveStatus', '!=', 'Rejected')
                ->where('approveStatus', 'Pending');


            // updating the records which are common
            $records->update([
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'modifiedDate' => now(),
                'cheadRemarks' => $request->remarks
            ]);

            Log::channel('store-cardrecon')->info('Reconciliation Entry Updation: ', ['Item' => [
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'modifiedDate' => now(),
                'cheadRemarks' => $request->remarks
            ]]);


            // if the approval status is rejected 
            if ($request->approvalStatus != 'Approved') {
                
                $builder->update([
                    "reconStatus" => "Rejected"
                ]);

                DB::commit();
                Log::channel('store-cardrecon')->info('Reconciliation Entry Rejected: ', ['reconStatus' => 'Rejected']);
                return response()->json(['message' => 'Success'], 200);
            }

            // getting the totals from the records
            $reconItem = $builder->first();
            $storeID = $reconItem->storeID;
            $creditDate = $reconItem->transactionDate;

            $summedAdjustment = $_records->sum('saleAmount');
            // $isDifferenceMatchedSummedAdjustment = $reconItem->diffSaleDeposit == $summedAdjustment;
            Log::channel('store-cardrecon')->info('Reconciliation Entry Approved: ', ['reconStatus' => 'Partial Entry Started']);
            $isDifferenceMatchedSummedAdjustment = (($reconItem->diffSaleDeposit - $summedAdjustment >= -100) && ($reconItem->diffSaleDeposit - $summedAdjustment <= 100));

            // updating the main table
            if ($isDifferenceMatchedSummedAdjustment == true) {
                Log::channel('store-cardrecon')->info('Reconciliation Entry Approved: ', ['reconStatus' => 'Partai Matched - Store Entry Created']);
                // updating the main column
                $builder->update([
                    'status' => 'Matched',
                    'adjAmount' => $summedAdjustment,
                    'approvedBy' => auth()->user()->userUID,
                    'approvedDate' => now()->format('d-m-Y'),
                    'reconStatus' => "Approved",
                    'approvalRemarks' => $request->remarks
                ]);
                Log::channel('store-cardrecon')->info('Updating AllTender Reconcilation for this Specific entry:');
                // DB::statement('RECON_ALLTENDER_Reconciliation_UPDATE_FROMRECO_TABLES_Recalcualte_Difference :store, :date', [
                //     'store' => $storeID,
                //     'date' => $creditDate
                // ]);  

                AllTenderReco::where('storeID', $storeID)->where('salesDate', $creditDate)->update(['adjustmentCardTotal' => $summedAdjustment]);


            } else {
                $builder->update([
                    "reconStatus" => "Pending"
                ]);
            }
            Log::channel('store-cardrecon')->info('Reconciliation Entry Successful');
            DB::commit();
            return response()->json(['message' => 'Success'], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('store-cardrecon')->info('Something Went Wrong', ['Error', $th->getMessage()]);
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }




    public function upiReconApproval(Request $request, string $id) {
        try {
            DB::beginTransaction();
            Log::channel('store-upirecon')->info('Commercial Head Approval Recon Process: ', ['Item' => $id]);
            Log::channel('store-upirecon')->info('Data Recieved: ', ['Data' => $request->all()]);

            // creating a builder
            $builder = CardRecon::where('cardSalesRecoUID', $id);

            // createing a sub builder for approval process
            $_records = CardReconApproval::where('cardSalesRecoUID', $id)
                ->where('approveStatus', '!=', 'Rejected');

            $records = CardReconApproval::where('cardSalesRecoUID', $id)
                ->where('approveStatus', '!=', 'Rejected')
                ->where('approveStatus', 'Pending');


            // updating the records which are common
            $records->update([
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'modifiedDate' => now(),
                'cheadRemarks' => $request->remarks
            ]);

            Log::channel('store-upirecon')->info('Reconciliation Entry Updation: ', ['Item' => [
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'modifiedDate' => now(),
                'cheadRemarks' => $request->remarks
            ]]);

            // if the approval status is rejected 
            if ($request->approvalStatus != 'Approved') {
                $builder->update([
                    "reconStatus" => "Rejected"
                ]);
                Log::channel('store-upirecon')->info('Reconciliation Entry Rejected: ', ['reconStatus' => 'Rejected']);
                DB::commit();
                return response()->json(['message' => 'Success'], 200);
            }

            // getting the totals from the records
            $reconItem = $builder->first();
            $storeID = $reconItem->storeID;
            $creditDate = $reconItem->transactionDate;

            $summedAdjustment = $_records->sum('saleAmount');
            // $isDifferenceMatchedSummedAdjustment = $reconItem->diffSaleDeposit == $summedAdjustment;
            Log::channel('store-upirecon')->info('Reconciliation Entry Approved: ', ['reconStatus' => 'Partial Entry Started']);
            $isDifferenceMatchedSummedAdjustment = (($reconItem->diffSaleDeposit - $summedAdjustment >= -100) && ($reconItem->diffSaleDeposit - $summedAdjustment <= 100));

            // updating the main table
            if ($isDifferenceMatchedSummedAdjustment == true) {
                Log::channel('store-upirecon')->info('Reconciliation Entry Approved: ', ['reconStatus' => 'Partai Matched - Store Entry Created']);
                // updating the main column
                $builder->update([
                    'status' => 'Matched',
                    'adjAmount' => $summedAdjustment,
                    'approvedBy' => auth()->user()->userUID,
                    'approvedDate' => now()->format('d-m-Y'),
                    'reconStatus' => "Approved",
                    'approvalRemarks' => $request->remarks
                ]);
                Log::channel('store-upirecon')->info('Updating AllTender Reconcilation for this Specific entry:');
                // DB::statement('RECON_ALLTENDER_Reconciliation_UPDATE_FROMRECO_TABLES_Recalcualte_Difference :store, :date', [
                //     'store' => $storeID,
                //     'date' => $creditDate
                // ]);
                AllTenderReco::where('storeID', $storeID)->where('salesDate', $creditDate)->update(['adjustmentUPI' => $summedAdjustment]);

            } else {
                $builder->update([
                    "reconStatus" => "Pending"
                ]);
            }
            Log::channel('store-upirecon')->info('Reconciliation Entry Successful');
            DB::commit();
            return response()->json(['message' => 'Success'], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('store-upirecon')->info('Something Went Wrong', ['Error', $th->getMessage()]);
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }






    public function walletReconApproval(Request $request, string $id) {

        try {
            Log::channel('store-walletrecon')->info('Commercial Head Approval Recon Process: ', ['Item' => $id]);
            Log::channel('store-walletrecon')->info('Data Recieved: ', ['Data' => $request->all()]);

            DB::beginTransaction();



            // creating a builder
            $builder = WalletRecon::where('walletSalesRecoUID', $id);

            // createing a sub builder for approval process
            $_records = WalletReconApproval::where('walletSalesRecoUID', $id)
                ->where('approveStatus', '!=', 'Rejected');

            $records = WalletReconApproval::where('walletSalesRecoUID', $id)
                ->where('approveStatus', '!=', 'Rejected')
                ->where('approveStatus', 'Pending');


            // updating the status manually
            $records->update([
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'modifiedDate' => now(),
                'cheadRemarks' => $request->remarks
            ]);


            Log::channel('store-walletrecon')->info('Reconciliation Entry Updation: ', ['Item' => [
                'approveStatus' => $request->approvalStatus,
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'modifiedDate' => now(),
                'cheadRemarks' => $request->remarks
            ]]);

            // if the approval status is rejected 
            if ($request->approvalStatus != 'Approved') {
                $builder->update([
                    "reconStatus" => "Rejected"
                ]);
                Log::channel('store-walletrecon')->info('Reconciliation Entry Rejected: ', ['reconStatus' => 'Rejected']);
                DB::commit();
                return response()->json(['message' => 'Success'], 200);
            }

            // getting the totals from the records
            $reconItem = $builder->first();
            $storeID = $reconItem->storeID;
            $creditDate = $reconItem->transactionDate;

            $summedAdjustment = $_records->sum('saleAmount');
            // $isDifferenceMatchedSummedAdjustment = $reconItem->diffSaleDeposit == $summedAdjustment;
            Log::channel('store-walletrecon')->info('Reconciliation Entry Approved: ', ['reconStatus' => 'Partial Entry Started']);
            $isDifferenceMatchedSummedAdjustment = (($reconItem->diffSaleDeposit - $summedAdjustment >= -100) && ($reconItem->diffSaleDeposit - $summedAdjustment <= 100));

            // updating the main table
            if ($isDifferenceMatchedSummedAdjustment == true) {
                // updating the main column
                Log::channel('store-walletrecon')->info('Reconciliation Entry Approved: ', ['reconStatus' => 'Partai Matched - Store Entry Created']);
                $builder->update([
                    'status' => 'Matched',
                    'adjAmount' => $summedAdjustment,
                    'approvedBy' => auth()->user()->userUID,
                    'approvedDate' => now()->format('d-m-Y'),
                    'reconStatus' => "Approved",
                    'approvalRemarks' => $request->remarks
                ]);
                Log::channel('store-walletrecon')->info('Updating AllTender Reconcilation for this Specific entry:');
                
                // DB::statement('RECON_ALLTENDER_Reconciliation_UPDATE_FROMRECO_TABLES_Recalcualte_Difference :store, :date', [
                //     'store' => $storeID,
                //     'date' => $creditDate
                // ]);

                AllTenderReco::where('storeID', $storeID)->where('salesDate', $creditDate)->update(['adjustmentWallet' => $summedAdjustment]);

            } else {
                $builder->update([
                    "reconStatus" => "Pending"
                ]);
            }
            Log::channel('store-walletrecon')->info('Reconciliation Entry Successful');
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('store-walletrecon')->info('Something Went Wrong', ['Error', $th->getMessage()]);
            return response()->json(['message' => $th->getMessage()], 500);
        }
        return response()->json(['message' => 'Success'], 200);
    }




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
                'approvalRemarks' => $request->remarks,
                'status' => $request->approvalStatus == 'approve' ? 'Matched' : 'Not Matched',
                'reconStatus' => $request->approvalStatus
            ]);


            if ($request->approvalStatus != 'approve') {
                DB::commit();
                return response()->json(['message' => 'Success'], 200);
            }


            // getting the sales amount
            $cashSale = $builder->first();


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
     * UPI Reconciliation
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
                'approvalDate' => now(),
                'modifiedDate' => now(),
                'cheadRemarks' => $request->remarks
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

}