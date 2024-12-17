<?php

namespace App\Http\Controllers\StoreUser;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class ReportsController extends Controller {




    /**
     * Reports
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.storeUser.reports', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }


    /**
     * SAP
     * @return \Illuminate\View\View
     */
    public function SAP(): View {
        return view('app.storeUser.reports.sap', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }

    public function MPOS(): View {

        // dd(1);
        return view('app.storeUser.reports.mpos', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }

    /**
     * Bank Mis
     * @return \Illuminate\View\View
     */
    public function BankMIS(): View {
        return view('app.storeUser.reports.bank-msi', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * Bank reports
     * @returns Illuminate\View\View
     */
    public function bankStateMent(): View {
        return view('app.storeUser.reports.bank-statement', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    /**
     * Bank reports
     * @returns Illuminate\View\View
     */
    public function allCardUpiWallet(): View {
        return view('app.storeUser.reports.all-card-upi-wallet', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function others(): View {
        return view('app.storeUser.reports.other-reports', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }
}