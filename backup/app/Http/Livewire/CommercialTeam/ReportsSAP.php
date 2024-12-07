<?php

namespace App\Http\Livewire\CommercialTeam;



use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\UseLocation;
use Livewire\WithPagination;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;
use App\Exports\CommercialTeam\SAPExport;
use Illuminate\Pagination\LengthAwarePaginator;


class ReportsSAP extends Component implements UseExcelDataset, WithFormatting {


    use HasInfinityScroll, WithExportDate, UseOrderBy, ParseMonths, UseLocation, StreamExcelDownload;



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



    //  * Filename for export
    //      * @var string
    //      */
    public $export_file_name = 'Payment_MIS_Reports_Daily_Tender_Wise_Store_Sales';


    /**
     * end for filtering from dates
     * @var
     */
    public $store = '';






    public $stores = [];








    public function mount() {


        $this->cities = $this->_cities();
        $this->_months = $this->_months()->toArray();
        // getting the store data
        $this->stores = DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => auth()->user()->storeUID,
            'userId' => auth()->user()->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'users-stores02'
        ]);
    }

    public function headers(): array {
        return [

            "SalesDate",
            "Store ID",
            "Retek Code",
            "Brand Desc",
            "AMEX",
            "HDFC",
            "ICICI",
            "SBI",
            "UPI-HDFC",
            "CASH",
            "PAYTM",
            "PHONE PE",
            "Vouchgram",
            "Gift Vr Redeemed",
            "Total"
        ];
    }




    public function download(string $value): Collection|bool {

        $params = [
            'procType' => 'export',
            'from' => $this->startdate,
            'to' => $this->enddate,
            'store' => $this->store,
            'city' => trim($this->_city),
            'brand' => $this->_brand,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_SAPSales :procType, :store, :city, :brand, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }

    public function formatter(\App\Interface\Excel\SpreadSheet $worksheet, $dataset): void {

        $worksheet->setStartFrom(2);
        $worksheet->setFilename($this->_useToday($this->export_file_name, now()->format('d-m-Y')));
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
        $this->resetExcept(['brands']);
        $this->emit('resetAll');
    }

    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $reports = $this->reports();
        $this->brands = $this->_brands();

        // getting the main data
        return view('livewire.commercial-team.reports-s-a-p', [
            'reports' => $reports
        ]);
    }



    /**
     * Get the aMain reports
     * @return array
     */
    public function reports() {

        $params = [
            'procType' => 'combined',
            'from' => $this->startdate,
            'to' => $this->enddate,
            'store' => $this->store,
            'city' => trim($this->_city),
            'brand' => $this->_brand,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_SAPSales :procType, :store, :city, :brand, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }
}
