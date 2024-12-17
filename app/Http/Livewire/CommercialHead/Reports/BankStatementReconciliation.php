<?php

namespace App\Http\Livewire\CommercialHead\Reports;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasTabs;
use Livewire\Component;
use App\Interface\UseTabs;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\HasInfinityScroll;
use App\Traits\UseDefaults;
use App\Traits\UseSyncFilters;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;



class BankStatementReconciliation extends Component implements UseExcelDataset, WithHeaders {

    use HasInfinityScroll, HasTabs, UseOrderBy, ParseMonths, WithExportDate, UseDefaults, UseSyncFilters;







    protected $queryString = [
        'activeTab' => ['as' => 'tab']
    ];






    public $activeTab = 'cash';




    /**
     * Banks
     */
    public $banks = [];




    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_BankStatement_Reconciliation';







    public $status = '';



    public $bank = '';




    public function mount() {
        $this->resetExcept('activeTab');
        $this->_months = $this->_months()->toArray();
    }




    /**
     * Reload the filters
     * @return void
     */
    public function back() {
        $this->emit('resetAll');
        $this->resetExcept('activeTab');
    }






    public function headers(): array {
        if ($this->activeTab == 'card') {
            return [
                "Credit Date",
                "Deposit Date",
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status",
                "Msf Commission",
                "Gst Total",
                "Credit Amount",
                "Net Amount",
                "Store Response Entry",
                "Difference[Credit - Deposit - Store Response]"
            ];
        }

        if ($this->activeTab == 'wallet') {
            return [
                "Credit Date",
                "Deposit Date",
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status",
                "Reference Number",
                "Net MIS Amount",
                "Credit Amount",
                "Store Response Entry",
                "Difference [Net Amt - Cr Amt - Store Response]",
                'Store Gouping Remarks'
            ];
        }

        if ($this->activeTab == 'upi') {
            return [
                "Credit Date",
                "Deposit Date",
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status	",
                "Bank Deposit Date",
                "Msf Commission",
                "Gst Total",
                "Credit Amount",
                "Net Amount",
                "Store Response Entry",
                "Difference[Credit - Deposit - Store Response]"
            ];
        }

        return [
            "Credit Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Location",
            "Col Bank",
            "Status",
            "Depost Slip No",
            "Credit Amount",
            "Deposit Amount",
            "Store Response Entry",
            "Difference[Credit - Deposit - Store Response]"
        ];
    }





    public function banks(string $type) {
        return DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_BankStatement_Reconciliation_Filters :procType, :store, :brand, :location', [
            'procType' => $type,
            "store" => $this->_store,
            "brand" => $this->_brand,
            "location" => $this->_location
        ]);
    }



    public function filtersSyncDataset(string $type) {
        return DB::select('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_BankStatement_Reconciliation_Filters :procType, :store, :brand, :location', [
            'procType' => $this->activeTab . $type,
            "store" => $this->_store,
            "brand" => $this->_brand,
            "location" => $this->_location
        ]);
    }

    public function export() {

        $data = $this->download('');
        $headers = $this->headers();
        $_totals = $this->_totals();


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



        if ($this->activeTab == 'cash') {
            fputcsv($file, ['', '', '', '', '', '', '', 'Total', $_totals[0]->sales_totalF, $_totals[0]->collection_totalF, $_totals[0]->adjustment_totalF, $_totals[0]->difference_totalF]);
        }
        if ($this->activeTab == 'card') {
            fputcsv($file, ['', '', '', '', '', '', '', 'Total', $_totals[0]->sales_totalF, $_totals[0]->collection_totalF, $_totals[0]->adjustment_totalF, $_totals[0]->difference_totalF]);
        }
        if ($this->activeTab == 'upi') {
            fputcsv($file, ['', '', '', '', '', '', '', '', 'Total', $_totals[0]->sales_totalF, $_totals[0]->collection_totalF, $_totals[0]->adjustment_totalF, $_totals[0]->difference_totalF]);
        }
        if ($this->activeTab == 'wallet') {
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




    public function _totals() {
        return DB::withOrderBySelect(
            storedProcedure: 'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_BankStatement_Reconciliation :procType, :store, :location, :brand, :bank, :status, :from, :to',
            params: [
                'procType' => $this->activeTab . '_totals',
                'store' => $this->_store,
                'location' => $this->_location,
                'brand' => $this->_brand,
                'bank' => $this->bank,
                'status' => $this->status,
                'from' => $this->startDate,
                'to' => $this->endDate
            ],
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }





    public function download($value = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_BankStatement_Reconciliation_Export :procType, :store, :location, :brand, :bank, :status, :from, :to',
            [
                'procType' => $this->activeTab,
                'store' => $this->_store,
                'location' => $this->_location,
                'brand' => $this->_brand,
                'bank' => $this->bank,
                'status' => $this->status,
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
            storedProcedure: 'PaymentMIS_PROC_COMMERCIALHEAD_SELECT_BankStatement_Reconciliation :procType, :store, :location, :brand, :bank, :status, :from, :to',
            params: [
                'procType' => $this->activeTab,
                'store' => $this->_store,
                'location' => $this->_location,
                'brand' => $this->_brand,
                'bank' => $this->bank,
                'status' => $this->status,
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
        $this->banks = $this->filtersSyncDataset('_banks');

        return view('livewire.commercial-head.reports.bank-statement-reconciliation ', [
            'cashRecons' => $this->getData(),
            '_totals' => $this->_totals()
        ]);
    }
}
