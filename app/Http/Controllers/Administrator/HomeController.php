<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller {

    /**
     * Index
     */
    public function index(): View {

        return view('app.admin.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * Logout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): RedirectResponse {
        Auth::logout();
        session()->regenerate();
        session()->regenerateToken();

        return redirect()->route('login');
    }

}