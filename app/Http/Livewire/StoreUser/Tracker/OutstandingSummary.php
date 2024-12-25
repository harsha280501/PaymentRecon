<?php

namespace App\Http\Livewire\StoreUser\Tracker;

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
    public $startDate = null;
    public $endDate = null;
    public $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Tracker_OutStanding_Summary';

    public function mount()
    {
        $this->_months = $this->_months()->toArray();
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
        fputcsv($file, ['Balance on ' . Carbon::parse($this->startDate)->format('d-m-Y')]);
        fputcsv($file, ['']);
    }

    public function download(string $value = ''): Collection|bool
    {
        return $this->fetchData('export');
    }

    public function getData()
    {
        return $this->fetchData('main');
    }
    private function fetchData(string $procType)
    {
        $params = [
            'procType' => $procType,
            'store' => auth()->user()->storeUID,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        $outstandingSummary = DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_OutStanding_Summary :procType, :store, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
        return $outstandingSummary ?? [];
    }

    public function render(): View
    {
        return view('livewire.store-user.tracker.outstanding-summary', [
            'datas' => $this->getData(),
        ]);
    }
}



