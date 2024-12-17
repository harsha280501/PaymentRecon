<?php

namespace App\Http\Controllers\StoreUser;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\View\View;


class ApprovalProcessController extends Controller {


    /**
     * Main page
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.storeUser.approval-process.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }




    /**
     * Mpos Reconciliation Process
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function MposProcess() {
        return view('app.storeUser.approval-process.mpos-recon-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }






    /**
     * SAP Reconciliation Process
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function CardProcess() {
        return view('app.storeUser.approval-process.card-recon-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }




    /**
     * SAP Reconciliation Process
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function UPIProcess() {
        return view('app.storeUser.approval-process.upi-recon-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }







    /**
     * SAP Reconciliation Process
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function WalletProcess() {
        return view('app.storeUser.approval-process.wallet-recon-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    /**
     * Direct Deposit
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function DirectDeposit() {
        return view('app.storeUser.approval-process.direct-deposit', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }
}