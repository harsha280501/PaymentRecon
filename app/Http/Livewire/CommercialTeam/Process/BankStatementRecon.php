<?php

namespace App\Http\Livewire\CommercialTeam\Process;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;
use App\Traits\ParseMonths;
use App\Traits\StreamExcelDownload;
use App\Traits\UseOrderBy;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BankStatementRecon extends Component implements UseExcelDataset, WithHeaders {

    use HasTabs, HasInfinityScroll, UseOrderBy, ParseMonths, WithExportDate;




    /**
     * Active tab
     * @var string
     */
    public $activeTab = 'cash';





    /**
     * Find if the filtering is active (to render a back icon)
     * @var
     */
    public $filtering = false;




    public $remarks = [];


    /**
     * Start date for the filter
     * @var
     */
    public $startdate = null;






    /**
     * End date for the filter
     * @var
     */
    public $enddate = null;








    /**
     * Show the active tab on the url
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];



    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_TEAM_Recon_Bank_Statement_Reconciliation';







    /**
     * Store id filters
     * @var array
     */
    public $cash_stores = [];




    /**
     * Store id filters
     * @var array
     */
    public $card_stores = [];



    /**
     * Store id filters
     * @var array
     */
    public $wallet_stores = [];




    /**
     * Store id filters
     * @var array
     */
    public $upi_stores = [];






    /**
     * Retek code filters
     * @var array
     */
    public $cash_codes = [];






    /**
     * Retek code filters
     * @var array
     */
    public $card_codes = [];







    /**
     * Retek code filters
     * @var array
     */
    public $wallet_codes = [];





    /**
     * Retek code filters
     * @var array
     */
    public $upi_codes = [];







    /**
     * Assigned filters
     * @var string
     */
    public $store = '';






    /**
     * Assigned retek code
     * @var string
     */
    public $code = '';







    /**
     * Initialize stores
     * @return void
     */
    public function mount() {
        $this->resetExcept('activeTab');
        $this->_months = $this->_months()->toArray();
        // store ids
        $this->cash_stores = $this->filters();
        $this->card_stores = $this->filters('card');
        $this->wallet_stores = $this->filters('wallet');
        $this->upi_stores = $this->filters('upi');
        // retek codes
        $this->cash_codes = $this->filters('cash', 'codes');
        $this->wallet_codes = $this->filters('wallet', 'codes');
        $this->card_codes = $this->filters('card', 'codes');
        $this->upi_codes = $this->filters('upi', 'codes');
    }





    /**
     * Getting the filter dataset
     * @param string $data
     * @return array
     */
    protected function filters(string $tab = 'cash', string $data = 'stores') {
        return DB::select('PaymentMIS_PROC_COMMERCIALTEAM_SELECT_Process_BankStatement_Reconciliation_Filters :procType', [
            'procType' => $tab . '-' . $data
        ]);
    }







    /**
     * Clear all the filters
     * @return void
     */
    public function back() {
        $this->resetExcept('activeTab');
        $this->emit('resetAll');
    }






    /**
     * Date filter that assignes value to the start and end date
     * @param mixed $data
     * @return void
     */
    public function filterDate($data) {
        $this->filtering = true;
        $this->startdate = $data['start'];
        $this->enddate = $data['end'];
    }






    /**
     * Render the main content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->getData();

        return view('livewire.commercial-team.process.bank-statement-recon', [
            'dataset' => $dataset
        ]);
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
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '_' . ucfirst($this->activeTab) . '"',
            ]
        );
    }





    public function headers(): array {

        if ($this->activeTab == 'cash') {
            return [
                "Credit Date",
                "Deposit Date",
                "Store ID",
                "Retek Code",
                "Brand",
                "Collection Bank",
                "Status",
                "Credit Amount",
                "Net Amount",
                "Difference [Credit - Net]",
                "Recon Status",
            ];
        }

        return [
            "Credit Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Brand",
            "Collection Bank",
            "Status",
            "TID / MID",
            "Credit Amount",
            "Net Amount",
            "Difference [Credit - Net]",
            "Recon Status",
        ];
    }





    /**
     * Download excel files
     * @param mixed $value
     * @return \Illuminate\Support\Collection|bool
     */
    public function download($value = ''): Collection|bool {

        $params = [
            'procType' => $this->activeTab . '-export',
            'store' => $this->store,
            'from' => $this->startdate,
            'to' => $this->enddate
        ];

        // main call
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALTEAM_SELECT_Process_BankStatement_Reconciliation :procType, :store, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }




    /**
     * Get the main data
     * @return array
     */
    public function getData() {

        $params = [
            'procType' => $this->activeTab,
            'store' => $this->store,
            'from' => $this->startdate,
            'to' => $this->enddate
        ];

        // main call
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALTEAM_SELECT_Process_BankStatement_Reconciliation :procType, :store, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }

}
