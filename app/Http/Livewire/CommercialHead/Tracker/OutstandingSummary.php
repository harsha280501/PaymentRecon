<?php

namespace App\Http\Livewire\CommercialHead\Tracker;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\StreamSimpleCSV;
use App\Traits\UseDefaults;
use App\Traits\UseHelpers;
use App\Traits\UseOrderBy;
use App\Traits\UseSyncFilters;
use App\Traits\WithExportDate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OutstandingSummary extends Component {

    use HasInfinityScroll, HasTabs, ParseMonths, UseDefaults, UseHelpers;




    public $stores = [];


    public $store = '';


    /**
     * Undocumented variable
     *
     * @var string
     */
    public $orderBy = 'desc';










    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Tracker_OutStanding_Summary';










    /**
     * Init
     * @return void
     */
    public function mount() {
        $this->_months = $this->_months()->toArray();
        $this->stores = $this->filters('stores');
    }







    /**
     * Headers for excel export
     * @return array
     */
    public function headers(): array {
        return [
            "Store ID", "Retek Code", "Brand",
            "Opening Balance", "Sales", "Collection",
            "Store Response", "Closing Balance",
        ];
    }




    public function content($file) {
        fputcsv($file, ['Balance on ' . Carbon::parse($this->startDate)->format('d-m-Y')]);
        fputcsv($file, ['']);
    }






    /**
     * Filters
     * @return void
     */
    public function filters(string $type) {

        $params = [
            'procType' => $type,
            'store' => $this->store,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_OutStanding_Summary :procType, :store, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }







    /**
     * Download dataset for excel
     * @param string $value
     * @return Collection|boolean
     */
    public function download(string $value = ''): Collection|bool {

        $params = [
            'procType' => 'export',
            'store' => $this->store,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_OutStanding_Summary :procType, :store, :from, :to',
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
            'store' => $this->store,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_OutStanding_Summary :procType, :store, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }




    /**
     * Render the view
     * @return View
     */
    public function render(): View {
        return view('livewire.commercial-head.tracker.outstanding-summary', [
            'datas' => $this->getData(),
        ]);
    }
}



