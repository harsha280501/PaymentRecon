<?php

namespace App\Http\Controllers\CommercialHead;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\View\View;


class TrackerController extends Controller {


    /**
     * Main page
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-head.tracker.index', [
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
        return view('app.commercial-head.tracker.mpos-reconciliation', [
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
        return view('app.commercial-head.tracker.card-reconciliation', [
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
        return view('app.commercial-head.tracker.upi-reconciliation', [
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
        return view('app.commercial-head.tracker.wallet-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }




    public function AllCardReconNew() {
        return view('app.commercial-head.tracker.all-card-recon', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    public function reconciliationSummary(): View {
        return view('app.commercial-head.tracker.reconciliation-summary', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    public function OutstandingSummary(): View {
        return view('app.commercial-head.tracker.outstanding-summary', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    public function BankmisSummary(): View {
        return view('app.commercial-head.tracker.bankmis-summary', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }
}