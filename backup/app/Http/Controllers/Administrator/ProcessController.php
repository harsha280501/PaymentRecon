<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\View\View;

class ProcessController extends Controller {


    /**
     * Index
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('pages.comming-soon-admin', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

}