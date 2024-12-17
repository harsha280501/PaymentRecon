<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Traits\HasTabs;
use Livewire\Component;

use App\Traits\HasInfinityScroll;
use Illuminate\Support\Facades\DB;

class TidMidMaster extends Component {

    use HasInfinityScroll, HasTabs;

    public $storemasterUID;
    public $userUID;
    public $activeTab = 'amexmid';

    public $dates;




    /**
     * Show the active tab on the url
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];


    public function render() {


        return view('livewire.admin.settings.tid-mid-master', [
            'dataset' => $this->dataset()
        ]);
    }



    public function dataset() {

        return DB::infinite('PaymentMIS_PROC_SELECT_ADMIN_TidMidMaster :tab', [
            'tab' => $this->activeTab
        ], $this->perPage);
    }
}