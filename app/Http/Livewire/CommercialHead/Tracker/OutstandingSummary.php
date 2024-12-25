<?php

namespace App\Http\Livewire\CommercialHead\Tracker;

use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\UseDefaults;
use App\Traits\UseHelpers;
use App\Traits\UseOrderBy;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OutstandingSummary extends Component
{

    use HasInfinityScroll, HasTabs, ParseMonths, UseDefaults, UseHelpers, UseOrderBy;
    public $stores = [];
    public $store = '';
    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Tracker_OutStanding_Summary';
    /**
     * Init
     * @return void
     */
    public function mount()
    {
        $this->_months = $this->_months()->toArray();
        $this->stores = $this->filters('stores') ?? [];
    }

    /**
     * Headers for excel export
     * @return array
     */
    public function headers(): array
    {
        return [
            "Store ID",
            "Retek Code",
            "Brand",
            "Opening Balance",
            "Sales",
            "Collection",
            "Store Response",
            "Closing Balance",
        ];
    }

    public function content($file)
    {
        fputcsv($file, ['Balance on ' . Carbon::parse($this->startDate)->format('d-m-Y')]);
        fputcsv($file, ['']);
    }

    /**
     * Filters
     * @return void
     */
    public function filters(string $type)
    {
        return $this->fetchData($type);
    }

    /**
     * Download dataset for excel
     * @param string $value
     * @return Collection|boolean
     */
    public function download(string $value = ''): Collection|bool
    {
        return $this->fetchData('export', true);
    }

    /**
     * Data source
     * @return array
     */
    public function getData()
    {
        return $this->fetchData('main', true);
    }

    private function fetchData($procType, $needOP = false)
    {
        $params = [
            'procType' => $procType,
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
    public function render(): View
    {
        return view('livewire.commercial-head.tracker.outstanding-summary', [
            'datas' => $this->getData(),
        ]);
    }
}
