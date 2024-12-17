<?php

namespace App\Http\Controllers\CommercialTeam;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SettingsController extends Controller {


    /**
     * Settings page for Admin
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('pages.comming-soon-cuser', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    /**
     * Settings page for Admin
     * @return \Illuminate\View\View
     */
    public function storeMaster(): View {
        return view('app.commercial-team.settings.store-master', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }
}
