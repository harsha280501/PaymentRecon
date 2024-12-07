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

class AllCardRecon extends Component implements WithHeaders, WithFormatting, UseExcelDataset {

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
    public $export_file_name = 'Payment_MIS_Reports_All_Tender_Reconciliation';





    public $bank = '';




    public $status = '';




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

        return view('livewire.store-user.tracker.all-card-recon', [
            'dataset' => $dataset,
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
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 2, 'Report Name: ' . 'All Card Reconciliation');


        $worksheet->spreadsheet->getActiveSheet()->setCellValue('C' . 6, 'Sales');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('O' . 6, 'Collection');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('AA' . 6, 'Difference');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('C6:N6');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('O6:Z6');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('AA6:AF6');

        // adding border
        $worksheet->spreadsheet->getActiveSheet()->getStyle('A6:AF6')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('AA6:AF6')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('DAFFFB');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('O6:Z6')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('176B87');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('C6:N6')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('04364A');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('C6:Z6')
            ->getFont()
            ->getColor()
            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);


        $worksheet->spreadsheet->getActiveSheet()->getStyle('A6:AF6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    }



    public function download(string $type = ''): Collection|bool {

        $params = [
            'procType' => 'export',
            'store' => auth()->user()->storeUID,
            "status" => $this->status,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'timeline' => ''
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_All_Card_Reconciliation :procType, :store, :status, :from, :to, :timeline',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }





    /**
     * Headers for The Excel file
     * @return array
     */
    public function headers(): array {
        return [
            "Sales Date",
            "Deposit Date",

            "HDFC",
            "ICICI",
            "SBI",
            "AMEX",
            "HDFC UPI",
            "PayTM",
            "PhonePe",
            "Total Card Sales",
            "Total UPI Sales",
            "Total Wallet Sales",
            "Total Cash Sales",
            "Total Sales",

            "HDFC",
            "ICICI",
            "SBI",
            "AMEX",
            "HDFC UPI",
            "PayTM",
            "PhonePe",
            "Total Card Collection",
            "Total UPI Collection",
            "Total Wallet Collection",
            "Total Cash Collection",
            "Total Collection",

            "Card Difference",
            "UPI Difference",
            "Wallet Difference",
            "Cash Difference",
            "Total Difference",
            "Status",
        ];
    }







    /**
     * Data source
     * @return array
     */
    public function getData() {

        $params = [
            'procType' => 'all',
            'store' => auth()->user()->storeUID,
            "status" => $this->status,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'timeline' => ''
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_All_Card_Reconciliation :procType, :store, :status, :from, :to, :timeline',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }
}
