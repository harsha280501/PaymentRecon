<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\View\View;

class ReportsController extends Controller {
    /**
     * Reports
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.admin.reports', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    /**
     * MPOS
     * @return \Illuminate\View\View
     */
    public function mpos(): View {
        return view('app.admin.reports.mpos', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    /**
     * SAP
     * @return \Illuminate\View\View
     */
    public function sap(): View {
        return view('app.admin.reports.sap', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * BankMiss
     * @return \Illuminate\View\View
     */
    public function bankmis(): View {
        return view('app.admin.reports.bank-msi', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * Bank Statement
     * @return \Illuminate\View\View
     */
    public function bankStatement(): View {
        return view('app.admin.reports.bank-statement', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    /**
     * Bank Statement
     * @return \Illuminate\View\View
     */
    public function uploads(): View {
        return view('app.admin.reports.uploads', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }
}