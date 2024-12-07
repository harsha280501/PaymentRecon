<?php

namespace App\Http\Livewire\CommercialHead\Tracker;

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

class AllCardRecon extends Component implements UseExcelDataset, WithFormatting {

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
        $this->stores = $this->_stores();
        $this->locations = $this->_location();
        $this->_months = $this->_months()->toArray();
    }


    public function render() {
        $dataset = $this->getData();

        return view('livewire.commercial-head.tracker.all-card-recon', [
            'dataset' => $dataset,
        ]);
    }


    public function headers(): array {

        return [
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
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
     * Data source
     * @return array
     */
    public function getData() {

        $params = [
            'procType' => 'all',
            'store' => $this->store,
            'status' => $this->status,
            'location' => $this->Location,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_All_Card_Reconciliation :procType, :store, :status, :location, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }

    public function download(string $value): Collection|bool {
        $params = [
            'procType' => 'export',
            'store' => $this->store,
            'status' => $this->status,
            'location' => $this->Location,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_All_Card_Reconciliation :procType, :store, :status,:location, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }

    public function formatter(\App\Interface\Excel\SpreadSheet $worksheet, $dataset): void {

        $worksheet->setStartFrom(2);
        $worksheet->setFilename($this->_useToday($this->export_file_name, now()->format('d-m-Y')));

        $worksheet->spreadsheet->getActiveSheet()->setCellValue('E' . 1, 'Sales');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('Q' . 1, 'Collection');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('AC' . 1, 'Difference');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('E1:P1');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('Q1:AB1');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('AC1:AH1');

        // adding border
        $worksheet->spreadsheet->getActiveSheet()->getStyle('A1:AH1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('AC1:AH1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('DAFFFB');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('Q1:AB1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('176B87');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('E1:P1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('04364A');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('E1:Z1')
            ->getFont()
            ->getColor()
            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);


        $worksheet->spreadsheet->getActiveSheet()->getStyle('A1:AH1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }
}
