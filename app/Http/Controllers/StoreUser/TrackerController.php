<?php

namespace App\Http\Controllers\StoreUser;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\View\View;

class TrackerController extends Controller {


    /**
     * Trackers
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.storeUser.tracker.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function mposCashRecon() {
        return view('app.storeUser.tracker.mpos-cash-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    public function walletRecon() {
        return view('app.storeUser.tracker.wallet-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function cardReconcil() {
        return view('app.storeUser.tracker.card-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    public function upiReconcil() {
        return view('app.storeUser.tracker.upi-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    public function allCardRecon() {
        return view('app.storeUser.tracker.all-card-recon', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function allCardReconNew() {
        return view('app.storeUser.tracker.all-card-recon-new', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function reconciliationSummary(): View {
        return view('app.storeUser.tracker.reconciliation-summary', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


}