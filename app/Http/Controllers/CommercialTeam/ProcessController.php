<?php

namespace App\Http\Controllers\CommercialTeam;

use App\Http\Controllers\Controller;
use App\Models\Process\SAP\CardRecon as SAPCardRecon;
use App\Models\Process\SAP\CardReconApproval as SAPCardReconApproval;
use App\Models\Process\SAP\WalletRecon as SAPWalletRecon;
use App\Models\Process\SAP\WalletReconApproval as SAPWalletReconApproval;
use App\Services\GeneralService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProcessController extends Controller {


    protected $mposBankMisReconpath;
    protected $cardReconpath;
    protected $walletReconpath;


    public function __construct() {
        $this->mposBankMisReconpath = storage_path('app/public/reconciliation/mpos-reconciliation/store-mpos-bankmis');
        $this->cardReconpath = storage_path('app/public/reconciliation/card-reconciliation/store-card');
        $this->walletReconpath = storage_path('app/public/reconciliation/wallet-reconciliation/store-wallet');
    }



    protected function fileName(string $originalFileName, string $extension) {
        return $originalFileName . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $extension;
    }


    /**
     * Index
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-team.process.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }





    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function cashRecon(): View {
        return view('app.commercial-team.process.mpos-recon', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }



    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function cardRecon(): View {
        return view('app.commercial-team.process.card-recon', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }


    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function upiRecon(): View {
        return view('app.commercial-team.process.upi-recon', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }


    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function walletRecon(): View {
        return view('app.commercial-team.process.wallet-recon', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }




    /**
     * MPOS Reconciliation Process
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function MposMisApproval(Request $request, string $id) {

        try {

            DB::beginTransaction();

            // uploading the file
            $file = $request->file('supportDocupload');
            $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($this->mposBankMisReconpath, $filename);
            $_main = \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISReco::where('CashTenderBkDrpUID', $id)->first();

            \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISRecoApproval::insert([
                ...$request->except(['adjAmount', 'bankAdj', 'tenderAdj']),
                'supportDocupload' => $filename,
                "approveStatus" => 'pending',
                "recoMposDate" => $_main->mposDate,
                "recoStoreID" => $_main->storeID,
                "recoTenderAmount" => $_main->tenderAmount,
                "recoDepositAmount" => $_main->depositAmount,
                "createdDate" => now()
            ]);


            $_main->update([
                'processDt' => now()->format('Y-m-d h:i:s'),
                "reconStatus" => "Pending for Partial Approval",
            ]);

            DB::commit();
            return response()->json(['message' => 'Success'], 200);

            // commit the transaction
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }




    public function CardMisApproval(Request $request, string $id) {

        try {
            DB::beginTransaction();
            // only do this when you have a document

            $file = $request->file('supportDocupload');
            $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($this->cardReconpath, $filename);
            $_main = SAPCardRecon::where('cardSalesRecoUID', $id)->first();

            SAPCardReconApproval::updateOrInsert([
                ...$request->except('adjAmount'),
                'supportDocupload' => $filename,
                "approveStatus" => 'pending',
                "recoSalesDate" => $_main->transactionDate,
                "recoStoreID" => $_main->storeID,
                "recoSalesAmount" => $_main->cardSale,
                "recoDepositAmount" => $_main->depositAmount,
                "corrrectionDate" => now(),
                "createdDate" => now()

            ]);

            $_main->update([
                'processDt' => now()->format('Y-m-d h:i:s'),
                "reconStatus" => "Pending for Partial Approval",
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

        return response()->json(['message' => 'Success'], 200);
    }



    public function UpiMisApproval(Request $request, string $id) {


        try {
            DB::beginTransaction();
            // only do this when you have a document

            $file = $request->file('supportDocupload');
            $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($this->cardReconpath, $filename);
            $_main = SAPCardRecon::where('cardSalesRecoUID', $id)->first();

            SAPCardReconApproval::updateOrInsert([
                ...$request->except('adjAmount'),
                'supportDocupload' => $filename,
                "approveStatus" => 'pending',
                "recoSalesDate" => $_main->transactionDate,
                "recoStoreID" => $_main->storeID,
                "recoSalesAmount" => $_main->cardSale,
                "recoDepositAmount" => $_main->depositAmount,
                "corrrectionDate" => now(),
                "createdDate" => now()

            ]);

            $_main->update([
                'processDt' => now()->format('Y-m-d h:i:s'),
                "reconStatus" => "Pending for Partial Approval",
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

        return response()->json(['message' => 'Success'], 200);
    }




    public function WalletMisApproval(Request $request, string $id) {

        try {

            DB::beginTransaction();

            $file = $request->file('supportDocupload');
            $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($this->walletReconpath, $filename);
            $_main = SAPWalletRecon::where('walletSalesRecoUID', $id)->first();

            SAPWalletReconApproval::updateOrInsert([
                ...$request->except('adjAmount'),
                'supportDocupload' => $filename,
                "approveStatus" => 'pending',
                "recoSalesDate" => $_main->transactionDate,
                "recoStoreID" => $_main->storeID,
                "recoSalesAmount" => $_main->cardSale,
                "recoDepositAmount" => $_main->depositAmount,
                "corrrectionDate" => now(),
                "createdDate" => now()
            ]);

            $_main->update([
                'processDt' => now()->format('Y-m-d h:i:s'),
                "reconStatus" => "Pending for Partial Approval",
            ]);

            DB::commit();

            return response()->json(['message' => 'Success'], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }


    }
}
