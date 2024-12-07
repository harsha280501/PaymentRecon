<?php

namespace App\Http\Livewire\StoreUser\Reports;

use App\Interface\Excel\SpreadSheet;
use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use Livewire\Component;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\StreamExcelDownload;
use App\Traits\UseOrderBy;
use App\Traits\WithStoreFormatting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReconciliationSummary extends Component implements UseExcelDataset, WithFormatting, WithHeaders {

    use HasInfinityScroll, WithExportDate, ParseMonths, StreamExcelDownload, WithStoreFormatting, UseOrderBy;


    /**
     * Filtering content
     * @var
     */
    public $filtering = false;


    public $startDate = null;


    public $endDate = null;




    /**
     * end for filtering from dates
     * @var
     */
    public $store = '';





    /**
     * end for filtering from dates
     * @var
     */
    public $stores = [];



    /**
     * Filtering
     * @var string
     */
    public $storeId = '';




    /**
     * Get the Data
     * @var 
     */
    protected $datas;



    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Reconciliation_Summary';







    public function render() {

        $this->datas = $this->datas();
        // getting the main data
        return view('livewire.store-user.reports.reconciliation-summary', [
            'datas' => $this->datas
        ]);
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
    public function download(string $value): Collection|bool {

        $params = [
            'procType' => 'simple-export',
            'storeId' => auth()->user()->storeUID,
            'daterange' => $value,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Reconciliation_Summary :procType, :storeId, :daterange, :from, :to',
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
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 2, 'Report Name: ' . 'Reconciliation Summary');

        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 7, 'Tender Sales');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('G' . 7, 'Tender Collection');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('L' . 7, 'Total Difference');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('A7:F7');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('G7:K7');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('L7:P7');
        $worksheet->spreadsheet->getActiveSheet()->getStyle('A7:P7')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);



        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('L7:P7')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('E6A4B4');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('G7:K7')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF7F24');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('A7:F7')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('CAFF70');


        $worksheet->spreadsheet->getActiveSheet()->getStyle('A7:P7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function headers(): array {
        return [
            "Sales Date",
            "Cash",
            "Card",
            "Upi",
            "Wallet",
            "Total Sales",
            "Cash",
            "Card",
            "Upi",
            "Wallet",
            "Total Receivables",
            "Cash",
            "Card",
            "Upi",
            "Wallet",
            "Total Difference",
        ];
    }





    /**
     * Get the aMain reports
     * @return array
     */
    public function datas() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Reconciliation_Summary :procType, :storeId, :daterange, :from, :to',
            [
                'procType' => 'combined',
                'storeId' => auth()->user()->storeUID,
                'daterange' => '',
                'from' => $this->startDate,
                'to' => $this->endDate
            ],

            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }
}
