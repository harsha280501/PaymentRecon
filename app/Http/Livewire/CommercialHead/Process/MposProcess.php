<?php

namespace App\Http\Livewire\CommercialHead\Process;

use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Facades\DB;
use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\CacheFilters;
use App\Traits\ParseMonths;
use App\Traits\StreamExcelDownload;
use App\Traits\UseLocation;
use App\Traits\WithExportDate;
use App\Traits\UseOrderBy;
use Illuminate\Support\Collection;

class MposProcess extends Component implements UseExcelDataset, WithFormatting, WithHeaders {


    use HasTabs, HasInfinityScroll, UseOrderBy, WithExportDate, ParseMonths, WithExportDate, UseLocation;


    public $filtering = false;


    public $locations = [];



    public $startDate = null;



    public $Location = '';



    public $endDate = null;






    public $activeTab = 'main';





    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Recon_Cash_Reconciliation';






    protected $queryString = [
        'activeTab' => ['as' => 't'],
        'store' => ['as' => 'store'],
        'startDate' => ['as' => 'from'],
        'endDate' => ['as' => 'to']
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
        // $this->resetExcept('activeTab');
        $this->_months = $this->_months()->toArray();
        $this->storesfive = $this->storesM();
        $this->codesfive = $this->codesM();
        $this->filtering = ($this->store != null || $this->bank != null || $this->startDate != null) ? true : false;
        $this->locations = $this->_location();

    }




    public function storesM() {
        $params = [
            'procType' => 'main-stores',
            'storeId' => $this->store,
            'code' => $this->code,
            'location' => $this->Location,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_MPOS_Reconciliation :procType, :storeId, :code, :location, :from, :to',
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
            'location' => $this->Location,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_MPOS_Reconciliation :procType, :storeId, :code, :location, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }






    public function render() {
        $dataset = $this->getData();

        return view('livewire.commercial-head.process.mpos-process', [
            'dataset' => $dataset
        ]);
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
            'storeId' => $this->store,
            'code' => $this->code,
            'location' => $this->Location,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_MPOS_Reconciliation :procType, :storeId, :code, :location, :from, :to',
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
        $this->startDate = $data['start'];
        $this->endDate = $data['end'];
        // $this->updated();
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
            "BankDrop Amount",
            "Tender Amount",
            "Deposit Amount",
            "Tender Difference [Tender - Deposit]",
            "Pending Difference",
            "Reconcilied Difference",
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
            'location' => $this->Location,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Process_MPOS_Reconciliation :procType, :storeId, :code, :location, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }
}
