<?php

namespace App\Http\Livewire\CommercialTeam\Process;

use App\Exports\CommercialHead\Process\SAPProcessExport;
use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;
use App\Traits\ParseMonths;
use App\Traits\UseOrderBy;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\StreamExcelDownload;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;

class UpiProcess extends Component implements UseExcelDataset, WithFormatting, WithHeaders {


    use HasTabs, HasInfinityScroll, UseOrderBy, ParseMonths, StreamExcelDownload, WithExportDate;





    public $filtering = false;






    public $startdate = null;






    public $enddate = null;





    public $activeTab = 'upi';





    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];




    /**
     * Store ID Filters for Card
     * @var array
     */
    public $cardStores = [];


    /**
     * Store ID Filters for Card
     * @var array
     */
    public $walletStores = [];




    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Recon_UPI_Reconciliation';




    /**
     * Filters for Card
     * @var array
     */
    public $cardBanks = [];





    /**
     * Filters for Wallet
     * @var array
     */
    public $walletBanks = [];




    /**
     * Filtering
     * @var string
     */
    public $bank = '';




    /**
     * Filtering
     * @var string
     */
    public $storeId = '';





    /**
     * Initialize stores
     * @return void
     */
    public function mount() {
        $this->resetExcept('activeTab');
        $this->_months = $this->_months()->toArray();
        $this->cardBanks = $this->filters('upi-banks');
        $this->cardStores = $this->filters('upi-stores');
    }



    public function render() {
        $dataset = $this->getData();

        return view('livewire.commercial-head.process.upi-process', [
            'dataset' => $dataset
        ]);
    }





    public function headers(): array {
        return [
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Brand",
            "Col Bank",
            "Status",
            "Sales Amount",
            "Deposit Amount",
            "Difference",
            "Recon Status",
            "Adjustment Amount",
        ];
    }






    /**
     * Formatter
     * @param \App\Interface\Excel\SpreadSheet $spreadSheet
     * @param mixed $dataset
     * @return void
     */
    public function formatter(\App\Interface\Excel\SpreadSheet $spreadSheet, $dataset): void {
        $spreadSheet->setStartFrom(1);
        $spreadSheet->setFilename($this->_useToday($this->export_file_name, now()->format('d-m-Y')));
    }




    public function filterDate($data) {
        $this->filtering = true;
        $this->startdate = $data['start'];
        $this->enddate = $data['end'];
    }


    public function back() {
        $this->resetExcept('activeTab');
        $this->emit('resetAll');
    }



    public function filters($tab) {
        $params = [
            'procType' => $tab,
            'storeId' => $this->storeId,
            'bank' => $this->bank,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_UPI_Reconciliation :procType, :storeId, :bank, :startdate, :enddate',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }




    public function download($value = ''): Collection|bool {

        $params = [
            'procType' => 'export',
            'storeId' => $this->storeId,
            'bank' => $this->bank,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_UPI_Reconciliation :procType, :storeId, :bank, :startdate, :enddate',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }



    public function getData() {

        $params = [
            'procType' => $this->activeTab,
            'startdate' => $this->startdate,
            'bank' => $this->bank,
            'enddate' => $this->enddate,
            'storeId' => $this->storeId,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_UPI_Reconciliation :procType, :storeId, :bank, :startdate, :enddate',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }
}
