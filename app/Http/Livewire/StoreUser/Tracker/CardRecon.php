<?php

namespace App\Http\Livewire\StoreUser\Tracker;

use App\Traits\HasTabs;

use Livewire\Component;
use App\Traits\UseOrderBy;

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

class CardRecon extends Component implements WithHeaders, WithFormatting, UseExcelDataset {

    use HasInfinityScroll, HasTabs, WithExportDate, ParseMonths, UseOrderBy, StreamExcelDownload;



    /**
     * Filtering main data
     * @var
     */
    public $filtering = false;


    /**
     * Date from
     * @var
     */
    public $startDate = null;


    /**
     * TO date
     * @var
     */
    public $endDate = null;



    /**
     * Active tab
     * @var string
     */
    public $activeTab = 'card';


    /**
     * Store Id to search for
     * @var
     */
    public $storeUID;

    /**
     * User id which i dont really use
     * @var
     */
    public $userUID;




    /**
     * Card Banks
     * @var array
     */
    public $cardBanks = [];



    /**
     * Wallet Banks
     * @var array
     */
    public $walletBanks = [];



    /** f
     * Filenameor export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_STORE_USER_Tracker_Card_Reconciliation';


    public $bank = '';




    /**
     * Quering the search url
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 'tab'],
        'startDate' => ['as' => 'from', 'except' => ''],
        'endDate' => ['as' => 'to', 'except' => ''],
    ];



    /**
     * Initializ the component
     * @return void
     */
    public function mount() {

        $this->resetExcept('activeTab');
        $this->_months = $this->_months()->toArray();
        $this->cardBanks = $this->banks('card');
    }


    public function render() {
        $cashRecon = $this->getData();
        $_totals = $this->getTotals();

        return view('livewire.store-user.tracker.card-recon', [
            'cashRecons' => $cashRecon,
            '_totals' => $_totals
        ]);
    }




    /**
     * Reload the filters
     * @return void
     */
    public function back() {
        $this->emit('resetAll');
        $this->resetExcept('activeTab');
    }



    /**
     *Filters
     */
    public function filterDate($request) {
        $this->startDate = $request['start'];
        $this->endDate = $request['end'];
        $this->filtering = true;
    }




    public function getTotals() {
        $params = [
            'procType' => 'get_totals',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'storeID' => auth()->user()->storeUID,
            'bank' => $this->bank,
            'timeline' => null
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_Card_Reconciliation :procType, :startDate, :endDate, :storeID, :bank,:timeline',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }


    public function formatter(SpreadSheet $worksheet, $dataset): void {

        $worksheet->setStartFrom(11);
        $worksheet->setFilename($this->_useToday($this->export_file_name . '_STORE_' . auth()->user()->storeUID, now()->format('d-m-Y')));

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

        $_totals = $this->getTotals();

        // headings
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 6, 'Total Calculations');
        // $worksheet->spreadsheet->getActiveSheet()->mergeCells('A6:B6');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('A6:A6')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('3682cd');


        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 7, 'Total Count: ' . $_totals[0]->TotalCount);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 8, 'Matched Count: ' . $_totals[0]->MatchedCount);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 9, 'Not Matched Count: ' . $_totals[0]->NotMatchedCount);

        $worksheet->spreadsheet->getActiveSheet()->setCellValue('D10', 'Total: ');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('E10', $_totals[0]->sales_totalF);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('F10', $_totals[0]->collection_totalF);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('G10', $_totals[0]->adjustment_totalF);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H10', $_totals[0]->difference_totalF);

        $worksheet->spreadsheet->getActiveSheet()->getStyle('A6:A9')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $worksheet->spreadsheet->getActiveSheet()->getStyle('A6:A9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function banks($type) {
        $params = [
            'procType' => $type . '-banks',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'storeID' => auth()->user()->storeUID,
            'bank' => $this->bank,
            'timeline' => ''
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_Card_Reconciliation :procType, :startDate, :endDate, :storeID, :bank,:timeline',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }



    public function download(string $type = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_Card_Reconciliation :procType, :startDate, :endDate, :storeID, :bank,:timeline',
            [
                'procType' => 'simple-card-export',
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'storeID' => auth()->user()->storeUID,
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
            "Status",
            "Card Sales",
            "Deposit Amount",
            "Store Response Entry",
            "Difference [Sales - Deposit - Store Response]",
            "Pending Difference",
            "Reconcilied Difference",
        ];
    }

    /**
     * Data source
     * @return array
     */
    public function getData() {

        $params = [
            'procType' => 'card',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'storeID' => auth()->user()->storeUID,
            'bank' => $this->bank,
            'timeline' => null
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_Card_Reconciliation :procType, :startDate, :endDate, :storeID, :bank,:timeline',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }
}
