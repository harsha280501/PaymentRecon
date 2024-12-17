<?php

namespace App\Http\Controllers\StoreUser\Process;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CashProcessController extends Controller {



    # file upload path
    protected $mposBankMisReconpath;



    public function __construct() {
        $this->mposBankMisReconpath = storage_path('app/public/reconciliation/mpos-reconciliation/store-mpos-bankmis');
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

            Log::channel('store-cashrecon')->info('Cash Adjustment Entry Begins', ['Record ID' => $id]);
            Log::channel('store-cashrecon')->info('Data Received: ', ['recon' => $request->all()]);
            DB::beginTransaction();
            
            # uploading the file
            $file = $request->file('supportDocupload');
            $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move(directory: $this->mposBankMisReconpath, name: $filename);

            # get the reconciliation data to update
            $_main = \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISReco::where(column: 'CashTenderBkDrpUID', operator: '=', value: $id)->first();
            $_main->update(['reconStatus' => 'Pending for Approval', 'processDt' => now()]);

            # approval process data
            $_approval = [
                ...$request->except(['adjAmount', 'tenderAdj', 'bankAdj']),
                'supportDocupload' => $filename,
                "approveStatus" => 'Pending',
                "recoMposDate" => $_main->expSaleDate,
                "recoStoreID" => $_main->storeID,
                "recoTenderAmount" => $_main->tenderAmount,
                "recoDepositAmount" => $_main->depositAmount,
                'createdDate' => now(),
                'createdBy' => auth()->user()->userUID
            ];
            
            # create the approval data
            Log::channel('store-cashrecon')->info('Approval Process: ', ['approvalProcess' => $_approval]);
            \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISRecoApproval::updateOrInsert($_approval);

            DB::commit();
            Log::channel('store-cashrecon')->info('Recon Approval Entry Successful');
            return response()->json(['message' => 'Success'], 200);

            // commit the transaction
        } catch (\Throwable $th) {
            Log::channel('store-cashrecon')->info('Failed, Something went wrong: ', ['Error' => $th->getMessage()]);
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}