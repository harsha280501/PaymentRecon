<?php

namespace App\Http\Livewire\StoreUser\ApprovalProcess;

use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\UseRemarks;
use App\Traits\ParseMonths;
use Livewire\WithFileUploads;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use App\Interface\Excel\SpreadSheet;
use App\Interface\Excel\WithHeaders;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;


class DirectDeposit extends Component implements WithHeaders, WithFormatting, UseExcelDataset {


    use HasInfinityScroll, ParseMonths, UseRemarks, WithFileUploads, UseOrderBy, WithExportDate, UseOrderBy, StreamExcelDownload;



    /**
     * Used for filtering 
     * @var 
     */
    public $filtering = false;





    /**
     * Date filter: Start
     * @var 
     */
    public $startdate = null;



    /**
     * Date filter: end
     * @var 
     */
    public $enddate = null;



    /**
     * Remarks
     * @var array
     */
    public $remarks = [];


    /** f
     * Filenameor export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Approved_Direct_Deposit';




    /**
     * Filter dates
     * @param mixed $data
     * @return void
     */
    public function filterDate($data) {
        $this->filtering = true;
        $this->startdate = $data['start'];
        $this->enddate = $data['end'];
    }


    public function formatter(SpreadSheet $worksheet, $dataset): void {

        $worksheet->setStartFrom(7);
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
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 2, 'Report Name: ' . 'Cash Reconciliation');
    }

    /**
     * Get the Main data
     * @return array
     */
    public function stores() {
        return DB::withOrderBySelect('PaymentMIS_PROC_STOREUSER_SELECT_Approved_Process_Direct_Deposit :procType, :storeId, :from, :to', [
            'procType' => 'stores',
            'storeId' => '',
            'from' => '',
            'to' => '',
        ], $this->perPage);
    }




    /**
     * Return to main
     * @return void
     */
    public function back() {
        $this->reset();
        $this->emit('resetAll');
    }




    /**
     * Render the main function
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        return view('livewire.store-user.approval-process.direct-deposit', [
            'dataset' => $this->dataset()
        ]);
    }





    /**
     * Get the Main data
     * @return array
     */
    public function dataset() {
        return DB::withOrderBySelect('PaymentMIS_PROC_STOREUSER_SELECT_Approved_Process_Direct_Deposit :procType, :storeId, :from, :to', [
            'procType' => 'dataset',
            'storeId' => auth()->user()->storeUID,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ], $this->perPage, $this->orderBy);
    }

    public function download(string $type = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_STOREUSER_SELECT_Approved_Process_Direct_Deposit :procType, :storeId, :from, :to',
            [
                'procType' => 'export',
                'storeId' => auth()->user()->storeUID,
                'from' => $this->startdate,
                'to' => $this->enddate,
            ],
            $this->perPage,
            $this->orderBy
        );
    }

    public function headers(): array {

        return [
            "Store ID",
            "Retek Code",
            "Date",
            "Status",
            "Deposit SlipNo",
            "Amount",
            "Bank"


        ];
    }
}
