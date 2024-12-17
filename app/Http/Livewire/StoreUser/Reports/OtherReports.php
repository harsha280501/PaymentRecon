<?php

namespace App\Http\Livewire\StoreUser\Reports;

use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use App\Traits\WithStoreFormatting;
use App\Interface\Excel\SpreadSheet;
use App\Interface\Excel\WithHeaders;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;
use Illuminate\Pagination\LengthAwarePaginator;

class OtherReports extends Component implements UseExcelDataset, WithFormatting, WithHeaders {


    use HasInfinityScroll, WithExportDate, ParseMonths, HasTabs, StreamExcelDownload, UseOrderBy;




    /**
     * activeTab
     * @var string
     */
    public $activeTab = 'overall-summary';




    /**
     * Select timeline
     * @var string
     */
    public $datewise = 'ThisYear';




    /**
     * Filtering content
     * @var
     */
    public $filtering = false;



    /**
     * StartDate for filtering from dates
     * @var
     */
    public $startdate = null;




    /**
     * end for filtering from dates
     * @var
     */
    public $enddate = null;





    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Other_Reports_OutstandingSummary';





    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];


    public function mount() {
        $this->resetExcept('activeTab');
        $this->_months = $this->_months()->toArray();
    }



    /**
     * Date filters
     * @param mixed $request
     * @return void
     */
    public function filterDate($request) {
        $this->startdate = $request['start'];
        $this->enddate = $request['end'];
        $this->filtering = true;
    }



    /**
     * Resets all the properties
     * @return void
     */
    public function back() {
        $this->resetExcept('activeTab');
        $this->emit('reset:all');
        $this->emit('resetAll');
    }



    /**
     * Required to Download Excel files
     * @param string $value
     * @return \Illuminate\Support\Collection|bool
     */
    public function download(string $value = ''): Collection|bool {

        $params = [
            'procType' => 'overall-summary-export',
            'store' => auth()->user()->storeUID,
            'timeline' => $value,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Reports_Other_Reports :procType, :store, :timeline, :from, :to',
            $params,
            $this->perPage
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
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 2, 'Report Name: ' . 'Other Reports');

        $worksheet->spreadsheet->getActiveSheet()->setCellValue('C' . 7, 'Opening Balance');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('G' . 7, 'Sales');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('K' . 7, 'Collection');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('O' . 7, 'Closing Balance');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('C7:F7');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('G7:J7');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('K7:N7');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('O7:R7');

        $worksheet->spreadsheet->getActiveSheet()->getStyle('A7:R7')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('O7:R7')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FDE767');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('K7:N7')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF4040');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('G7:J7')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF7F24');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('C7:F7')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('CAFF70');


        $worksheet->spreadsheet->getActiveSheet()->getStyle('A7:U7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }


    public function headers(): array {
        return [

            "Retek Code",
            "Month",
            "CASH",
            "CARD",
            "UPI",
            "WALLET",
            "CARD",
            "CASH",
            "UPI",
            "WALLET",
            "CASH",
            "CARD",
            "UPI",
            "WALLET",
            "CASH",
            "CARD",
            "UPI",
            "WALLET"
        ];
    }


    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $dataset = $this->dataset();

        // getting the main data
        return view('livewire.store-user.reports.other-reports', [
            'datas' => $dataset,
        ]);
    }



    /**
     * Get the aMain reports
     * @return LengthAwarePaginator
     */
    public function dataset() {

        $params = [
            'procType' => $this->activeTab,
            'store' => auth()->user()->storeUID,
            'timeline' => '',
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Reports_Other_Reports :procType, :store, :timeline, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy

        );
    }
}
