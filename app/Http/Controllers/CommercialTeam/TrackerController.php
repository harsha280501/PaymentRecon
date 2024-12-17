<?php

namespace App\Http\Controllers\CommercialTeam;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\View\View;


class TrackerController extends Controller {


    /** 
     * Main page
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-team.tracker.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }






    /**
     * Mpos Reconciliation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function MposRecon() {
        return view('app.commercial-team.tracker.mpos-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }






    /**
     * Sap Reconciliation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function CardRecon() {
        return view('app.commercial-team.tracker.card-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * UPi Reconciliation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function UPIRecon() {
        return view('app.commercial-team.tracker.upi-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }




    /**
     * Sap Reconciliation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function WalletRecon() {
        return view('app.commercial-team.tracker.wallet-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }




    /**
     * Bank Statement Reconciliation process
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function BankStatementProcess() {
        return view('app.commercial-team.tracker.bank-statement-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }






    public function AllCardRecon() {
        return view('app.commercial-team.tracker.all-card-recon', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }
}
