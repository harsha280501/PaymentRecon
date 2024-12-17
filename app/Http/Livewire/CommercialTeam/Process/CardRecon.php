<?php

namespace App\Http\Livewire\CommercialTeam\Process;

use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\UseRemarks;

use App\Traits\ParseMonths;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;

use App\Interface\Excel\SpreadSheet;
use App\Interface\Excel\WithHeaders;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;

class CardRecon extends Component implements WithHeaders, UseExcelDataset {
    use HasTabs, HasInfinityScroll, UseRemarks, WithExportDate, UseOrderBy, ParseMonths;


    public $filtering = false;


    public $startdate = null;



    public $enddate = null;

    public $store = '';

    public $stores = [];


    /** f
     * Filenameor export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_TEAM_Recon_Card_Reconciliation';


    public $activeTab = 'card';



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
        $this->cardBanks = $this->banks('bank-names-card');
        $this->remarks = $this->remarks('card');
        $this->stores = $this->storesM();
        $this->_months = $this->_months()->toArray();
    }



    /**
     * Display main Dataset
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        return view('livewire.commercial-team.process.card-recon', [
            'dataset' => $this->getData()
        ]);
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


    public function storesM() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Process_Card_Reconiliation :procType, :storeId, :startdate, :enddate, :bank', [
                'procType' => 'stores',
                'storeId' => $this->store,
                'startdate' => $this->startdate,
                'enddate' => $this->enddate,
                'bank' => $this->bank,
            ], $this->perPage, $this->orderBy);
    }


    /**
     * Get Bank Names
     * @return mixed
     */
    public function banks($procType) {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Process_Card_Reconiliation :procType, :storeId, :startdate, :enddate, :bank',
            [
                'procType' => $procType,
                'storeId' => $this->store,
                'startdate' => $this->startdate,
                'enddate' => $this->enddate,
                'bank' => $this->bank,
            ],
            $this->perPage,
            $this->orderBy
        );
    }



    /**
     * Get Bank Names
     * @return mixed
     */
    public function download(string $type = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Process_Card_Reconiliation :procType, :storeId, :startdate, :enddate, :bank', [
                'procType' => 'export',
                'storeId' => $this->store,
                'startdate' => $this->startdate,
                'enddate' => $this->enddate,
                'bank' => $this->bank
            ], $this->perPage, $this->orderBy);
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
    


    public function headers(): array {
        return [
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Brand",
            "ColBank",
            "Card Sale",
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
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Process_Card_Reconiliation :procType, :storeId, :startdate, :enddate, :bank', [
                'procType' => $this->activeTab,
                'storeId' => $this->store,
                'startdate' => $this->startdate,
                'enddate' => $this->enddate,
                'bank' => $this->bank,
            ],
            $this->perPage,
            $this->orderBy
        );
    }
}
