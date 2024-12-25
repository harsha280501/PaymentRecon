<?php

namespace App\Http\Livewire\StoreUser\Tracker;

use Livewire\Component;
use App\Traits\HasTabs;
use App\Traits\UseHelpers;
use App\Traits\ParseMonths;
use App\Traits\UseDefaults;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Facades\DB;

class OpeningBalanceAdjustments extends Component
{
    use HasInfinityScroll, HasTabs, ParseMonths, UseDefaults, UseHelpers;

    public $startDate = null;
    public $endDate = null;
    public $orderBy = 'desc';
    public $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Tracker_Opening_Balance_Adjustments';

    public function mount()
    {
        $this->_months = $this->_months()->toArray();
    }

    public function headers(): array
    {
        return [
            "DATE",
            "Store ID",
            "Cash Collection",
            "CARD Collection",
            "UPI Collection",
            "Wallet Collection",
            "Closing Balance",
        ];
    }

    public function content($file)
    {
        fputcsv($file, ['']);
    }

    public function getData()
    {
        return $this->fetchData('main');
    }

    public function download(string $value = '')
    {
        return $this->fetchData('export');
    }

    private function fetchData(string $procType)
    {
        $params = [
            'procType' => $procType,
            'store' => $this->isCommercialHeadUser ? null : auth()->user()->storeUID,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Tracker_Opening_Balance_Adjustments :procType, :store, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }

    public function render()
    {
        return view(
            'livewire.store-user.tracker.opening-balance-adjustments',
            ['datas' => $this->getData()]
        );
    }
}
