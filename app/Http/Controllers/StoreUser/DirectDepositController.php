<?php

namespace App\Http\Controllers\StoreUser;

use App\Http\Controllers\Controller;
use App\Models\Masters\DirectDeposit;
use App\Models\Process\SAP\CardRecon as SAPCardRecon;
use App\Models\Process\SAP\CardReconApproval as SAPCardReconApproval;
use App\Models\Process\SAP\WalletRecon as SAPWalletRecon;
use App\Models\Process\SAP\WalletReconApproval as SAPWalletReconApproval;
use App\Models\Store;
use App\Services\GeneralService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DirectDepositController extends Controller {




    /**
     * get the filename dynamically
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
        return view('app.storeUser.direct-deposit.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }


    public function create(Request $request) {
        Log::channel('direct-deposit')->info('Direct deposit creation process started', [
            'request_data' => $request->all()
        ]);

        try {
            DB::beginTransaction();

            // Check for duplicate entries
            $item = DirectDeposit::where('depositSlipNo', $request->depositSlipNo)
                ->where('amount', $request->amount)
                ->where('directDepositDate', $request->directDepositDate)
                ->where('bank', $request->bank)
                ->where('accountNo', $request->accountNo)
                ->where('storeID', auth()->user()->storeUID)
                ->exists();

            if ($item) {
                DB::rollBack();
                Log::channel('direct-deposit')->warning('Duplicate entry found', [
                    'depositSlipNo' => $request->depositSlipNo,
                    'amount' => $request->amount,
                    'directDepositDate' => $request->directDepositDate,
                    'bank' => $request->bank,
                    'accountNo' => $request->accountNo,
                ]);
                return response()->json(['message' => 'Duplicate Entry Found'], 500);
            }

            // Uploading the file
            $file = $request->file('depositSlipProof');
            $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move(storage_path('app/public/direct-deposit'), $filename);
            Log::channel('direct-deposit')->info('File uploaded successfully', ['filename' => $filename]);

            // Inserting data into the database
            DirectDeposit::insert([
                ...$request->except(['depositSlipProof', 'salesDateTo']),
                'storeID' => auth()->user()->store()['storeUID'],
                'retekCode' => auth()->user()->store()['SAP'],
                'status' => 'Pending for Approval',
                'depositSlipProof' => $filename,
                'createdDate' => now()->format('Y-m-d'),
                'createdBy' => Auth::user()->userUID,
                'salesTender' => $request->salesTender,
            ]);

            DB::commit();
            Log::channel('direct-deposit')->info('Direct deposit created successfully', [
                'storeID' => auth()->user()->storeUID,
                'depositSlipNo' => $request->depositSlipNo,
            ]);

            return response()->json(['message' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('direct-deposit')->error('Error occurred while creating direct deposit', [
                'error' => $th->getMessage(),
                'request_data' => $request->all()
            ]);
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

}
