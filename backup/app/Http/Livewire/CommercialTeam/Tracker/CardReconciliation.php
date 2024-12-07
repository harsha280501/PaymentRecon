<?php

namespace App\Http\Livewire\CommercialTeam\Tracker;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasTabs;
use App\Traits\StreamExcelDownloadNew;
use App\Traits\UseSyncFilters;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\StreamExcelDownload;
use App\Traits\UseDefaults;
use App\Traits\UseLocation;
use App\Traits\UseOrderBy;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class CardReconciliation extends Component implements UseExcelDataset, WithFormatting, WithHeaders {

    use HasInfinityScroll, HasTabs, WithExportDate, ParseMonths, UseOrderBy, UseSyncFilters, UseDefaults;




    /**
     * Filters for Wallet
     * @var array
     */
    public $banks = [];







    /**
     * Filtering
     * @var string
     */
    public $bank = '';






    public $status = '';







    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_TEAM_Tracker_Card_Reconciliation';






    /**
     * Quering the search url
     * @var array
     */
    protected $queryString = [
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
        $this->banks = $this->filters('card-banks');
    }







    public function headers(): array {
        return [
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Brand",
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
     * Formatter
     * @param \App\Interface\Excel\SpreadSheet $spreadSheet
     * @param mixed $dataset
     * @return void
     */
    public function formatter(\App\Interface\Excel\SpreadSheet $spreadSheet, $dataset): void {
        $spreadSheet->setStartFrom(8);
        $spreadSheet->setFilename($this->_useToday($this->export_file_name, now()->format('d-m-Y')));

        $_totals = $this->getTotals();
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('A' . 2, 'Total Calculations');

        $spreadSheet->spreadsheet->getActiveSheet()
            ->getStyle('A2:A2')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('3682cd');


        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('A' . 3, 'Total Count: ' . $_totals[0]->TotalCount);
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('A' . 4, 'Matched Count: ' . $_totals[0]->MatchedCount);
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('A' . 5, 'Not Matched Count: ' . $_totals[0]->NotMatchedCount);

        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('G7', 'Total: ');
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('H7', $_totals[0]->sales_totalF);
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('I7', $_totals[0]->collection_totalF);
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('J7', $_totals[0]->adjustment_totalF);
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('K7', $_totals[0]->difference_totalF);

        $spreadSheet->spreadsheet->getActiveSheet()->getStyle('A2:A5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $spreadSheet->spreadsheet->getActiveSheet()->getStyle('A2:A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }




    public function filtersSyncDataset(string $type) {
        $params = [
            "procType" => $type,
            "store" => $this->_store,
            "brand" => $this->_brand,
            "location" => $this->_location
        ];

        return DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_Card_Reconciliation_Filters :procType, :store, :brand, :location',
            $params
        );
    }


    public function export() {

        $data = $this->download('');
        $headers = $this->headers();
        $_totals = $this->getTotals();

        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }


        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists

        fputcsv($file, ['Total Count: ', $_totals[0]->TotalCount]);
        fputcsv($file, ['Matched Count: ', $_totals[0]->MatchedCount]);
        fputcsv($file, ['Not Matched Count: ', $_totals[0]->NotMatchedCount]);
        fputcsv($file, ['']);



        fputcsv($file, ['', '', '', '', '', '', 'Total', $_totals[0]->sales_totalF, $_totals[0]->collection_totalF, $_totals[0]->adjustment_totalF, $_totals[0]->difference_totalF]);

        fputcsv($file, $headers); // adding headers to the excel


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




    public function getTotals() {

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_Card_Reconciliation :procType, :storeId, :brand, :location, :status, :bank, :timeline, :startDate, :endDate', [
                'procType' => 'get_totals',
                'storeId' => $this->_store,
                'brand' => $this->_brand,
                'location' => $this->_location,
                'status' => $this->status,
                'bank' => $this->bank,
                'timeline' => '',
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
            ], perPage: $this->perPage, orderBy: $this->orderBy);
    }



    public function filters($tab) {
        $params = [
            'procType' => $tab,
            'storeId' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->status,
            'bank' => $this->bank,
            'timeline' => '',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_Card_Reconciliation :procType, :storeId, :brand, :location, :status, :bank, :timeline, :startDate, :endDate',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }




    public function download(string $value = ''): Collection|bool {
        $params = [
            'procType' => 'simple-card-export',
            'storeId' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->status,
            'bank' => $this->bank,
            'timeline' => $value,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];

        // checking if the tab is not for consolidate
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_Card_Reconciliation :procType, :storeId, :brand, :location, :status, :bank, :timeline, :startDate, :endDate',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }




    /**
     * Data source
     * @return array
     */
    public function getData() {
        // main SP
        $params = [
            'procType' => 'card',
            'storeId' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->status,
            'bank' => $this->bank,
            'timeline' => '',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_Card_Reconciliation :procType, :storeId, :brand, :location, :status, :bank, :timeline, :startDate, :endDate',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }
    public function render() {
        return view('livewire.commercial-team.tracker.card-reconciliation', [
            'cashRecons' => $this->getData(),
            '_totals' => $this->getTotals()
        ]);
    }
}
