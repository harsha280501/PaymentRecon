<?php

namespace App\Http\Controllers\StoreUser;

use App\Http\Controllers\Controller;
use App\Models\Process\MPOS\Card\CardRecon;
use App\Models\Process\MPOS\Card\CardReconApproval;
use App\Models\Process\MPOS\Wallet\WalletRecon;
use App\Models\Process\MPOS\Wallet\WalletReconApproval;
use App\Services\GeneralService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class MPOSProcessController extends Controller {



    protected $cashReconpath;
    protected $cardReconpath;
    protected $walletReconpath;
    protected $cardMPOSStoragePath;
    protected $walletMPOSStoragePath;


    public function __construct() {
        $this->cashReconpath = storage_path('app/public/reconciliation/cash-reconciliation/store-cash');
        $this->cardReconpath = storage_path('app/public/reconciliation/card-reconciliation/store-card');
        $this->walletReconpath = storage_path('app/public/reconciliation/wallet-reconciliation/store-wallet');
        $this->cardMPOSStoragePath = storage_path('app/public/reconciliation/card-reconciliation/MPOS/card-bank');
        $this->walletMPOSStoragePath = storage_path('app/public/reconciliation/card-reconciliation/MPOS/wallet-bank');
    }





    protected function fileName(string $originalFileName, string $extension) {
        return $originalFileName . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $extension;
    }



    public function cardReconUpload(Request $request, string $id) {

        try {

            DB::beginTransaction();

            $userId = Auth::id();

            if ($request->hasFile('supportDocupload')) {
                // uploading the file
                $file = $request->file('supportDocupload');
                $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
                $file->move($this->cardMPOSStoragePath, $filename);

                // updating base table
                CardRecon::where('mposCardSalesRecoUID', $id)->update([
                    'reconStatus' => 'Pending for Approval',
                    'adjustmentAmount' => $request->adjAmount // added
                ]);

                // creaating records 

                $data = array(
                    'mposCardSalesRecoUID' => $id,
                    'item' => $request->item,
                    'bankName' => $request->bankName,
                    "creditDate" => $request->creditDate,
                    "slipnoORReferenceNo" => $request->slipnoORReferenceNo,
                    "amount" => $request->amount,
                    "supportDocupload" => $filename,
                    "remarks" => $request->remarks,
                    "createdBy" => $userId
                );

                CardReconApproval::updateOrInsert($data);
                DB::commit();

                // main Response when file is sent
                return response()->json(['message' => 'Success'], 200);
            }


            // updating base table

            $data = array(
                'mposCardSalesRecoUID' => $id,
                'item' => $request->item,
                'bankName' => $request->bankName,
                "creditDate" => $request->creditDate,
                "slipnoORReferenceNo" => $request->slipnoORReferenceNo,
                "amount" => $request->amount,
                "remarks" => $request->remarks,
                "createdBy" => $userId
            );

            CardRecon::where('mposCardSalesRecoUID', $id)->update([
                'reconStatus' => 'Pending for Approval',
                'adjustmentAmount' => $request->adjAmount // added
            ]);

            // creaating records

            CardReconApproval::updateOrInsert($data);
            DB::commit();


        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th], 500);
        }

        return response()->json(['message' => 'Success'], 200);

    }



    public function walletReconUpload(Request $request, string $id) {

        try {

            DB::beginTransaction();

            $userId = Auth::id();

            if ($request->hasFile('supportDocupload')) {
                // uploading the file
                $file = $request->file('supportDocupload');
                $filename = $this->fileName($file->getClientOriginalName(), $file->getClientOriginalExtension());
                $file->move($this->walletMPOSStoragePath, $filename);

                // updating base table
                WalletRecon::where('mposWalletSalesRecoUID', $id)->update([
                    'reconStatus' => 'Pending for Approval',
                    'adjustmentAmount' => $request->adjAmount // added
                ]);

                // creaating records 
                $data = array(
                    'mposWalletSalesRecoUID' => $id,
                    'item' => $request->item,
                    'bankName' => $request->bankName,
                    "creditDate" => $request->creditDate,
                    "slipnoORReferenceNo" => $request->slipnoORReferenceNo,
                    "amount" => $request->amount,
                    "supportDocupload" => $filename,
                    "remarks" => $request->remarks,
                    "createdBy" => $userId
                );
                WalletReconApproval::updateOrInsert($data);
                DB::commit();

                // main Response when file is sent
                return response()->json(['message' => 'Success'], 200);
            }


            // updating base table
            WalletRecon::where('mposWalletSalesRecoUID', $id)->update([
                'reconStatus' => 'Pending for Approval',
                'adjustmentAmount' => $request->adjAmount // added
            ]);


            $data = array(
                'mposWalletSalesRecoUID' => $id,
                'item' => $request->item,
                'bankName' => $request->bankName,
                "creditDate" => $request->creditDate,
                "slipnoORReferenceNo" => $request->slipnoORReferenceNo,
                "amount" => $request->amount,
                "remarks" => $request->remarks,
                "createdBy" => $userId
            );


            // creaating records             
            WalletReconApproval::updateOrInsert($data);
            DB::commit();


        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th], 500);
        }

        return response()->json(['message' => 'Success'], 200);
    }




}
