<?php

namespace App\Http\Livewire\StoreUser\Tracker;

use App\Traits\HasTabs;

use Livewire\Component;
use App\Traits\UseOrderBy;

use App\Traits\ParseMonths;
use App\Traits\UseLocation;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;

class AllCardReconNew extends Component implements UseExcelDataset, WithFormatting {

    use HasInfinityScroll, HasTabs, WithExportDate, ParseMonths, UseOrderBy, UseLocation, StreamExcelDownload;


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
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Tracker_All_Tender_Reconciliation';


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
    public $stores = [];


    /**
     * Filters for Wallet
     * @var array
     */
    public $locations = [];


    public $store = '';


    public $status = '';
    public $Location = '';




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
        $this->reset();
        $this->_months = $this->_months()->toArray();
    }


    public function render() {
        $dataset = $this->getData();
        $_totals = $this->getTotals();

        return view('livewire.store-user.tracker.all-card-recon-new', [
            'dataset' => $dataset,
            '_totals' => $_totals
        ]);
    }


    public function headers(): array {

        return [
            "Sales Date",
            "Deposit Date",

            "Card Sales",
            "UPI Sales",
            "Wallet Sales",
            "Cash Sales",
            "Total Sales",

            "Card Collection",
            "UPI Collection",
            "Wallet Collection",
            "Cash Collection",
            "Total Collection",

            "Card Store Reponse",
            "UPI Store Reponse",
            "Wallet Store Reponse",
            "Cash Store Reponse",
            "Total Store Reponse",

            "Card Difference",
            "UPI Difference",
            "Wallet Difference",
            "Cash Difference",
            "Total Difference",
            "Status"
        ];
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



    /**
     * Get totals
     * @return array
     */
    public function getTotals() {
        $params = [
            'procType' => 'get_totals',
            'store' => auth()->user()->storeUID,
            'status' => $this->status,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_All_Card_Reconciliation :procType, :store, :status, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }




    /**
     * Data source
     * @return array
     */
    public function getData() {

        $params = [
            'procType' => 'all',
            'store' => auth()->user()->storeUID,
            'status' => $this->status,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_All_Card_Reconciliation :procType, :store, :status, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }

    public function download(string $value): Collection|bool {
        $params = [
            'procType' => 'export',
            'store' => auth()->user()->storeUID,
            'status' => $this->status,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_All_Card_Reconciliation :procType, :store, :status, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }



    public function formatter(\App\Interface\Excel\SpreadSheet $worksheet, $dataset): void {

        $worksheet->setStartFrom(13);
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

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('A6:A6')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('3682cd');

        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 7, 'Total Count: ' . $_totals[0]->TotalCount);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 8, 'Matched Count: ' . $_totals[0]->MatchedCount);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 9, 'Not Matched Count: ' . $_totals[0]->NotMatchedCount);

        $worksheet->spreadsheet->getActiveSheet()->setCellValue('B11', 'Total: ');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('G11', $_totals[0]->sales_totalF);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('L11', $_totals[0]->collection_totalF);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('Q11', $_totals[0]->adjustment_totalF);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('V11', $_totals[0]->difference_totalF);

        $worksheet->spreadsheet->getActiveSheet()->setCellValue('C' . 12, 'Sales');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 12, 'Collection');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('M' . 12, 'Store Response Entry');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('R' . 12, 'Difference');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('C12:G12');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('H12:L12');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('M12:Q12');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('R12:W12');

        // adding border
        $worksheet->spreadsheet->getActiveSheet()->getStyle('A12:W12')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // background color

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('C12:G12')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('04364A');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('H12:L12')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('176B87');


        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('M12:Q12')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('DAFFFB');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('R12:W12')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('176B87');


        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('C12:L12')
            ->getFont()
            ->getColor()
            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $worksheet->spreadsheet->getActiveSheet()->getStyle('A12:W12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }
}
