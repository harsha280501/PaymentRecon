<?php

namespace App\Http\Controllers\AreaManager;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\View\View;

class TrackerController extends Controller {


    /**
     * Trackers
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.area-manager.tracker.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    public function daywiseRecon() {

        return view('app.area-manager.tracker.daywise-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    public function cashRecon() {
        return view('app.area-manager.tracker.cash-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    public function cardRecon() {
        return view('app.area-manager.tracker.card-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function walletRecon() {
        return view('app.area-manager.tracker.wallet-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    public function MposRecon() {
        return view('app.area-manager.tracker.mpos-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

}