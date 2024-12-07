<?php

namespace App\Http\Livewire\CommercialTeam\Tracker;

use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use Maatwebsite\Excel\Facades\Excel;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;

class ReconciliationSummary extends Component implements UseExcelDataset, WithFormatting {

    use HasInfinityScroll, WithExportDate, ParseMonths, UseOrderBy, StreamExcelDownload;


    /**
     * Filtering content
     * @var
     */
    public $filtering = false;


    public $startDate = null;





    public $endDate = null;



    /**
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Reconciliation_Summary';
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

    protected $datas;




    public function mount() {

        $this->_months = $this->_months()->toArray();

        $params = [
            'procType' => 'stores',
            'storeId' => $this->store,
            'daterange' => '',
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        $this->stores = DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALTEAM_SELECT_Reconciliation_Summary :procType, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage
        );
    }

    public function headers(): array {
        return [
            "Store ID",
            "Retek Code",
            "Store Type",
            "Brand",
            "Region",
            "Location",
            "City",
            "State",
            "Date",
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
            "Cash ",
            "Card ",
            "Upi ",
            "Wallet ",
            "Total Difference ",
        ];
    }


    public function render() {

        $this->datas = $this->datas();

        // getting the main data
        return view('livewire.commercial-team.tracker.reconciliation-summary', [
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





    public function download(string $value): Collection|bool {

        $params = [
            'procType' => 'export',
            'storeId' => $this->store,
            'daterange' => $value,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALTEAM_SELECT_Reconciliation_Summary :procType, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage
        );
    }

    public function formatter(\App\Interface\Excel\SpreadSheet $worksheet, $dataset): void {

        $worksheet->setStartFrom(2);
        $worksheet->setFilename($this->_useToday($this->export_file_name, now()->format('d-m-Y')));




        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 1, 'Store Information');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('J' . 1, 'Tender Sales');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('O' . 1, 'Tender Collection');
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('T' . 1, 'Different');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('A1:I1');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('J1:N1');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('O1:S1');
        $worksheet->spreadsheet->getActiveSheet()->mergeCells('T1:X1');

        $worksheet->spreadsheet->getActiveSheet()->getStyle('A1:X1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('T1:X1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('37B5B6');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('O1:S1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF4040');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('J1:N1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FF7F24');

        $worksheet->spreadsheet->getActiveSheet()
            ->getStyle('A1:I1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('CAFF70');


        $worksheet->spreadsheet->getActiveSheet()->getStyle('A1:U1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }





    /**
     * Get the aMain reports
     * @return array
     */
    public function datas() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALTEAM_SELECT_Reconciliation_Summary :procType, :storeId, :daterange, :from, :to',
            [
                'procType' => 'combined',
                'storeId' => $this->store,
                'daterange' => '',
                'from' => $this->startDate,
                'to' => $this->endDate
            ],

            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }
}
