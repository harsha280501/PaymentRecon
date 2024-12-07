<?php

namespace App\Http\Livewire\CommercialHead\Exceptions;

use App\Traits\HasInfinityScroll;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class AllSalesCollection extends Component {


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





    /**
     * end for filtering from dates
     * @var
     */
    public $stores = [];






    public function mount() {

        $this->store = '6136';
        $this->filtering = true;

        $params = [
            'procType' => 'stores',
            'storeId' => $this->store,
            'daterange' => '',
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        $this->stores = DB::infinite(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_All_card_wallet_UPI_Sales_Collection :procType, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage
        );
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




    public function export($value) {

        $params = [
            'procType' => 'export',
            'storeId' => $this->store,
            'daterange' => $value,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        $dataset = DB::infinite(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_All_card_wallet_UPI_Sales_Collection :procType, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage
        );

        return Excel::download(new \App\Exports\CommercialHead\Reports\AllCardWalletExport(collect($dataset)), 'all-sales-collection-export.xlsx');
    }



    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $dataset = $this->dataset('combined');

        // getting the main data
        return view('livewire.commercial-head.reports.all-sales-collection', [
            'datas' => $dataset,
        ]);
    }



    /**
     * Get the aMain reports
     * @return LengthAwarePaginator
     */
    public function dataset($dataset = 'combined') {

        $params = [
            'procType' => $dataset,
            'storeId' => $this->store,
            'daterange' => '',
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::infinite(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_All_card_wallet_UPI_Sales_Collection :procType, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage
        );
    }
}
