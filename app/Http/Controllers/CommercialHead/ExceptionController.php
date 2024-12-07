<?php

namespace App\Http\Controllers\CommercialHead;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;

use Illuminate\View\View;


class ExceptionController extends Controller {




    /**
     * Reports
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-head.exceptions.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    /**
     * MPOS
     * @return \Illuminate\View\View
     */
    public function mailList(): View {
        return view('app.commercial-head.exceptions.mail-list', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * MPOS
     * @return \Illuminate\View\View
     */
    public function adjCollection(): View {
        return view('app.commercial-head.exceptions.adj-collection', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * MPOS
     * @return \Illuminate\View\View
     */
    public function depositDeposit(): View {
        return view('app.commercial-head.exceptions.direct-deposit', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * MPOS
     * @return \Illuminate\View\View
     */
    public function userActivity(): View {
        return view('app.commercial-head.exceptions.activity', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * MPOS
     * @return \Illuminate\View\View
     */
    public function storeUpdateHistory(): View {
        return view('app.commercial-head.exceptions.store-update-history', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }
}