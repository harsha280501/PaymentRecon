<?php

namespace App\Http\Livewire\CommercialHead\Exceptions;

use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;
use App\Traits\ParseMonths;
use App\Traits\UseDefaults;
use App\Traits\UseOrderBy;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdjCollection extends Component {

    use HasInfinityScroll, ParseMonths, UseOrderBy, UseDefaults;





    /**
     * Storres Array
     * @var string
     */
    public $stores = [];






    /**
     * Storres Array
     * @var string
     */
    public $banks = [];







    /**
     * Store
     * @var string
     */
    public $store = '';





    /**
     * Store
     * @var string
     */
    public $bank = '';






    protected $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Exception_Adjustment_Collection';










    /**
     * Initialize variables
     * @return void
     */
    public function mount() {
        $this->_months = $this->_months()->toArray();
        $this->stores = $this->stores();
        $this->banks = $this->banks();
    }






    /**
     * Export functionality
     * @return void
     */
    public function export($dataset = [], $all = '') {

        $data = $this->download(!$all ? json_encode($dataset) : json_encode([]));
        $headers = $this->headers();

        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }

        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists

        fputcsv($file, $headers); // adding headers to the excel

        foreach ($data as $row) {
            $row = (array) $row;
            fputcsv($file, $row);
        }

        fclose($file);

        return response()->stream(
            function () use ($filePath) {
                echo file_get_contents($filePath);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '"',
            ]
        );
    }










    /**
     * Get the Main reports
     * @return LengthAwarePaginator
     */
    public function banks() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_Adjustment_Collection :procType, :store, :bank, :from, :to', [
                'procType' => 'banks',
                'store' => null,
                'bank' => null,
                'from' => null,
                'to' => null,
            ],
            $this->perPage,
            $this->orderBy
        );
    }






    /**
     * Get the Main reports
     * @return LengthAwarePaginator
     */
    public function stores() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_Adjustment_Collection :procType, :store, :bank, :from, :to', [
                'procType' => 'stores',
                'store' => null,
                'bank' => null,
                'from' => null,
                'to' => null,
            ],
            $this->perPage,
            $this->orderBy
        );
    }






    public function headers() {
        return [
            "Deposit Amount",
            "Credit Date",
            "Store ID",
            "Retek Code",
            "Brand Name",
            "Location",
            "Collection Bank",
            "Transaction Type",
            "Deposit Amount"
        ];
    }






    /**
     * Get the aMain reports
     * 
     */
    public function download(string $value = '') {

        $params = [
            'procType' => 'export',
            'store' => $this->store,
            'bank' => $this->bank,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_Adjustment_Collection :procType, :store,:bank, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }




    /**
     * Get the aMain reports
     * 
     */
    public function dataset() {

        $params = [
            'procType' => 'main',
            'store' => $this->store,
            'bank' => $this->bank,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_Adjustment_Collection :procType, :store, :bank, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }






    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->dataset();

        return view('livewire.commercial-head.exceptions.adj-collection', [
            'dataset' => $dataset,
        ]);
    }
}
