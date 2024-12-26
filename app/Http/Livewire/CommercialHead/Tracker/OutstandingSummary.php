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
use Illuminate\Http\Request;

class OutstandingSummary extends Component
{
    use HasInfinityScroll, HasTabs, ParseMonths, UseDefaults, UseHelpers, UseOrderBy;
    public $store = '';
    public $searchRoute = "tracker.outstanding-summary.searchStore";
    public $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Tracker_OutStanding_Summary';
    public $startDate = null;
    public $endDate = null;

    public function mount()
    {
        $this->_months = $this->_months()->toArray();
        $this->searchRoute;
    }

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
        fputcsv($file, ['Balance on ' . Carbon::parse($this->start)->format('d-m-Y')]);
        fputcsv($file, ['']);
    }

    public function filters(string $type)
    {
        return $this->fetchData($type);
    }

    public function download(string $value = ''): Collection|bool
    {
        return $this->fetchData('export');
    }

    public function getData()
    {
        return $this->fetchData('main');
    }

    private function fetchData($procType)
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

    public function searchStore(Request $request)
    {
        $searchTerm = $request->input('search');
        $params = [
            'procType' => 'stores',
            'store' => $this->store,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'PageSize' => $this->perPage,
            'orderBy' => $this->orderBy,
            'search' => $searchTerm ?? null,
        ];
        $stores = collect(DB::select(
            'EXEC PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_OutStanding_Summary
                        @procType = :procType,
                        @store = :store,
                        @from = :from,
                        @to = :to,
                        @PageSize = :PageSize,
                        @OrderBy = :orderBy,
                        @search = :search',
            $params
        ));
        $formattedStores = $stores->map(function ($store) {
            return [
                'id' => $store->storeID,
                'text' => $store->storeID,
            ];
        });

        return response()->json([
            'results' => $formattedStores
        ]);
    }

    public function render(): View
    {
        return view('livewire.commercial-head.tracker.outstanding-summary', [
            'datas' => $this->getData(),
        ]);
    }
}
