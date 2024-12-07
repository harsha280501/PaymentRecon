<?php

namespace App\Http\Controllers\StoreUser\Process;

use App\Http\Controllers\Controller;

use App\Models\Process\SAP\CardRecon as SAPCardRecon;
use App\Models\Process\SAP\CardReconApproval as SAPCardReconApproval;
use App\Models\Process\SAP\WalletRecon as SAPWalletRecon;
use App\Models\Process\SAP\WalletReconApproval as SAPWalletReconApproval;

use App\Services\GeneralService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CardProcessController extends Controller {



    # file upload path
    protected $cardReconpath;



    public function __construct() {
        $this->cardReconpath = storage_path('app/public/reconciliation/card-reconciliation/store-card');
    }




    /**
     * Get Generated file name
     * @param string $originalFileName
     * @param string $extension
     * @return string
     */
    protected function fileName(string $originalFileName, string $extension) {
        return $originalFileName . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $extension;
    }






    public function __invoke(Request $request, string $id) {
        try {

            Log::channel('store-cardrecon')->info('Card Adjustment Entry Begins', ['Record ID' => $id]);
            Log::channel('store-cardrecon')->info('Data Received: ', ['recon' => $request->all()]);
            DB::beginTransaction();

            $file = $request->file('supportDocupload');
            $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($this->cardReconpath, $filename);

            $_main = SAPCardRecon::where('cardSalesRecoUID', $id)->first();
            $_main->update(['reconStatus' => 'Pending for Approval', 'processDt' => now()]);


            $_approval = [
                ...$request->except('adjAmount'),
                'supportDocupload' => $filename,
                "approveStatus" => 'pending',
                "recoSalesDate" => $_main->transactionDate,
                "recoStoreID" => $_main->storeID,
                "recoSalesAmount" => $_main->cardSale,
                "recoDepositAmount" => $_main->depositAmount,
                "recoColBank" => !$_main->collectionBank ? $_main->salesBank : $_main->collectionBank,
                "corrrectionDate" => now(),
                'createdDate' => now(),
                'createdBy' => auth()->user()->userUID
            ];
            
            Log::channel('store-cardrecon')->info('Approval Process: ', ['approvalProcess' => $_approval]);
            SAPCardReconApproval::updateOrInsert($_approval);
            DB::commit();
            Log::channel('store-cashrecon')->info('Recon Approval Entry Successful');
            return response()->json(['message' => 'Success'], 200);
        } catch (\Throwable $th) {

            Log::channel('store-cashrecon')->info('Failed, Something went wrong: ', ['Error' => $th->getMessage()]);
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

    }
}