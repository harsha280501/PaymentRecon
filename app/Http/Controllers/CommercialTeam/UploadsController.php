<?php

namespace App\Http\Controllers\CommercialTeam;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\View\View;

class UploadsController extends Controller {


    /**
     * Upload
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-team.uploads', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    public function bankStatements() {

        return view('app.commercial-team.bank-statements-upload.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function bankMISRepository() {
        return view('app.commercial-team.bankmis-repository.bank-mis-repository', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

}
