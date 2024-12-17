<?php

namespace App\Http\Controllers\CommercialHead;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ReportsController extends Controller {




    /**
     * Reports
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-head.reports.index', [
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
        return view('app.commercial-head.reports.mpos', [
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
        return view('app.commercial-head.reports.sap', [
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
        return view('app.commercial-head.reports.bank-mis', [
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
        return view('app.commercial-head.reports.bank-statement', [
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
        return view('app.commercial-head.reports.all-sales-collection', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }




    /**
     * Bank Statement
     * @return \Illuminate\View\View
     */
    public function franchiseeDebit(): View {
        return view('app.commercial-head.reports.franchisee-debit', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }





    public function others(): View {
        return view('app.commercial-head.reports.other-reports', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function unallocated(Request $request): View {

        $tab = !isset($request->query()["tab"]) ? 'cash' : $request->query()["tab"];
        abort_if(!in_array($tab, ['cash', 'card', 'upi', 'wallet', 'cash-direct-deposit', 'rtgs-neft-reco', 'mismatch-store-recon']), 404);

        $components = [
            'cash' => 'app.commercial-head.reports.un-allocated-transactions.cash-transaction',
            'card' => 'app.commercial-head.reports.un-allocated-transactions.card-transaction',
            'upi' => 'app.commercial-head.reports.un-allocated-transactions.upi-transaction',
            'wallet' => 'app.commercial-head.reports.un-allocated-transactions.wallet-transaction',
            'cash-direct-deposit' => 'app.commercial-head.reports.un-allocated-transactions.cash-direct-deposit-reco',
            'rtgs-neft-reco' => 'app.commercial-head.reports.un-allocated-transactions.rtgs-neft-reco',
            'mismatch-store-recon' => 'app.commercial-head.reports.un-allocated-transactions.mismatch-store-recon',
        ];

        return view($components[$tab], [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }






    /**
     * Bank statement Reconciliation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function BankStatementRecon() {
        return view('app.commercial-head.reports.bank-statement-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }




    /**
     * Bank statement Reconciliation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cashDepositReco() {
        return view('app.commercial-head.reports.cash-deposit-reco', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    public function rtgsneftDepositReco() {
        return view('app.commercial-head.reports.rtgs-neft-deposit-reco', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


}
