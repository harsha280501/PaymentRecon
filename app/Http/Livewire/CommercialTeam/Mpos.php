<?php

namespace App\Http\Livewire\CommercialTeam;


use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\UseLocation;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use Maatwebsite\Excel\Facades\Excel;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;
use App\Exports\CommercialTeam\MPOSExport;
use Illuminate\Pagination\LengthAwarePaginator;

class Mpos extends Component implements UseExcelDataset, WithFormatting {

    use HasInfinityScroll, WithExportDate, UseOrderBy, ParseMonths, UseLocation, StreamExcelDownload;


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
    public $export_file_name = 'Payment_MIS_Reports_Cash_Tender_Wise_Sales';




    /**
     * end for filtering from dates
     * @var
     */
    public $store = '';




    public $stores = [];


    /**
     * Initialize variables
     * @return void
     */
    public function mount() {
        // getting the store data
        $this->cities = $this->_cities();
        $this->_months = $this->_months()->toArray();
        $this->perPage = 31;

        $this->stores = DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => auth()->user()->storeUID,
            'userId' => auth()->user()->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'users-stores'
        ]);
    }

    public function headers(): array {

        return [
            'Sales Date',
            'Store ID',
            'RETEK Code',
            'Brand Desc',
            'Cash',
        ];
    }


    public function loadMore(): void {
        $this->perPage += 31;
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
        $this->emit('resetAll');
        $this->emit('reset:all');
    }




    public function download(string $value): Collection|bool {

        $params = [
            'procType' => 'export',
            'storeId' => $this->store,
            'from' => $this->startdate,
            'to' => $this->enddate,
            'city' => trim($this->_city),
            'brand' => $this->_brand,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_MPOSSales :procType, :storeId, :city, :brand, :from, :to',
            $params,
            $this->perPage
        );
    }


    public function formatter(\App\Interface\Excel\SpreadSheet $worksheet, $dataset): void {

        $worksheet->setStartFrom(2);
        $worksheet->setFilename($this->_useToday($this->export_file_name, now()->format('d-m-Y')));
    }
    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->dataset();
        $this->brands = $this->_brands();

        // getting the main data
        return view('livewire.commercial-team.mpos', [
            'datas' => $dataset,
        ]);
    }



    /**
     * Get the aMain reports
     * @return LengthAwarePaginator
     */
    public function dataset() {

        $params = [
            'procType' => 'combined',
            'storeId' => $this->store,
            'from' => $this->startdate,
            'to' => $this->enddate,
            'city' => trim($this->_city),
            'brand' => $this->_brand,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_MPOSSales :procType, :storeId, :city, :brand, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }
}
