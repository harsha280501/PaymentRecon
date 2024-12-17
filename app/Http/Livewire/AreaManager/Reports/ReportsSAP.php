<?php

namespace App\Http\Livewire\AreaManager\Reports;

use App\Exports\AreaManager\SAPExport;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ReportsSap extends Component
{


    use WithPagination;

    public $dateFilter = 'SAPsales';

    public $searching;

    public $dateError = false;

    public $startDate;
    public $endDate;

    public $storeUID;
    public $userUID;

    /**
     * Data for pagination
     * @var int
     */
    public $perPage = 10;

    /**
     * Data for pagination
     * @var int
     */
    public $page = 1;

    public $dates;

    protected $reports;

    /**
     * Initialize variables
     * @return void
     */
    public function mount()
    {
        $this->storeUID = 57109;
        $this->userUID = auth()->user()->userUID;

        // forget the previous
        Cache::forget('commercial-head-sap-date-filer-dates');
    }

    /**
     *Export yesterday
     */

    public function exportYesterday()
    {
        $collection = collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_SAPSales :PROC_TYPE, :PROC_USERID, :PROC_STOREID, :PROC_FROMDATE, :PROC_ENDDATE', [
            'PROC_TYPE' => 'Yesterday',
            'PROC_USERID' => $this->userUID,
            'PROC_STOREID' => $this->storeUID,
            'PROC_FROMDATE' => null,
            'PROC_ENDDATE' => null
        ]));

        //dd($collection);
        return Excel::download(new SAPExport($collection), 'main.xlsx');
    }


    public function exportThisWeek()
    {
        $collection = collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_SAPSales :PROC_TYPE, :PROC_USERID, :PROC_STOREID, :PROC_FROMDATE, :PROC_ENDDATE', [
            'PROC_TYPE' => 'ThisWeek',
            'PROC_USERID' => $this->userUID,
            'PROC_STOREID' => $this->storeUID,
            'PROC_FROMDATE' => null,
            'PROC_ENDDATE' => null
        ]));

        return Excel::download(new SAPExport($collection), 'main.xlsx');
    }


    public function exportThisMonth()
    {
        $collection = collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_SAPSales :PROC_TYPE, :PROC_USERID, :PROC_STOREID, :PROC_FROMDATE, :PROC_ENDDATE', [
            'PROC_TYPE' => 'ThisMonth',
            'PROC_USERID' => $this->userUID,
            'PROC_STOREID' => $this->storeUID,
            'PROC_FROMDATE' => null,
            'PROC_ENDDATE' => null
        ]));

        return Excel::download(new SAPExport($collection), 'main.xlsx');
    }


    public function exportThisYear()
    {
        $collection = collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_SAPSales :PROC_TYPE, :PROC_USERID, :PROC_STOREID, :PROC_FROMDATE, :PROC_ENDDATE', [
            'PROC_TYPE' => 'ThisYear',
            'PROC_USERID' => $this->userUID,
            'PROC_STOREID' => $this->storeUID,
            'PROC_FROMDATE' => null,
            'PROC_ENDDATE' => null
        ]));

        return Excel::download(new SAPExport($collection), 'main.xlsx');
    }


    /**
     * Updating the filters
     * @param mixed $item
     * @return void
     */
    public function updating($item)
    {
        if ($item == 'dateFilter') {
            $this->searching = false;
            $this->page = 1;

            // forget the previous
            Cache::forget('commercial-head-mpos-date-filer-dates');
        }
    }

    /**
     * Six Months
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportSixMonth()
    {
        $collection = collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_SAPSales :PROC_TYPE, :PROC_USERID, :PROC_STOREID, :PROC_FROMDATE, :PROC_ENDDATE', [
            'PROC_TYPE' => 'SixMonths',
            'PROC_USERID' => $this->userUID,
            'PROC_STOREID' => $this->storeUID,
            'PROC_FROMDATE' => null,
            'PROC_ENDDATE' => null
        ]));

        return Excel::download(new SAPExport($collection), 'main.xlsx');
    }

    /**
     *Filters
     */
    public function filterDate($request)
    {

        $this->page = 1;


        if ($request['start'] == "" || $request['end'] == "") {
            $this->dateError = true;
            return false;
        }

        $this->searching = true;

        $this->startDate = $request['start'];
        $this->endDate = $request['end'];

        Cache::put('commercial-head-sap-date-filer-dates', [
            'start' => $this->startDate,
            'end' => $this->endDate,
        ], 5000);
    }

    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->reports = $this->reports();

        $this->dates = Cache::has('commercial-head-sap-date-filer-dates') ? Cache::get('commercial-head-sap-date-filer-dates') : ['start' => null, 'end' => null];


        // getting the main data
        return view('livewire.area-manager.reports.reports-sap', [
            'reports' => $this->reports,
            'dates' => $this->dates
        ]);
    }


    /**
     * Get the aMain reports
     * @return LengthAwarePaginator
     */
    public function reports()
    {
        $collection = collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_SAPSales :PROC_TYPE, :PROC_USERID, :PROC_STOREID, :PROC_FROMDATE, :PROC_ENDDATE', [
            'PROC_TYPE' => $this->searching ? 'DateRange' : $this->dateFilter,
            'PROC_USERID' => $this->userUID,
            'PROC_STOREID' => $this->storeUID,
            'PROC_FROMDATE' => $this->startDate,
            'PROC_ENDDATE' => $this->endDate
        ]));

        return $this->paginate($collection, $this->perPage, $this->page);
    }

    /**
     * Paginating the Data
     * @param mixed $items
     * @param mixed $perPage
     * @param mixed $page
     * @param mixed $options
     * @return LengthAwarePaginator
     */
    private function paginate($items, $perPage, $page, $options = [])
    {
        // getting the default page
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);

        // paginating the data
        $paginator = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
        // return panigated data
        return $paginator;
    }

    /**
     * Using simple bootstrap pagination
     * @return string
     */
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap'; // Replace with your custom pagination view
    }
}
