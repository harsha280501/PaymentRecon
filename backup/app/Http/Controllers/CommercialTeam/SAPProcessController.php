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

class SAPProcessController extends Controller {




    protected $cardReconpath;
    protected $walletReconpath;



    public function __construct() {
        $this->cardReconpath = storage_path('app/public/reconciliation/card-reconciliation/store-card');
        $this->walletReconpath = storage_path('app/public/reconciliation/wallet-reconciliation/store-wallet');
    }

    /**
     * Index
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-team.process.sap-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
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





    public function SAPReconUpload(Request $request, string $id) {

        try {
            DB::beginTransaction();
            // only do this when you have a document
            if ($request->hasFile('supportDocupload')) {

                $file = $request->file('supportDocupload');
                $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
                $file->move($this->cardReconpath, $filename);

                SAPCardRecon::where('cardSalesRecoUID', $id)->update(['reconStatus' => 'Pending for Approval', 'adjAmount' => $request->adjAmount,
                    'createdBy' => auth()->user()->userUID, 'processDt' => now()->format('Y-m-d')]);

                SAPCardReconApproval::updateOrInsert([...$request->except('adjAmount'), 'supportDocupload' => $filename]);
                DB::commit();

                return response()->json(['message' => 'Success'], 200);
            }

            SAPCardRecon::where('cardSalesRecoUID', $id)->update(['reconStatus' => 'Pending for Approval', 'adjAmount' => $request->adjAmount,
                'createdBy' => auth()->user()->userUID, 'processDt' => now()->format('Y-m-d')]);

            SAPCardReconApproval::updateOrInsert([...$request->except(['adjAmount']), 'supportDocupload' => '']);
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

        return response()->json(['message' => 'Success'], 200);
    }



    public function SAPWalletReconUpload(Request $request, string $id) {

        try {

            DB::beginTransaction();
            // only do this when you have a document
            if ($request->hasFile('supportDocupload')) {

                $file = $request->file('supportDocupload');
                $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
                $file->move($this->walletReconpath, $filename);

                SAPWalletRecon::where('walletSalesRecoUID', $id)->update([
                    'reconStatus' => 'Pending for Approval',
                    'adjAmount' => $request->adjAmount,
                    'createdBy' => auth()->user()->userUID,
                    'processDt' => now()->format('Y-m-d')
                ]);
                SAPWalletReconApproval::updateOrInsert([...$request->except('adjAmount'), 'supportDocupload' => $filename]);
                DB::commit();

                return response()->json(['message' => 'Success'], 200);
            }

            SAPWalletRecon::where('walletSalesRecoUID', $id)->update([
                'reconStatus' => 'Pending for Approval',
                'adjAmount' => $request->adjAmount,
                'createdBy' => auth()->user()->userUID,
                'processDt' => now()->format('Y-m-d')
            ]);

            SAPWalletReconApproval::updateOrInsert([...$request->except('adjAmount'), 'supportDocupload' => '']);
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

        return response()->json(['message' => 'Success'], 200);
    }
}
