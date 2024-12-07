<?php

namespace App\Http\Livewire\CommercialHead\Tracker;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\StreamSimpleCSV;
use App\Traits\UseDefaults;
use App\Traits\UseOrderBy;
use App\Traits\UseSyncFilters;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MposReconciliation2 extends Component implements UseExcelDataset, WithHeaders {

    use HasInfinityScroll, HasTabs, WithExportDate, ParseMonths, UseSyncFilters, UseDefaults;
    public $banks = [];






    /**
     * Undocumented variable
     *
     * @var string
     */
    public $orderBy = 'mposDate:desc';












    /**
     * Status Order by
     * @var string
     */
    public $status = '';












    /**
     * Filtering
     * @var string
     */
    public $bank = '';












    /**
     * Show bankdrop id and amount
     *
     * @var boolean
     */
    public $showBankDrop = false;










    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Tracker_Cash_Reconciliation';










    /**
     * Init
     * @return void
     */
    public function mount() {
        $this->reset();
        $this->_months = $this->_months()->toArray();
        $this->banks = $this->filters();
    }










    /**
     * Order by multiple columns
     *
     * @param [type] $col
     * @return void
     */
    public function orderBy($col) {
        // assigning the order
        $this->orderBy = $col . ':' . ($this->replaceWord($this->orderBy, $col) == 'asc' ? 'desc' : 'asc');
    }



    public function replaceWord($string, $word) {
        // Escape special characters in the word to avoid regex errors
        $escapedWord = preg_quote($word, '/');
    
        // Use regex to replace the word with an empty string
        $newString = preg_replace('/\b' . $escapedWord . '\b/', '', $string);
        
        return substr($newString, 1);
    }






    /**
     * Match status filter
     * @var string
     */
    public $matchStatus = '';





    /**
     * Headers for excel export
     * @return array
     */
    public function headers(): array {
        if ($this->showBankDrop) {

            return [
                "Sales Date",
                "Deposit Date",
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status",
                "Bank Drop ID",
                "BankDrop Amount",
                "Deposit SlipNo",
                "Tender Amount",
                "Deposit Amount",
                "Store Response Entry",
                "Difference [Tender - Deposit - Store Response]"
                
            ];
        }


        return [
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Col Bank",
            "Status",
            "Deposit SlipNo",
            "Tender Amount",
            "Deposit Amount",
            "Store Response Entry",
            "Difference [Tender - Deposit - Store Response]",
        ];
    }










    /**
     * Export Excel
     * @return void
     */
    public function export() {

        $data = $this->download('');
        $headers = $this->headers();
        $_totals = $this->getTotals();


        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }



        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists

        fputcsv($file, ['Total Count: ', $_totals[0]->TotalCount]);
        fputcsv($file, ['Matched Count: ', $_totals[0]->MatchedCount]);
        fputcsv($file, ['Not Matched Count: ', $_totals[0]->NotMatchedCount]);
        fputcsv($file, ['']);


        // IJKLM
        if ($this->showBankDrop) {
            fputcsv($file, ['', '', '', '', '', '', '', '', 'Total', $_totals[0]->sales_totalF, $_totals[0]->collection_totalF, $_totals[0]->adjustment_totalF, $_totals[0]->difference_totalF]);
        }
        if (!$this->showBankDrop) {
            fputcsv($file, ['', '', '', '', '', '', 'Total', $_totals[0]->sales_totalF, $_totals[0]->collection_totalF, $_totals[0]->adjustment_totalF, $_totals[0]->difference_totalF]);
        }

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
     * Filters
     * @return void
     */
    public function filters() {
        $params = [
            'procType' => 'cash-banks',
            'store' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->status,
            'bank' => $this->bank,
            'timeline' => '',
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_Mpos_Reconciliation2 :procType, :store, :brand, :location, :status,:bank,:timeline, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }





    /**
     * Sync filters
     * @param string $type
     * @return Collection|array
     */
    public function filtersSyncDataset(string $type): Collection|array {
        $params = [
            "procType" => $type,
            "store" => $this->_store,
            "brand" => $this->_brand,
            "location" => $this->_location
        ];

        return DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_Mpos_Reconciliation2_Filters :procType, :store, :brand, :location',
            $params
        );
    }








    /**
     * Get totals for both screen and excel
     * @return Collection|array
     */
    public function getTotals(): Collection|array {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_Mpos_Reconciliation2 :procType, :store, :brand, :location, :status,:bank,:timeline, :from, :to',
            [
                'procType' => "get_totals",
                'store' => $this->_store,
                'brand' => $this->_brand,
                'location' => $this->_location,
                'status' => $this->matchStatus,
                'bank' => $this->bank,
                'timeline' => '',
                'from' => $this->startDate,
                'to' => $this->endDate,
            ],
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }








    /**
     * Download dataset for excel
     * @param string $value
     * @return Collection|boolean
     */
    public function download(string $value = ''): Collection|bool {

        $params = [
            'procType' => $this->showBankDrop
                ? 'withBankdrop-export'
                : 'withoutBankdrop-export',
            'store' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->matchStatus,
            'bank' => $this->bank,
            'timeline' => $value,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_Mpos_Reconciliation2 :procType, :store, :brand , :location, :status,:bank, :timeline, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }







    /**
     * Data source
     * @return array
     */
    public function getData() {

        $params = [
            'procType' => 'main',
            'store' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->matchStatus,
            'bank' => $this->bank,
            'timeline' => '',
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_Mpos_Reconciliation2 :procType, :store, :brand, :location, :status,:bank, :timeline, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }




    /**
     * Render the view
     * @return View
     */
    public function render(): View {
        return view('livewire.commercial-head.tracker.mpos-reconciliation2', [
            'cashRecons' => $this->getData(),
            '_totals' => $this->getTotals()
        ]);
    }
}
