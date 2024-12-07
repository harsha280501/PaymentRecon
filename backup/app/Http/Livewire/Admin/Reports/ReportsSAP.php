<?php

namespace App\Http\Livewire\Admin\Reports;


use App\Exports\Admin\SAPExport;
use App\Traits\HasInfinityScroll;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isNull;

class ReportsSAP extends Component {

    use HasInfinityScroll;



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



    public function mount() {
        // getting the store data
        $this->stores = DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => auth()->user()->storeUID,
            'userId' => auth()->user()->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'stores'
        ]);
    }



    /**
     * Export data
     * @param string $filter
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(string $filter) {
        dd('Exported');
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
        $this->reset();
        $this->emit('reset:all');
    }

    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $reports = $this->reports();

        // getting the main data
        return view('livewire.admin.reports-s-a-p', [
            'reports' => $reports
        ]);
    }



    /**
     * Get the aMain reports
     * @return array
     */
    public function reports() {

        $params = [
            'procType' => 'combined',
            'userId' => auth()->user()->userUID,
            'storeId' => auth()->user()->storeUID,
            'daterange' => $this->datewise,
            'from' => $this->startdate,
            'to' => $this->enddate,
            'store' => $this->store,
        ];

        return DB::infinite(
            'PaymentMIS_PROC_SELECT_ADMIN_SAPSales :procType, :userId, :storeId, :daterange, :from, :to, :store',
            $params,
            $this->perPage
        );
    }
}