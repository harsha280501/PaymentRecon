<?php

namespace App\Http\Livewire\StoreUser\Process;

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
use Maatwebsite\Excel\Facades\Excel;
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


    /** f
     * Filenameor export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Recon_All_Card_Reconciliation';
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
     * Remarks
     * @var array
     */
    public $remarks = [];





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
        $this->reset();
        $this->_months = $this->_months()->toArray();
    }


    public function render() {
        $dataset = $this->getData();

        return view('livewire.store-user.process.all-card-recon', [
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




    /**
     * Data source
     * @return array
     */
    public function getData() {

        $params = [
            'procType' => 'all',
            'store' => auth()->user()->storeUID,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'timeline' => ''
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Process_All_Card_Reconciliation :procType, :store, :from, :to, :timeline',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }

    public function formatter(SpreadSheet $worksheet, $dataset): void {

        $worksheet->setStartFrom(8);
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

        $worksheet->spreadsheet->getActiveSheet()->setCellValue('C' . 7, 'Sales');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('I' . 7, 'Collection');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('N' . 7, 'Difference');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('C7:H7');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('I7:N7');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('O7:P7');

        $worksheet->spreadsheet->getActiveSheet()->getStyle('A7:P7')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);



        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('O7:P7')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF4040');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('I7:N7')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF7F24');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('C7:H7')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('CAFF70');


        $worksheet->spreadsheet->getActiveSheet()->getStyle('A7:U7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    /**
     * Get Bank Names
     * @return mixed
     */
    public function download(string $type = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Process_All_Card_Reconciliation :procType, :store, :from, :to, :timeline',
            [
                'procType' => 'simple-Allcard-export',
                'store' => auth()->user()->storeUID,
                'from' => $this->startDate,
                'to' => $this->endDate,
                'timeline' => ''
            ],
            $this->perPage,
            $this->orderBy
        );
    }



    public function headers(): array {
        return [
            "Sales Date",
            "DepositDate",
            "HDFC",
            "ICICI",
            "SBI",
            "AMEX",
            "HDFC UPI",
            "Total Sales",
            "HDFC",
            "ICICI",
            "SBI",
            "AMEX",
            "HDFC UPI",
            "Total Collection",
            "Status",
            "Difference"
        ];
    }
}
