<?php

namespace App\Http\Livewire\CommercialHead\Reports;

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
use Illuminate\Pagination\LengthAwarePaginator;

class AllSalesCollection extends Component implements UseExcelDataset, WithFormatting {


    use HasInfinityScroll, WithExportDate, ParseMonths, UseOrderBy, StreamExcelDownload;


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
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_All_Sales_Collection';



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






    public function mount() {

        // $this->store = '';
        // $this->filtering = true;

        $this->_months = $this->_months()->toArray();
        $params = [
            'procType' => 'stores',
            'storeId' => $this->store,
            'daterange' => '',
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        $this->stores = DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_All_card_wallet_UPI_Sales_Collection :procType, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage
        );
    }

    public function headers(): array {
        return [
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "CASH",
            "CARD",
            "UPI",
            "WALLET",
            "TOTAL",
            "Status",
            "CASH",
            "HDFC",
            "AMEXPOS",
            "SBI",
            "ICICI",
            "UPI",
            "PHONEPE",
            "PAYTM",
            "Total Cash Collection",
            "Total Card Collection",
            "Total UPI Collection",
            "Total Wallet Collection",
            "Total Collection",
            "Difference",
        ];
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




    public function download(string $value): Collection|bool {

        $params = [
            'procType' => 'export',
            'storeId' => $this->store,
            'daterange' => $value,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_All_card_wallet_UPI_Sales_Collection :procType, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage
        );
    }

    public function formatter(\App\Interface\Excel\SpreadSheet $worksheet, $dataset): void {

        $worksheet->setStartFrom(2);
        $worksheet->setFilename($this->_useToday($this->export_file_name, now()->format('d-m-Y')));




        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 1, 'Sales');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('J' . 1, 'Collection');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('R' . 1, 'Total');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('A1:H1');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('J1:Q1');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('R1:V1');

        $worksheet->spreadsheet->getActiveSheet()->getStyle('A1:W1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('R1:V1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF4040');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('J1:Q1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF7F24');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('A1:H1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('CAFF70');


        $worksheet->spreadsheet->getActiveSheet()->getStyle('A1:U1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }



    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $dataset = $this->dataset('combined');

        // getting the main data
        return view('livewire.commercial-head.reports.all-sales-collection', [
            'datas' => $dataset,
        ]);
    }



    /**
     * Get the aMain reports
     * @return LengthAwarePaginator
     */
    public function dataset($dataset = 'combined') {

        $params = [
            'procType' => $dataset,
            'storeId' => $this->store,
            'daterange' => '',
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_All_card_wallet_UPI_Sales_Collection :procType, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }
}
