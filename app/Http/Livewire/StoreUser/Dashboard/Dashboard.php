<?php

namespace App\Http\Livewire\StoreUser\Dashboard;

use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use App\Services\GeneralService;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component {



    public $tender_ = 'all';
    public $timeline_ = 'ThisYear';

    public $from = null;
    public $to = null;


    public $showFullStatsFor = ["Yesterday", "ThisWeek", "LastWeek"];


    public function filter(array $dataset) {
        $this->timeline_ = $dataset['timeline_'];
        $this->tender_ = $dataset['tender_'];
        $this->from = $dataset['from'];
        $this->to = $dataset['to'];
    }




    public function back() {
        $this->reset();
    }





    /**
     * Fetch main Dataset
     * @param string $procType
     * @return mixed
     */
    public function changeMainStats() {
        return DB::select('PaymentMIS_PROC_STOREUSER_SELECT_Dashboard_Summary_Dataset :procType, :storeId, :timeline, :from, :to', [
            'procType' => $this->tender_,
            'storeId' => auth()->user()->storeUID,
            'timeline' => $this->timeline_,
            'from' => $this->from,
            'to' => $this->to,
        ]);
    }




    /**
     * Fetch main Dataset
     * @param string $procType
     * @return mixed
     */
    public function changeBankStats() {
        return Arr::first(DB::select('PaymentMIS_PROC_STOREUSER_SELECT_Dashboard_Banks_Dataset :procType, :storeId, :timeline, :from, :to', [
            'procType' => $this->tender_,
            'storeId' => auth()->user()->storeUID,
            'timeline' => $this->timeline_,
            'from' => $this->from,
            'to' => $this->to,
        ]));
    }




    /**
     * Render the main function
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        return view('livewire.store-user.dashboard.dashboard', [
            'dataset_initial' => $this->changeMainStats(),
            'banks_initial' => $this->changeBankStats()
        ]);
    }
}