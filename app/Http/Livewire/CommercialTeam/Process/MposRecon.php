<?php

namespace App\Http\Livewire\CommercialTeam\Process;

use App\Interface\Excel\SpreadSheet;
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
use App\Traits\UseRemarks;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class MposRecon extends Component implements UseExcelDataset, WithHeaders {


    use HasTabs, HasInfinityScroll, UseRemarks, WithExportDate, UseOrderBy, ParseMonths;




    /**
     * Check if filtering 
     * @var 
     */
    public $filtering = false;





    /**
     * Start date
     * @var 
     */
    public $startdate = null;





    /**
     * End date 
     * @var 
     */
    public $enddate = null;


    /** f
     * Filenameor export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_TEAM_Recon_Cash_Reconciliation';






    /**
     * Summary of main_banks
     * @var array
     */
    public $main_banks = [];







    /**
     * Filters for bank
     * @var string
     */
    public $bank = '';






    /**
     * Active Tab !important
     * @var string
     */
    public $activeTab = 'main';


    public $store = '';


    // filters
    public $stores = [];




    /**
     * Show the querystring on the uri
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];




    public $remarks = [];



    /**
     * Initialize the main pages
     * @return void
     */
    public function mount() {
        $this->main_banks = $this->mainBanks();
        $this->remarks = $this->remarks('cash');
        $this->_months = $this->_months()->toArray();
        $this->stores = $this->storesM();
    }








    /**
     * Filter the dates
     * @param mixed $data
     * @return void
     */
    public function filterDate($data): void {
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
     * Get the main data
     * @return array
     */
    public function mainBanks(): array|Collection {
        return [];
    }









    public function headers(): array {

        return [
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Brand",
            "Bank Drop ID",
            "Tender Amount",
            "BankDrop Amount",
            "Deposit Amount",
            "Tender Difference[Tender-Deposit]",
            "Pending Difference",
            "Reconcilied Difference",
            "Status",
            "Reconciliation Status"

        ];
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
     * Get Stores
     *
     * @return void
     */
    public function storesM() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Process_MPOS_Reconciliation :procType, :store, :bank, :from, :to',
            [
                'procType' => 'stores',
                'store' => $this->store,
                'bank' => $this->bank,
                'from' => $this->startdate,
                'to' => $this->enddate,
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
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Process_MPOS_Reconciliation :procType, :store, :bank, :from, :to',
            [
                'procType' => 'export',
                'store' => $this->store,
                'bank' => $this->bank,
                'from' => $this->startdate,
                'to' => $this->enddate,
            ],
            $this->perPage,
            $this->orderBy
        );
    }





    /**
     * Get the main data
     * @return array
     */
    public function getData(): array|Collection {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Process_MPOS_Reconciliation :procType, :store, :bank, :from, :to',
            [
                'procType' => $this->activeTab,
                'store' => $this->store,
                'bank' => $this->bank,
                'from' => $this->startdate,
                'to' => $this->enddate,
            ],
            $this->perPage,
            $this->orderBy
        );
    }








    /** 
     * Render the dataset
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render(): View {
        // main dataset
        $dataset = $this->getData();

        return view('livewire.commercial-team.process.mpos-recon', [
            'dataset' => $dataset
        ]);
    }
}
