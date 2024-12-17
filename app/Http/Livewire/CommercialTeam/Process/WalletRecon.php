<?php

namespace App\Http\Livewire\CommercialTeam\Process;

use App\Exports\CommercialHead\Process\SAPProcessExport;
use App\Interface\Excel\SpreadSheet;
use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;
use App\Traits\ParseMonths;
use App\Traits\UseOrderBy;
use App\Traits\UseRemarks;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\StreamExcelDownload;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;

class WalletRecon extends Component implements UseExcelDataset, WithHeaders {

    use HasTabs, HasInfinityScroll, UseRemarks, WithExportDate, UseOrderBy, ParseMonths;


    public $filtering = false;


    public $startdate = null;



    public $enddate = null;



    public $activeTab = 'wallet';



    public $store = '';




    public $stores = [];




    /**
     * Card Recon Banks
     * @var array
     */
    public $cardBanks = [];


    /**
     * Wallet Reco Banks
     * @var array
     */
    public $walletBanks = [];



    /** f
     * Filenameor export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_TEAM_Recon_Wallet_Reconciliation';

    /**
     * Selected BankName
     * @var string
     */
    public $bank = '';




    /**
     * Display strings on URL
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];





    public $remarks = [];





    /**
     * initalize
     * @return void
     */
    public function mount() {
        $this->walletBanks = $this->banks('bank-names-wallet');
        $this->remarks = $this->remarks('wallet');
        $this->stores = $this->storesM();
        $this->_months = $this->_months()->toArray();
    }




    /**
     * Display main Dataset
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $dataset = $this->getData();

        return view('livewire.commercial-team.process.wallet-recon', [
            'dataset' => $dataset
        ]);
    }





    /**
     * the the stores
     * @return mixed
     */
    public function storesM() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Process_Wallet_Recon :procType, :storeId, :startdate, :enddate, :bank, :timeline', [
                'procType' => 'stores',
                'storeId' => $this->store,
                'startdate' => $this->startdate,
                'enddate' => $this->enddate,
                'bank' => $this->bank,
                'timeline' => ''
            ], $this->perPage, $this->orderBy);
    }






    /**
     * Filter dates
     * @param mixed $data
     * @return void
     */
    public function filterDate($data) {
        $this->filtering = true;
        $this->startdate = $data['start'];
        $this->enddate = $data['end'];
    }







    /**
     * Return to main
     * @return void
     */
    public function back() {
        $this->resetExcept('activeTab');
        $this->emit('resetAll');
    }






    /**
     * Get Bank Names
     * @return mixed
     */
    public function banks($procType) {
        return DB::withOrderBySelect(
            '[PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Process_Wallet_Recon] :procType, :storeId, :startdate, :enddate, :bank, :timeline',
            [
                'procType' => $procType,
                'storeId' => $this->store,
                'startdate' => $this->startdate,
                'enddate' => $this->enddate,
                'bank' => $this->bank,
                'timeline' => ""
            ],
            $this->perPage,
            $this->orderBy
        );
    }







    /**
     * ! I was in a hurry
     * @return mixed|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export() {

        $data = $this->download('');
        $headers = $this->headers();


        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }


        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists

        fputcsv($file, $headers);

        foreach ($data as $row) {
            $row = (array) $row;
            fputcsv($file, $row);
        }

        fclose($file);

        return response()->stream(
            function () use ($filePath) {
                echo file_get_contents($filePath);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '"',
            ]
        );
    }






    /**
     * Get Bank Names
     * @return mixed
     */
    public function download(string $type = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Process_Wallet_Recon :procType, :storeId, :startdate, :enddate, :bank, :timeline',
            [
                'procType' => 'export',
                'storeId' => $this->store,
                'startdate' => $this->startdate,
                'enddate' => $this->enddate,
                'bank' => $this->bank,
                'timeline' => $type
            ],
            $this->perPage,
            $this->orderBy
        );
    }






    /**
     * Summary of headers
     * @return array
     */
    public function headers(): array {
        return [
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Brand",
            "ColBank",
            "Wallet Sale",
            "Deposit Amount",
            "Difference[Sale-Deposit]",
            "Pending Difference",
            "Reconcilied Difference",
            "Status",
            "Reconciliation Status"
        ];
    }






    /**
     * Get the main data
     * @return array
     */
    public function getData() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Process_Wallet_Recon :procType, :storeId, :startdate, :enddate, :bank, :timeline', [
                'procType' => 'wallet',
                'storeId' => $this->store,
                'startdate' => $this->startdate,
                'enddate' => $this->enddate,
                'bank' => $this->bank,
                'timeline' => ''
            ], $this->perPage, $this->orderBy);
    }


}
