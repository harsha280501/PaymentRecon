<?php

namespace App\Http\Controllers\StoreUser;

use App\Http\Controllers\Controller;

use App\Models\Process\SAP\CardRecon as SAPCardRecon;
use App\Models\Process\SAP\CardReconApproval as SAPCardReconApproval;
use App\Models\Process\SAP\WalletRecon as SAPWalletRecon;
use App\Models\Process\SAP\WalletReconApproval as SAPWalletReconApproval;

use App\Services\GeneralService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProcessController extends Controller {

    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.storeUser.process.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }


    public function cardRecon(): View {
        return view('app.storeUser.process.card-recon-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }


    public function upiRecon(): View {
        return view('app.storeUser.process.upi-recon-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }


    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function walletRecon(): View {
        return view('app.storeUser.process.wallet-recon-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }




    public function mposCashRecon(): View {
        return view('app.storeUser.process.mpos-cash-recon-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }




    public function allCardRecon() {
        return view('app.storeUser.process.all-card-recon', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }
}