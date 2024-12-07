<?php

namespace App\Http\Livewire\Admin\Reports;

use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class Uploads extends Component {

    use HasInfinityScroll, HasTabs;

    public $activeTab = "hdfc-cash";

    public $filtering = false;

    public $filename = '';

    public $stores = [];

    public $store = '';


    public function mount() {
        $this->stores = $this->stores();
    }


    public function render() {

        $dataset = $this->dataset();

        return view('livewire.admin.reports.uploads', [
            'dataset' => $dataset
        ]);
    }


    public function back() {
        $this->resetExcept('activeTab');
        $this->emit('resetAll');
    }


    public function stores() {
        return DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => auth()->user()->storeUID,
            'userId' => auth()->user()->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'storeIds'
        ]);
    }


    public function dataset() {
        return DB::infinite('PaymentMIS_PROC_ADMIN_SELECT_uploads_records :procType, :fileName, :store', [
            'procType' => $this->activeTab,
            'fileName' => $this->filename,
            'store' => $this->store
        ], $this->perPage);
    }

}