<?php

namespace App\Http\Livewire\StoreUser\Reports;

use App\Interface\Excel\SpreadSheet;
use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\StreamExcelDownload;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Traits\ParseMonths;
use App\Traits\UseOrderBy;
use App\Traits\WithExportDate;
use App\Traits\WithStoreFormatting;
use Illuminate\Support\Collection;

class AllCardUpiWallet extends Component implements UseExcelDataset, WithFormatting, WithHeaders {


    use HasInfinityScroll, WithExportDate, ParseMonths, StreamExcelDownload, UseOrderBy;


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
    public $export_file_name = 'Payment_MIS_Reports_All_Tender_Sales_Collection';



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
    public function download(string $value): Collection|bool {

        $params = [
            'procType' => 'simple-export',
            'storeId' => auth()->user()->storeUID,
            'daterange' => $value,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_STOREUSER_SELECT_Reports_All_Cash_Card_UPI_Wallet_Sales_Collection :procType, :storeId, :daterange, :from, :to',
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
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 2, 'Report Name: ' . 'All Tender Sales & Collection');


        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 7, 'Sales');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 7, 'Collection');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('P' . 7, 'Total');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('A7:F7');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('H7:O7');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('P7:T7');

        $worksheet->spreadsheet->getActiveSheet()->getStyle('A7:U7')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('P7:T7')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF4040');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('H7:O7')
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


        $worksheet->spreadsheet->getActiveSheet()->getStyle('A7:U7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }



    /**
     * Headers for Excel Export
     * @return array
     */
    public function headers(): array {
        return [
            'Sales Date',
            'CASH',
            'CARD',
            'UPI',
            'WALLET',
            'TOTAL',
            'Status',

            'CASH',
            'HDFC',
            'AMEXPOS',
            'SBI',

            'ICICI',
            'UPI',
            'PHONEPE',

            'PAYTM',
            'Total Cash Collection',
            'Total Card Collection',
            'Total UPI Collection',
            'Total Wallet Collection',
            'Total Collection',
            'Difference'
        ];
    }



    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $dataset = $this->dataset('combined');

        // getting the main data
        return view('livewire.store-user.reports.all-card-upi-wallet', [
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
            'storeId' => auth()->user()->storeUID,
            'daterange' => '',
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_STOREUSER_SELECT_Reports_All_Cash_Card_UPI_Wallet_Sales_Collection :procType, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }
}
