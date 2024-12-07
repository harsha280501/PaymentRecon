<?php

namespace App\Http\Controllers\AreaManager;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AreaManagerController extends Controller {
    /**
     * Index
     */
    public function index(): View {
        return view('app.area-manager.index', [
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
        return view('pages.comming-soon-amanager', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }



    /**
     * Trackers
     * @return \Illuminate\View\View
     */
    public function tracker(): View {
        return view('pages.comming-soon-amanager', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }

    /**
     * Reposttory
     * @return \Illuminate\View\View
     */
    public function repository(): View {
        return view('app.area-manager.repository.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }



    /**
     * Settings page for Admin
     * @return \Illuminate\View\View
     */
    public function settings(): View {
        return view('pages.comming-soon-amanager', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }

    /**
     * Logout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): RedirectResponse {
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