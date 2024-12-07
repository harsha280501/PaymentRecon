<?php

namespace App\Http\Livewire\AreaManager\Settings;

use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StoreMaster extends Component {

    use HasTabs, HasInfinityScroll;
    public $storemasterUID;
    public $userUID;


    public $dates;

    protected $datas;

    /**
     * Initialize variables
     * @return void
     */
    public function mount() {
        $this->storemasterUID = 24;
        $this->userUID = auth()->user()->userUID;
    }



    public function render() {

        $this->datas = $this->datas();

        // getting the main data
        return view('livewire.area-manager.settings.store-master', [
            'datas' => $this->datas,
            'dates' => $this->dates
        ]);
    }


    /**
     * Get the aMain reports
     * @return LengthAwarePaginator
     */
    public function datas() {
        return DB::infinite('PaymentMIS_PROC_SELECT_ADMIN_StoreMaster :PROC_TYPE', [
            'PROC_TYPE' => 'NEWSTOREMASTER',
        ], $this->perPage);
    }

}