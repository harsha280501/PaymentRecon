<?php

namespace App\Http\Livewire\CommercialTeam\Process;

use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Facades\DB;
use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\ParseMonths;
use App\Traits\StreamExcelDownload;
use App\Traits\WithExportDate;
use App\Traits\UseOrderBy;
use Illuminate\Support\Collection;

class MposCashRecon extends Component implements UseExcelDataset, WithFormatting, WithHeaders {


    use HasTabs, HasInfinityScroll, UseOrderBy, ParseMonths, StreamExcelDownload, WithExportDate;




    public $filtering = false;





    public $startdate = null;






    public $enddate = null;


    public $storeUID;

    public $userUID;


    public $activeTab = 'main';

    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Recon_Cash_Reconciliation';




    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];

    // filters
    public $stores = [];
    public $storesone = [];
    public $storestwo = [];
    public $storesthree = [];
    public $storesfour = [];
    public $storesfive = [];
    public $store = '';
    public $codes = [];
    public $codesone = [];
    public $codestwo = [];
    public $codesthree = [];
    public $codesfour = [];
    public $codesfive = [];
    public $code = '';
    public $banks = [];
    public $bank = '';


    public function mount() {
        $this->resetExcept('activeTab');
        $this->_months = $this->_months()->toArray();
        $this->storesfive = $this->storesM();
        $this->codesfive = $this->codesM();
    }



    public function storesM() {
        $params = [
            'procType' => 'main-stores',
            'storeId' => $this->store,
            'code' => $this->code,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_MPOS_Reconciliation :procType, :storeId, :code, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }




    // retek codes
    public function codesM() {
        $params = [
            'procType' => 'main-codes',
            'storeId' => $this->store,
            'code' => $this->code,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_MPOS_Reconciliation :procType, :storeId, :code, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }



    public function render() {
        $dataset = $this->getData();

        return view('livewire.commercial-team.process.mpos-process', [
            'dataset' => $dataset
        ]);
    }


    public function download($value = ''): Collection|bool {
        $params = [
            'procType' => 'export',
            'storeId' => $this->store,
            'code' => $this->code,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_MPOS_Reconciliation :procType, :storeId, :code, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }


    /**
     * Date fiter
     * @param mixed $data
     * @return void
     */
    public function filterDate($data) {
        $this->filtering = true;
        $this->startdate = $data['start'];
        $this->enddate = $data['end'];
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








    public function headers(): array {
        return [
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Brand Name",
            "Col Bank",
            "Status",
            "Bank Drop ID",
            "Tender Amount",
            "BankDrop Amount",
            "Deposit Amount",
            "Tender Difference [Tender - Deposit]",
            "Reconciliation Status"
        ];
    }




    /**
     * Reset all filters
     * @return void
     */
    public function back() {
        $this->resetExcept('activeTab');
        $this->emit('resetAll');
    }



    /**
     * Get the main data
     * @return array
     */
    public function getData() {
        $params = [
            'procType' => $this->activeTab,
            'storeId' => $this->store,
            'code' => $this->code,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_MPOS_Reconciliation :procType, :storeId, :code, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy()
        );
    }
}
