<?php

namespace App\Http\Livewire\AreaManager\Reports;


use App\Exports\Admin\MPOSExport;
use App\Models\BankMSI;
use App\Traits\HasInfinityScroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Mpos extends Component {


    use HasInfinityScroll;


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
        $this->stores = DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => auth()->user()->storeUID,
            'userId' => auth()->user()->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'retekCodes'
        ]);
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
        $this->emit('reset:all');
    }



    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $dataset = $this->dataset();
        // getting the main data
        return view('livewire.area-manager.reports.mpos', [
            'datas' => $dataset
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
            'daterange' => $this->datewise,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::infinite(
            'PaymentMIS_PROC_SELECT_AREAMANAGER_MPOSSales :procType, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage
        );
    }
}