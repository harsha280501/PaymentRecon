<?php

namespace App\Http\Livewire\CommercialHead\Reports;

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
use Illuminate\Support\Facades\DB;



class UnAllocatedTransaction extends Component implements UseExcelDataset, WithHeaders {

    use HasInfinityScroll, HasTabs, UseOrderBy, ParseMonths, WithExportDate, UseLocation, StreamExcelDownload, UseDefaults;





    /**
     * activeTab
     * @var string
     */
    public $activeTab = 'cash';






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
    public $bank = '';







    

    /**
     * Store Selection
     * @var string
     */
    public $location = '';








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
        return \Illuminate\Support\Facades\DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_REPORTS_UnAllocatedTransaction :procType, :bank, :location, :from, :to', [
            'procType' => $this->activeTab . '-banks',
            'bank' => '',
            'location' => '',
            'from' => '',
            'to' => '',
        ]);
    }


    // $this->banks = $this->banks();



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
            '[PaymentMIS_PROC_SELECT_COMMERCIALHEAD_REPORTS_UnAllocatedTransaction_Exports] :procType, :bank, :location, :from, :to',
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
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_UnAllocatedTransaction :procType, :bank, :location, :from, :to',
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
        $this->_months = $this->_months()->toArray();

        return view('livewire.commercial-head.reports.un-allocated-transaction', [
            'datas' => $this->dataset(),
        ]);
    }






    public function updateUnAllocated(array $dataset) {

        $_main = $this->_generateQuery($this->activeTab, $dataset['bank']);

        if (!$_main) {
            return false;
        }


        $record = $_main->find($dataset['itemID']);

        
        if (!$record) {
            $this->emit('unallocated:failed', 'Unable to Find the Record');
            return false;
        }
        

        DB::beginTransaction();

        try {

            $record->update([
                "storeID" => $dataset['storeID'],
                "retekCode" => $dataset['retekCode'],
                "missingRemarks" => 'Valid',
                "unAllocatedStatus" => 'Valid',
                "unAllocatedRemarks" => $dataset['remarks'],
                "unAllocatedCorrectionDate" => now(),
                'isActive' => '1'
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('unallocated:failed', $th->getMessage());
            return false;
        }


        DB::commit();
        $this->emit('unallocated:success');
        return true;
    }




    public function _generateQuery(string $tab, string $bank) {
        try {
            $modelMap = $this->_models();
            return $modelMap[$tab][$bank] ?? null;
        } catch (\Throwable $th) {
            return null;
        }
    }



    public function _models() {
        return [
            'cash' => [
                'HDFC' => \App\Models\MFLInwardCashMISHdfcPos::query(),
                'SBI' => \App\Models\MFLInwardCashMIS2SBIPos::query(),
                'ICICI' => \App\Models\MFLinwardCashMISIciciPos::query(),
                'IDFC' => \App\Models\MFLInwardCashMISIdfcPos::query(),
                'AXIS' => \App\Models\MFLInwardCashMISAxisPos::query(),
            ],

            'card' => [
                'AMEX' => \App\Models\MFLInwardCardMISAmexPos::query(),
                'HDFC' => \App\Models\MFLInwardCardMISHdfcPos::query(),
                'ICICI' => \App\Models\MFLInwardCardMISIciciPos::query(),
                'SBI' => \App\Models\MFLInwardCardMISSBIPos::query(),
            ],

            'upi' => [
                'UPI' => \App\Models\MFLInwardUPIMISHdfcPos::query(),
            ],

            'wallet' => [
                'PayTM' => \App\Models\MFLInwardWalletMISPayTMPos::query(),
                'PhonePe' => \App\Models\MFLInwardWalletMISPhonePayPos::query()
            ]
        ];
    }
}
