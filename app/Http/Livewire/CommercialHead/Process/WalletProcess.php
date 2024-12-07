<?php

namespace App\Http\Livewire\CommercialHead\Process;

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
use App\Traits\UseLocation;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;

class WalletProcess extends Component implements UseExcelDataset, WithFormatting, WithHeaders {


    use HasTabs, HasInfinityScroll, UseOrderBy, ParseMonths, WithExportDate, UseLocation;





    public $filtering = false;






    public $startDate = null;






    public $endDate = null;

    public $location = [];

    public $Location = '';



    public $activeTab = 'wallet';






    /**
     * Store ID Filters for Card
     * @var array
     */
    public $cardStores = [];





    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Recon_Wallet_Reconciliation';




    /**
     * Store ID Filters for Card
     * @var array
     */
    public $walletStores = [];




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
    public $store = '';





    protected $queryString = [
        'activeTab' => ['as' => 't'],
        'store' => ['as' => 'store'],
        'startDate' => ['as' => 'from'],
        'endDate' => ['as' => 'to'],
        'bank' => ['as' => 'bank']
    ];



    /**
     * Initialize stores
     * @return void
     */
    public function mount() {
        $this->_months = $this->_months()->toArray();
        $this->walletBanks = $this->filters('wallet-banks');
        $this->walletStores = $this->filters('wallet-stores');
        $this->filtering = ($this->store != null || $this->bank != null || $this->startDate != null) ? true : false;
        $this->location = $this->_location();
    }



    public function render() {
        $dataset = $this->getData();

        return view('livewire.commercial-head.process.wallet-process', [
            'dataset' => $dataset
        ]);
    }


    public function filterDate($data) {
        $this->filtering = true;
        $this->startDate = $data['start'];
        $this->endDate = $data['end'];
    }


    public function back() {
        $this->resetExcept('activeTab');
        $this->emit('resetAll');
    }



    public function filters($tab) {
        $params = [
            'procType' => $tab,
            'store' => $this->store,
            'bank' => $this->bank,
            'location' => $this->Location,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_Wallet_Reconciliation :procType, :store, :bank, :location, :startDate, :endDate',
            $params,
            $this->perPage,
            $this->orderBy
        );
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
            "Difference [Sale - Deposit]",
            "Pending Difference",
            "Reconcilied Difference",
            "Recon Status"
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


    public function export() {

        $data = $this->download('');
        $headers = $this->headers();
       

        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }



        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists

        

        fputcsv($file, $headers); // adding headers to the excel

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


    public function download($value = ''): Collection|bool {

        $params = [
            'procType' => 'export',
            'store' => $this->store,
            'bank' => $this->bank,
            'location' => $this->Location,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_Wallet_Reconciliation :procType, :store, :bank,:location, :startDate, :endDate',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }


    public function getData() {

        $params = [
            'procType' => $this->activeTab,
            'store' => $this->store,
            'bank' => $this->bank,
            'location' => $this->Location,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_Wallet_Reconciliation :procType, :store, :bank, :location,:startDate, :endDate',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }
}
