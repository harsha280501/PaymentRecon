<?php

namespace App\Http\Livewire\CommercialHead\Exceptions;

use Livewire\Component;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReconciliationSummary extends Component {

    use HasInfinityScroll;


    /**
     * Filtering content
     * @var
     */
    public $filtering = false;


    public $startDate = null;


    public $endDate = null;




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



    /**
     * Filtering
     * @var string
     */
    public $storeId = '';

    protected $datas;

    public function mount() {

        $this->store = '6136';
        $this->filtering = true;

        $params = [
            'procType' => 'stores',
            'storeId' => $this->store,
            'daterange' => '',
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        $this->stores = DB::infinite(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Reconciliation_Summary :procType, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage
        );
    }




    public function render() {

        $this->datas = $this->datas();

        // getting the main data
        return view('livewire.commercial-head.reports.reconciliation-summary', [
            'datas' => $this->datas
        ]);
    }






    /**
     *Filters
     */
    public function filterDate($request) {
        $this->startDate = $request['start'];
        $this->endDate = $request['end'];
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
            'from' => '',
            'to' => '',
        ];

        $dataset = DB::infinite(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Reconciliation_Summary :procType, :storeId, :daterange, :from, :to',
            $params,
            $this->perPage
        );

        return Excel::download(new \App\Exports\CommercialHead\Reports\ReconSummary(collect($dataset)), 'recon-summary-export.xlsx');
    }





    /**
     * Get the aMain reports
     * @return array
     */
    public function datas() {
        return DB::infinite(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Reconciliation_Summary :procType, :storeId, :daterange, :from, :to',
            [
                'procType' => 'combined',
                'storeId' => $this->store,
                'daterange' => '',
                'from' => $this->startDate,
                'to' => $this->endDate
            ],

            perPage: $this->perPage
        );
    }
}
