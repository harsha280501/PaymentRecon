<?php

namespace App\Http\Livewire\StoreUser;


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


class ReportsSAP extends Component implements UseExcelDataset, WithFormatting, WithHeaders {

    use HasInfinityScroll, WithExportDate, StreamExcelDownload, WithStoreFormatting, UseOrderBy, ParseMonths;


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
     * end for filtering from dates
     * @var
     */
    public $store = '';






    public $stores = [];




    /**
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Daily_Tender_Wise_Store_Sales';





    public function mount() {
        $this->_months = $this->_months()->toArray();
        // getting the store data
        $this->stores = DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => auth()->user()->storeUID,
            'userId' => auth()->user()->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'stores'
        ]);
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
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 2, 'Report Name: ' . 'Daliy Tender Wise Store Sales');
    }
    /**
     * Required to Download Excel files
     * @param string $value
     * @return \Illuminate\Support\Collection|bool
     */
    public function download(string $value = ''): Collection|bool {

        $params = [
            'procType' => 'simple-export',
            'userId' => auth()->user()->userUID,
            'storeId' => auth()->user()->storeUID,
            'daterange' => $this->datewise,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STORE_SAPSales :procType, :userId, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }



    /**
     * Headers for Excel Export
     * @return array
     */
    public function headers(): array {
        return [
            'Sales Date',

            // 'Brand Desc',
            'AMEX',
            'HDFC',
            'ICICI',
            'SBI',
            'UPI-HDFC',
            'CASH',
            'PAYTM',
            'PHONE PE',
            'Total',
            'Vouchgram',
            'Gift Vr Redeemed',
            'Grand Total',
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
        $this->reset();
        $this->emit('reset:all');
        $this->emit('resetAll');
    }






    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $reports = $this->reports();

        // getting the main data
        return view('livewire.store-user.reports-s-a-p', [
            'reports' => $reports,
        ]);
    }






    public function reports() {

        $params = [
            'procType' => 'combined',
            'userId' => auth()->user()->userUID,
            'storeId' => auth()->user()->storeUID,
            'daterange' => $this->datewise,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STORE_SAPSales :procType, :userId, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }
}
