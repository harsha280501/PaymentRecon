<?php

namespace App\Http\Livewire\CommercialTeam\Tracker;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\StreamSimpleCSV;
use App\Traits\UseDefaults;
use App\Traits\UseOrderBy;
use App\Traits\UseSyncFilters;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MposReconciliation extends Component implements UseExcelDataset, WithFormatting, WithHeaders {

    use HasInfinityScroll, HasTabs, WithExportDate, ParseMonths, UseOrderBy, UseSyncFilters, UseDefaults;




    public $showBankDrop = false;




    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_TEAM_Tracker_Cash_Reconciliation';









    /**
     * Match status filter
     * @var string
     */
    public $matchStatus = '';






    public function headers(): array {
        if ($this->showBankDrop) {

            return [
                "Sales Date",
                "Deposit Date",
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status",
                "Bank Drop ID",
                "BankDrop Amount",
                "Deposit SlipNo",
                "Tender Amount",
                "Deposit Amount",
                "Store Response Entry",
                "Difference [Tender - Deposit - Store Response]",
                "Pending Difference",
                "Reconcilied Difference",
            ];
        }


        return [
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Col Bank",
            "Status",
            "Deposit SlipNo",
            "Tender Amount",
            "Deposit Amount",
            "Store Response Entry",
            "Difference [Tender - Deposit - Store Response]",
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

        // headings
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('A' . 2, 'Total Calculations');
        $spreadSheet->spreadsheet->getActiveSheet()->mergeCells('A2:B2');

        $spreadSheet->spreadsheet->getActiveSheet()
            ->getStyle('A2:B2')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('3682cd');

        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('A' . 3, 'Total Count: ' . $_totals[0]->TotalCount);
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('A' . 4, 'Matched Count: ' . $_totals[0]->MatchedCount);
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('A' . 5, 'Not Matched Count: ' . $_totals[0]->NotMatchedCount);

        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('I7', 'Total: ');
        // $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('J7', str_replace('₹', '', str_replace(',', '', $_totals[0]->sales_total)));
        // $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('K7', str_replace('₹', '', str_replace(',', '', $_totals[0]->collection_total)));
        // $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('L7', str_replace('₹', '', str_replace(',', '', $_totals[0]->adjustment_total)));
        // $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('M7', str_replace('₹', '', str_replace(',', '', $_totals[0]->difference_total)));

        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('J7', $_totals[0]->sales_totalF);
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('K7', $_totals[0]->collection_totalF);
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('L7', $_totals[0]->adjustment_totalF);
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('M7', $_totals[0]->difference_totalF);

        $spreadSheet->spreadsheet->getActiveSheet()->getStyle('A2:B5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $spreadSheet->spreadsheet->getActiveSheet()->getStyle('A2:B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
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


        // IJKLM
        if ($this->showBankDrop) {
            fputcsv($file, ['', '', '', '', '', '', '', '', 'Total', $_totals[0]->sales_totalF, $_totals[0]->collection_totalF, $_totals[0]->adjustment_totalF, $_totals[0]->difference_totalF]);
        }
        if (!$this->showBankDrop) {
            fputcsv($file, ['', '', '', '', '', '', 'Total', $_totals[0]->sales_totalF, $_totals[0]->collection_totalF, $_totals[0]->adjustment_totalF, $_totals[0]->difference_totalF]);
        }
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




    public function filtersSyncDataset(string $type) {
        $params = [
            "procType" => $type,
            "store" => $this->_store,
            "brand" => $this->_brand,
            "location" => $this->_location
        ];

        return DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_Mpos_Reconciliation_Filters :procType, :store, :brand, :location',
            $params
        );
    }




    /**
     * Get totals for both screen and excel
     */
    public function getTotals() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_Mpos_Reconciliation :procType, :store, :brand, :location, :status, :timeline, :from, :to',
            [
                'procType' => "get_totals",
                'store' => $this->_store,
                'brand' => $this->_brand,
                'location' => $this->_location,
                'status' => $this->matchStatus,
                'timeline' => '',
                'from' => $this->startDate,
                'to' => $this->endDate,
            ],
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }


    public function download(string $value = ''): Collection|bool {

        $params = [
            'procType' => $this->showBankDrop
                ? 'withBankdrop-export'
                : 'withoutBankdrop-export',
            'store' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->matchStatus,
            'timeline' => $value,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_Mpos_Reconciliation :procType, :store, :brand , :location, :status, :timeline, :from, :to',
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

        $params = [
            'procType' => 'main',
            'store' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->matchStatus,
            'timeline' => '',
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_Mpos_Reconciliation :procType, :store, :brand, :location, :status, :timeline, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }





    public function render() {
        return view('livewire.commercial-team.tracker.mpos-reconciliation', [
            'cashRecons' => $this->getData(),
            '_totals' => $this->getTotals()
        ]);
    }


}
