<?php

namespace App\Http\Livewire\StoreUser\Process;

use App\Traits\HasTabs;
use Livewire\Component;

use Illuminate\View\View;
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
use Livewire\WithFileUploads;

class MposCashRecon extends Component implements WithHeaders, WithFormatting, UseExcelDataset {


    use HasTabs, HasInfinityScroll, UseRemarks, WithExportDate, UseOrderBy, ParseMonths, StreamExcelDownload, WithFileUploads;




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
    public $export_file_name = 'Payment_MIS_Recon_STORE_USER_Cash_Reconciliation';



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
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_STOREUSER_SELECT_Process_MPOS_Reconciliation :procType, :storeId, :bank, :from, :to, :timeline',
            [
                'procType' => 'main-banks',
                'storeId' => auth()->user()->storeUID,
                'bank' => $this->bank,
                'from' => $this->startdate,
                'to' => $this->enddate,
                'timeline' => '',
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
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 2, 'Report Name: ' . 'Cash Reconciliation');
    }




    /**
     * Get Bank Names
     * @return mixed
     */
    public function download(string $type = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_STOREUSER_SELECT_Process_MPOS_Reconciliation :procType, :storeId, :bank, :from, :to, :timeline',
            [
                'procType' => 'simple-cash-export',
                'storeId' => auth()->user()->storeUID,
                'bank' => $this->bank,
                'from' => $this->startdate,
                'to' => $this->enddate,
                'timeline' => $type,
            ],
            $this->perPage,
            $this->orderBy
        );
    }





    public function headers(): array {

        return [
            "Sales Date",
            "Deposit Date",
            "Bank Drop ID",
            "BankDrop Amount",
            "Tender Amount",
            "Deposit Amount",
            "Tender Difference[Tender-Deposit]",
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
    public function getData(): array|Collection {

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_STOREUSER_SELECT_Process_MPOS_Reconciliation :procType, :storeId, :bank, :from, :to, :timeline',
            [
                'procType' => $this->activeTab,
                'storeId' => auth()->user()->storeUID,
                'bank' => $this->bank,
                'from' => $this->startdate,
                'to' => $this->enddate,
                'timeline' => '',
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

        return view('livewire.store-user.process.mpos-cash-recon', [
            'dataset' => $dataset
        ]);
    }
}
