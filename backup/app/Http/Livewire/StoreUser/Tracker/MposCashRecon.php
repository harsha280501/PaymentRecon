<?php

namespace App\Http\Livewire\StoreUser\Tracker;

use App\Traits\HasTabs;
use Livewire\Component;
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
use Maatwebsite\Excel\Facades\Excel;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;

class MposCashRecon extends Component implements WithHeaders, WithFormatting, UseExcelDataset {

    use HasInfinityScroll, HasTabs, UseRemarks, WithExportDate, ParseMonths, UseOrderBy, StreamExcelDownload;




    /**
     * Show the Back arrow
     * @var
     */
    public $filtering = false;







    /**
     * From Date for filter
     * @var
     */
    public $startDate = null;








    /**
     * To date for filter
     * @var
     */
    public $endDate = null;










    /**
     * (Main) Show the Main tab
     * @var string
     */
    public $activeTab = 'main';









    /**
     * Match filter search
     * @var string
     */
    public $matchStatus = '';



    /** f
     * Filenameor export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_STORE_USER_Tracker_Cash_Reconciliation';




    /**
     * Quering the search url
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 'tab']
    ];





    /**
     *Filters
     */
    public function filterDate($request) {
        $this->startDate = $request['start'];
        $this->endDate = $request['end'];
        $this->filtering = true;
    }


    public function getTotals() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_Cash_Reconciliation :procType, :store, :status, :from, :to,:timeline',
            [
                "procType" => 'get_totals',
                "store" => auth()->user()->storeUID,
                "status" => $this->matchStatus,
                "from" => $this->startDate,
                "to" => $this->endDate,
                'timeline' => ''
            ],
            perPage: $this->perPage,
            orderBy: $this->orderBy
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
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 2, 'Report Name: ' . 'Cash Reconciliation');

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

        $worksheet->spreadsheet->getActiveSheet()->setCellValue('E10', 'Total: ');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('F10', $_totals[0]->sales_totalF);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('G10', $_totals[0]->collection_totalF);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H10', $_totals[0]->adjustment_totalF);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('I10', $_totals[0]->difference_totalF);

        $worksheet->spreadsheet->getActiveSheet()->getStyle('A6:A9')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $worksheet->spreadsheet->getActiveSheet()->getStyle('A6:A9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

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
     * Main render function
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $cashRecon = $this->getData();
        $_totals = $this->getTotals();

        return view('livewire.store-user.tracker.mpos-cash-recon', [
            'cashRecons' => $cashRecon,
            '_totals' => $_totals
        ]);
    }

    public function download(string $type = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_Cash_Reconciliation :procType, :store, :status, :from, :to,:timeline',
            [
                'procType' => 'simple-cash-export',
                "store" => auth()->user()->storeUID,
                "status" => $this->matchStatus,
                "from" => $this->startDate,
                "to" => $this->endDate,
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
            "Deposit SlipNo",
            "Tender Amount",
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
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_Cash_Reconciliation :procType, :store, :status, :from, :to,:timeline',
            [
                "procType" => 'main',
                "store" => auth()->user()->storeUID,
                "status" => $this->matchStatus,
                "from" => $this->startDate,
                "to" => $this->endDate,
                'timeline' => ''
            ],
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }
}
