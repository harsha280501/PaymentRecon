<?php

namespace App\Http\Livewire\CommercialHead\Exceptions;


use App\Exports\CommercialHead\SAPExport;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ReportsSAP extends Component {


    use WithPagination;



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
     * Data for pagination
     * @var int
     */
    public $page = 1;



    /**
     * Data for pagination
     * @var int
     */
    public $perPage = 10;







    public function mount() {
        // getting the store data
        $this->stores = DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => auth()->user()->storeUID,
            'userId' => auth()->user()->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'storeIds'
        ]);
    }







    /**
     * Export data
     * @param string $filter
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(string $filter) {

        $params = [
            'procType' => 'export',
            'userId' => auth()->user()->userUID,
            'storeId' => auth()->user()->storeUID,
            'daterange' => $filter,
            'from' => $this->startdate,
            'to' => $this->enddate,
            'store' => $this->store,
            'PageNumber' => $this->page,
            'PageSize' => $this->perPage
        ];

        $collection = DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_SAPSales :procType, :userId, :storeId, :daterange, :from, :to, :store, :PageNumber, :PageSize',
            $params
        );

        return Excel::download(new SAPExport($collection), 'card-wallet-upi-export.xlsx');
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
        return view('livewire.commercial-head.reports.reports-s-a-p', [
            'reports' => $reports
        ]);
    }



    public function loadMore() {
        $this->perPage = $this->perPage + 10;
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
            'PageNumber' => $this->page,
            'PageSize' => $this->perPage
        ];

        return DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_SAPSales :procType, :userId, :storeId, :daterange, :from, :to, :store, :PageNumber, :PageSize',
            $params
        );
    }



    /**
     * Using simple bootstrap pagination
     * @return string
     */
    public function paginationView() {
        return 'vendor.livewire.bootstrap'; // Replace with your custom pagination view
    }
}
