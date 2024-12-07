<?php

namespace App\Http\Livewire\CommercialTeam\Reports;


use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use App\Traits\StreamExcelDownload;
use App\Traits\UseDefaults;
use App\Traits\UseLocation;
use Illuminate\Support\Collection;


class UnAllocatedTransaction extends Component implements UseExcelDataset, WithHeaders {

    use HasInfinityScroll, HasTabs, UseOrderBy, ParseMonths, WithExportDate, UseLocation, UseDefaults;





    /**
     * activeTab
     * @var string
     */
    public $activeTab = 'cash';





    public $startdate = null;


    public $enddate = null;




    public $banks = [];








    /**
     * Location filter
     * @var array
     */
    public $locations = [];





    /**
     * Store Selection
     * @var string
     */
    public $location = '';





    /**
     * Store Selection
     * @var string
     */
    public $bank = '';



    /**
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Un_Allocated_Transaction';




    public $sync_tab_name = [
        'cash' => 'Cash_MIS',
        'card' => 'Card_MIS',
        'upi' => 'UPI_MIS',
        'wallet' => 'Wallet_MIS',
    ];



    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];




    /**
     * Resets all the properties
     * @return void
     */
    public function back() {
        $this->resetExcept('activeTab');
        $this->emit('resetAll');
    }




    /**
     * Get banks
     * @param string $tab
     * @return \Illuminate\Support\Collection
     */
    public function banks(): Collection {
        return \Illuminate\Support\Facades\DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALTEAM_REPORTS_UnAllocatedTransaction :procType, :bank, :location, :from, :to', [
            'procType' => $this->activeTab . '-banks',
            'bank' => '',
            'location' => '',
            'from' => '',
            'to' => '',
        ]);
    }




    // public function formatter(\App\Interface\Excel\SpreadSheet $worksheet, $dataset): void {
    //     $worksheet->setStartFrom(2);
    //     $worksheet->setFilename($this->_useToday($this->export_file_name . '_' . $this->sync_tab_name[$this->activeTab], now()->format('d-m-Y')));
    // }





    /**
     * ! I was in a hurry
     * @return mixed|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export() {

        $data = $this->download('');
        $headers = $this->headers();

        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }

        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists

        fputcsv($file, $headers);

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
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '_' . ucfirst($this->activeTab) . '"',
            ]
        );
    }






    public function headers(): array {
        if ($this->activeTab == 'cash') {
            return [
                "Deposit Date",
                "Pickupt Code",
                "Deposit Slip No",
                "Collection Bank",
                "Location",
                "Deposit Amount"
            ];
        }

        if ($this->activeTab == 'card') {
            return [
                "Deposit Date",
                "MID",
                "Collection Bank",
                "Deposit Amount",
            ];
        }

        if ($this->activeTab == 'upi') {
            return [
                "Deposit Date",
                "MID",
                "Collection Bank",
                "Deposit Amount",
            ];
        }

        return [
            "Deposit Date",
            "MID/TID",
            "Collection Bank",
            "Store Name",
            "Deposit Amount"
        ];
    }




    public function download($value = ''): Collection|bool {

        $params = [
            'procType' => $this->activeTab . '-export',
            'bank' => $this->bank,
            'location' => $this->location,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return \Illuminate\Support\Facades\DB::withOrderBySelect(
            '[PaymentMIS_PROC_SELECT_COMMERCIALTEAM_REPORTS_UnAllocatedTransaction_Exports] :procType, :bank, :location, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }





    public function dataset() {

        $params = [
            'procType' => $this->activeTab,
            'bank' => $this->bank,
            'location' => $this->location,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return \Illuminate\Support\Facades\DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Reports_UnAllocatedTransaction :procType, :bank, :location, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }







    /**
     * Render main content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $dataset = $this->dataset();
        $this->_months = $this->_months()->toArray();
        $this->banks = $this->banks();

        return view('livewire.commercial-team.reports.un-allocated-transaction', [
            'datas' => $dataset,
        ]);
    }

    
}
