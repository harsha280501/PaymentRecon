<?php

namespace App\Http\Livewire\CommercialHead\Reports;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithHeaders;

use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\HasInfinityScroll;
use App\Traits\UseDefaults;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FranchiseeDebit extends Component implements UseExcelDataset, WithHeaders {

    use HasInfinityScroll, UseOrderBy, ParseMonths, WithExportDate, UseDefaults;



    /**
     * Store Filter
     * @var array
     */
    public $stores = [];






    /**
     * Store selectore
     * @var array
     */
    public $store = '';






    /**
     * Store Filter
     * @var array
     */
    public $brands = [];






    /**
     * Store selectore
     * @var array
     */
    public $brand = '';







    

    /**
     * Store Filter
     * @var array
     */
    public $banks = [];






    /**
     * Store selectore
     * @var array
     */
    public $bank = '';







    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Franchise_Debit';







    /**
     * Initializing months
     * @return void
     */
    public function mount() {
        $this->_months = $this->_months()->toArray();
        $this->stores = $this->filters(type: 'stores');
        $this->brands = $this->filters(type: 'brands');
        $this->banks = $this->filters(type: 'banks');
    }






    /**
     * Headers for the Export
     * @return array
     */
    public function headers(): array {
        return [
            "Store ID",
            "Brand",
            "Tender",
            "Sales Period",
            "Date Of Debit",
            "Document No",
            "Amount"
        ];
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
     * Download Excel
     * @param string $value
     * @return Collection|boolean
     */
    public function filters($type): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Franchisee_debit :procType, :store, :brand, :bank, :from, :to',
            [
                'procType' => $type,
                'store' => $this->store,
                'brand' => $this->brand,
                'bank' => $this->bank,
                'from' => $this->startDate,
                'to' => $this->endDate
            ],
            perPage: $this->perPage,
            orderBy: 'asc'
        );
    }






    /**
     * Download Excel
     * @param string $value
     * @return Collection|boolean
     */
    public function download($value = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Franchisee_debit  :procType, :store, :brand, :bank, :from, :to',
            [
                'procType' => 'export',
                'store' => $this->store,
                'brand' => $this->brand,
                'bank' => $this->bank,
                'from' => $this->startDate,
                'to' => $this->endDate
            ],
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }






    /**
     * Data source
     * @return array
     */
    public function getData() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Franchisee_debit :procType, :store, :brand, :bank, :from, :to',
            [
                'procType' => 'main',
                'store' => $this->store,
                'brand' => $this->brand,
                'bank' => $this->bank,
                'from' => $this->startDate,
                'to' => $this->endDate
            ],
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }






    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->getData();
        
        return view('livewire.commercial-head.reports.franchisee-debit', [
            'cashRecons' => $dataset
        ]);
    }
}
