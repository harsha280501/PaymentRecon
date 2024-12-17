<?php

namespace App\Http\Livewire\CommercialHead\Exceptions;

use App\Exports\CommercialHead\Exception\CashExport;
use App\Exports\CommercialHead\Reports\MPOSExport;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\UseLocation;
use App\Traits\UseOrderBy;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Cash extends Component {

    use HasInfinityScroll, ParseMonths, UseLocation, UseOrderBy;



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



    /**
     * end for filtering from dates
     * @var
     */
    public $bank = '';



    /**
     * end for filtering from dates
     * @var
     */
    public $banks = [];




    public $stores = [];





    public $locations = [];




    /**
     * Initialize variables
     * @return void
     */
    public function mount() {
        $this->_months = $this->_months()->toArray();
        $this->locations = $this->_location();
        $this->stores = $this->_stores();
        $this->banks = $this->banks();
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
        $this->emit('resetAll');
    }




    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->dataset();
        //dd($dataset );
        // getting the main data
        return view('livewire.commercial-head.exceptions.cash', [
            'datas' => $dataset,
        ]);
    }


    public function banks() {
        $params = [
            'procType' => 'banks',
            'location' => $this->_location,
            'bank' => $this->bank,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_cash :procType, :location, :bank, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }





    public function export() {

        $params = [
            'procType' => 'export',
            'location' => $this->_location,
            'bank' => $this->bank,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        $dataset = DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_cash :procType, :location, :bank, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );


        return Excel::download(new CashExport(collect($dataset)), 'Payment_MIS_Exception_Cash_' . now()->format('Y_m_d') . '.xlsx');
    }





    /**
     * Get the aMain reports
     * @return LengthAwarePaginator
     */
    public function dataset() {

        $params = [
            'procType' => 'all',
            'location' => $this->_location,
            'bank' => $this->bank,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_cash :procType, :location, :bank, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }
}
