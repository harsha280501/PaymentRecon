<?php

namespace App\Http\Livewire\StoreUser\Process;

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
use Maatwebsite\Excel\Facades\Excel;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exports\StoreUser\Process\SAPProcessExport;
use App\Exports\StoreUser\Process\CardReconProcessExport;

class CardRecon extends Component implements WithHeaders, WithFormatting, UseExcelDataset {
    use HasTabs, HasInfinityScroll, UseRemarks, WithExportDate, UseOrderBy, ParseMonths, StreamExcelDownload;


    public $filtering = false;


    public $startdate = null;



    public $enddate = null;


    /** f
     * Filenameor export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Recon_STORE_USER_Card_Reconciliation';


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
        $this->_months = $this->_months()->toArray();
    }



    /**
     * Display main Dataset
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $dataset = $this->getData();

        return view('livewire.store-user.process.card-recon', [
            'dataset' => $dataset
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


    /**
     * Get Bank Names
     * @return mixed
     */
    public function banks($procType) {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_STOREUSER_SELECT_Process_Card_Recon :procType, :storeId, :startdate, :enddate, :bank, :timeline',
            [
                'procType' => $procType,
                'storeId' => auth()->user()->storeUID,
                'startdate' => $this->startdate,
                'enddate' => $this->enddate,
                'bank' => $this->bank,
                'timeline' => ''
            ],
            $this->perPage,
            $this->orderBy
        );
    }

    public function formatter(SpreadSheet $worksheet, $dataset): void {

        $worksheet->setStartFrom(7);
        $worksheet->setFilename($this->_useToday($this->export_file_name, now()->format('d-m-Y')));

        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 1, 'Store ID: ' . auth()->user()->main()['Store ID']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 2, 'Retek Code: ' . auth()->user()->main()['RETEK Code']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 3, 'Store Type: ' . auth()->user()->main()['StoreTypeasperBrand']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 4, 'Brand: ' . auth()->user()->main()['Brand Desc']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('D' . 1, 'Region: ' . auth()->user()->main()['Region']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('D' . 2, 'Location: ' . auth()->user()->main()['Location']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('D' . 3, 'City: ' . auth()->user()->main()['City']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('D' . 4, 'State: ' . auth()->user()->main()['State']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 1, 'Franchisee Name: ' . auth()->user()->main()['franchiseeName']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 2, 'Report Name: ' . 'Card Reconciliation');
    }
    /**
     * Get Bank Names
     * @return mixed
     */
    public function download(string $type = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_STOREUSER_SELECT_Process_Card_Recon :procType, :storeId, :startdate, :enddate, :bank, :timeline',
            [
                'procType' => 'simple-card-export',
                'storeId' => auth()->user()->storeUID,
                'startdate' => $this->startdate,
                'enddate' => $this->enddate,
                'bank' => $this->bank,
                'timeline' => $type
            ],
            $this->perPage,
            $this->orderBy
        );
    }



    public function headers(): array {
        return [
            "Sales Date",
            "Deposit Date",
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
            'PaymentMIS_PROC_STOREUSER_SELECT_Process_Card_Recon :procType, :storeId, :startdate, :enddate, :bank, :timeline',
            [
                'procType' => $this->activeTab,
                'storeId' => auth()->user()->storeUID,
                'startdate' => $this->startdate,
                'enddate' => $this->enddate,
                'bank' => $this->bank,
                'timeline' => ''
            ],
            $this->perPage,
            $this->orderBy
        );
    }
}
