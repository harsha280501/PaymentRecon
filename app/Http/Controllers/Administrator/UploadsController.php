<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Illuminate\View\View;

class UploadsController extends Controller {


    /**
     * Upload
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.admin.uploads', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    public function bankStatements() {

        return view('app.admin.bank-statements-upload.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function bankMISRepository() {
        return view('app.admin.bankmis-repository.bank-mis-repository', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

}
