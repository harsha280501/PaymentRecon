<?php

namespace App\Http\Controllers\CommercialTeam;

use App\Http\Controllers\Controller;
use App\Models\Process\MPOS\Cash\CashRecon;
use App\Models\Process\MPOS\Cash\CashReconApproval;
use App\Models\Process\MPOS\Cash\CashBankRecon;
use App\Models\Process\MPOS\Cash\CashBankReconApproval;
use App\Services\GeneralService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MPOSProcessController extends Controller {



    protected $mposTenderBankReconpath;
    protected $mposBankMisReconpath;



    public function __construct() {
        $this->mposTenderBankReconpath = storage_path('app/public/reconciliation/mpos-reconciliation/store-mpos-tender');
        $this->mposBankMisReconpath = storage_path('app/public/reconciliation/mpos-reconciliation/store-mpos-bankmis');
    }

    /**
     * Index
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-team.process.mpos-process', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }



    /**
     * Generate a file name
     * @param string $originalFileName
     * @param string $extension
     * @return string
     */
    protected function fileName(string $originalFileName, string $extension) {
        return $originalFileName . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $extension;
    }


}
