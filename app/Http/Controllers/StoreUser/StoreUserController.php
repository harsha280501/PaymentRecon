<?php

namespace App\Http\Controllers\StoreUser;

use App\Exports\MPOSExport;
use App\Exports\SAPExport;
use App\Exports\StoreUser\BankMisExport;
use App\Http\Controllers\Controller;
use App\Models\UserLog;
use App\Services\GeneralService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

use Illuminate\Support\Facades\Artisan;
use Maatwebsite\Excel\Facades\Excel;

class StoreUserController extends Controller {
    /**
     * Index
     */
    public function index(): View {
        return view('app.storeUser.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }

    public function welcome(): View {
        return view('app.storeUser.welcome', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }


    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function process(): View {
        return view('app.storeUser.process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }

    /**
     * Reports
     * @return \Illuminate\View\View
     */
    public function reports(): View {
        return view(
            'app.storeUser.reports',
            [
                'menus' => (new GeneralService)->menus(),
                'tabs' => (new GeneralService)->tabs(),
                'brandAndStore' => (new GeneralService)->brandAndStore()
            ]
        );
    }



    /**
     * Settings page for Admin
     * @return \Illuminate\View\View
     */
    public function settings(): View {
        return view('pages.comming-soon-suser', [
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


    public function exportSAP() {
        return Excel::download(new SAPExport(), 'sap.xlsx');
    }

    public function exportMPOS() {
        return Excel::download(new MPOSExport(), 'mpos.xlsx');
    }


    public function exportBankMIS() {
        return Excel::download(new BankMisExport(), 'bank-mis.xlsx');
    }


    /**
     * Logout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse {

        $user = auth()->user();

        UserLog::create([
            "userUID" => $user->userUID,
            'type' => 'LOGOUT',
            "logTime" => now(),
            "loginDuration" => null,
            "ipAddress" => $request->ip(),
            "isActive" => 1,
            "createdDate" => now(),
            "modifiedDate" => null,
            "createdBy" => '1',
        ]);


        Cache::forget('menus');

        Artisan::call('cache:clear');

        // Logging the user out
        Auth::logout();
        // Clearing the menus
        Cache::forget('menus');
        // regenarate the session
        session()->regenerate();
        session()->regenerateToken();



        return redirect()->route('login');
    }


}