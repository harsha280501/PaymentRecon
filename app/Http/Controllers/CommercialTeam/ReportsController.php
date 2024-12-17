<?php

namespace App\Http\Controllers\CommercialTeam;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\View\View;

class ReportsController extends Controller {
    /**
     * Reports
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-team.reports.index', [
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
        return view('app.commercial-team.reports.mpos', [
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
        return view('app.commercial-team.reports.sap', [
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
        return view('app.commercial-team.reports.bank-msi', [
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
        return view('app.commercial-team.reports.bank-statement', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }






    /**
     * Bank statement Reconciliation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function bankStatementRecon() {
        return view('app.commercial-team.reports.bank-statement-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }




    /**
     * Bank Statement
     * @return \Illuminate\View\View
     */
    public function reportsSummary(): View {
        return view('app.commercial-team.reports.all-sales-collection', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }





    public function reconciliationSummary(): View {
        return view('app.commercial-team.reports.reconciliation-summary', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    public function others(): View {
        return view('app.commercial-team.reports.other-reports', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }
}
