<?php

namespace App\Http\Controllers\CommercialTeam;

use App\Http\Controllers\Controller;
use App\Models\BankStatements\Approval\CardMISBankStatementApprovalProcess;
use App\Models\BankStatements\Approval\CashMISBankStatementApprovalProcess;
use App\Models\BankStatements\Approval\WalletMISBankStatementApprovalProcess;
use App\Models\BankStatements\CardMISBankStatement;
use App\Models\BankStatements\CashMISBankStatement;
use App\Models\BankStatements\WalletMISBankStatement;
use App\Services\GeneralService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BankStatementProcessController extends Controller {



    protected $cashStoragePath;
    protected $cardStoragePath;
    protected $walletStoragePath;
    protected $UPIStoragePath;


    public function __construct() {
        $this->cashStoragePath = storage_path('app/public/reconciliation/cash-reconciliation/cash-bank');
        $this->cardStoragePath = storage_path('app/public/reconciliation/card-reconciliation/card-bank');
        $this->walletStoragePath = storage_path('app/public/reconciliation/wallet-reconciliation/wallet-bank');
        $this->UPIStoragePath = storage_path('app/public/reconciliation/upi-reconciliation/upi-bank');
    }


    /**
     * Index
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-team.process.bank-statement-recon', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    /**
     * Generate a file name
     * @param string $originalFileName
     * @param string $extension
     * @return string
     */
    protected function fileName(string $originalFileName, string $extension) {
        return $originalFileName . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $extension;
    }




    /**
     * UPload cash to Bank recon process
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function cashReconUpload(Request $request, string $id) {

        try {

            DB::beginTransaction();

            if ($request->hasFile('supportDocupload')) {


                // uploading the file
                $file = $request->file('supportDocupload');
                $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
                $file->move($this->cashStoragePath, $filename);

                CashMISBankStatement::where('cashMisBkStRecoUID', $id)->update([
                    'reconStatus' => 'Pending for Approval',
                    'adjAmount' => $request->adjAmount,
                    'processDt' => now()->format('Y-m-d')
                ]);

                CashMISBankStatementApprovalProcess::insert([...$request->except('adjAmount'), 'supportDocupload' => $filename]);
                DB::commit();

                return response()->json(['message' => 'Success'], 200);
            }

            CashMISBankStatement::where('cashMisBkStRecoUID', $id)->update([
                'reconStatus' => 'Pending for Approval',
                'adjAmount' => $request->amount,
                'processDt' => now()->format('Y-m-d')
            ]);

            CashMISBankStatementApprovalProcess::insert([...$request->except('adjAmount'), 'supportDocupload' => '']);
            DB::commit();
            // commit the transaction
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
        // return the main transaction
        return response()->json(['message' => 'Success'], 200);
    }




    /**
     * Upload Card recon
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function cardReconUpload(Request $request, string $id) {

        try {

            DB::beginTransaction();

            if ($request->hasFile('supportDocupload')) {
                // uploading the file
                $file = $request->file('supportDocupload');
                $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
                $file->move($this->cardStoragePath, $filename);

                // updating base table
                CardMISBankStatement::where('cardMisBankStRecoUID', $id)->update([
                    'reconStatus' => 'Pending for Approval',
                    'adjAmount' => $request->adjAmount, // added
                    'processDt' => now()->format('Y-m-d')
                ]);

                // creaating records 
                CardMISBankStatementApprovalProcess::updateOrInsert([...$request->except('adjAmount'), 'supportDocupload' => $filename]);
                DB::commit();

                // main Response when file is sent
                return response()->json(['message' => 'Success'], 200);
            }


            // updating base table
            CardMISBankStatement::where('cardMisBankStRecoUID', $id)->update([
                'reconStatus' => 'Pending for Approval',
                'adjAmount' => $request->adjAmount, // added
                'processDt' => now()->format('Y-m-d')
            ]);


            // creaating records 
            CardMISBankStatementApprovalProcess::updateOrInsert([...$request->except('adjAmount'), 'supportDocupload' => '']);
            DB::commit();


        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

        return response()->json(['message' => 'Success'], 200);
    }



    /**
     * Uploading Wallet process
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function walletReconUpload(Request $request, string $id) {

        try {

            DB::beginTransaction();


            if ($request->hasFile('supportDocupload')) {
                // uploading the file
                $file = $request->file('supportDocupload');
                $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
                $file->move($this->walletStoragePath, $filename);

                // updating base table
                WalletMISBankStatement::where('walletMisBankStRecoUID', $id)->update([
                    'reconStatus' => 'Pending for Approval',
                    'adjAmount' => $request->adjAmount,
                    'processDt' => now()->format('Y-m-d')
                ]);

                // creaating records 
                WalletMISBankStatementApprovalProcess::updateOrInsert([...$request->except('adjAmount'), 'supportDocupload' => $filename]);
                DB::commit();

                // main Response when file is sent
                return response()->json(['message' => 'Success'], 200);
            }


            // updating base table
            WalletMISBankStatement::where('walletMisBankStRecoUID', $id)->update([
                'reconStatus' => 'Pending for Approval',
                'adjAmount' => $request->adjAmount,
                'processDt' => now()->format('Y-m-d')
            ]);

            WalletMISBankStatementApprovalProcess::updateOrInsert([...$request->except('adjAmount'), 'supportDocupload' => '']);
            DB::commit();

            // commit the transaction
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
        // return the main transaction
        return response()->json(['message' => 'Success'], 200);
    }



    /**
     *  UPI PRcesss
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function UPIReconUpload(Request $request, string $id) {

        try {

            DB::beginTransaction();

            if ($request->hasFile('supportDocupload')) {
                // uploading the file
                $file = $request->file('supportDocupload');
                $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
                $file->move($this->UPIStoragePath, $filename);

                // updating base table
                CardMISBankStatement::where('cardMisBankStRecoUID', $id)->update([
                    'reconStatus' => 'Pending for Approval',
                    'adjAmount' => $request->adjAmount,
                    'processDt' => now()->format('Y-m-d')
                ]);

                // creaating records 
                CardMISBankStatementApprovalProcess::updateOrInsert([...$request->except('adjAmount'), 'supportDocupload' => $filename]);
                DB::commit();

                // main Response when file is sent
                return response()->json(['message' => 'Success'], 200);
            }

            // updating base table
            CardMISBankStatement::where('cardMisBankStRecoUID', $id)->update([
                'reconStatus' => 'Pending for Approval',
                'adjAmount' => $request->adjAmount,
                'processDt' => now()->format('Y-m-d')
            ]);

            // creaating records 
            CardMISBankStatementApprovalProcess::updateOrInsert([...$request->except('adjAmount'), 'supportDocupload' => '']);
            DB::commit();
            // commit the transaction
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
        // return the main transaction
        return response()->json(['message' => 'Success'], 200);
    }
}
