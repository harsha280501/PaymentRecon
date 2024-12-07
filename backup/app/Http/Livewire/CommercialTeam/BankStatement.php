<?php

namespace App\Http\Livewire\CommercialTeam;

use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\UseOrderBy;
use Illuminate\Support\Arr;
use Livewire\WithPagination;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use App\Interface\Excel\WithHeaders;
use Maatwebsite\Excel\Facades\Excel;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;
use App\Exports\CommercialTeam\BankStatementExport;

class BankStatement extends Component implements UseExcelDataset, WithHeaders, WithFormatting {

    use HasTabs, HasInfinityScroll, UseOrderBy, WithExportDate, StreamExcelDownload;


    public $activeTab = "hdfc";




    public $bankType;





    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];




    /**
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Bank_Statement';






    /**
     * Initializing tab
     * @return void
     */
    public function mount() {
        // the account number is not selected without switching the tab to te same tab  
        $this->switchTab('hdfc');
    }





    /**
     * Switching between tabs
     * @param mixed $tab
     * @return void
     */
    public function switchTab($tab) {
        $this->resetExcept('activeTab');
        $this->activeTab = $tab;
        $types = $this->bankTypes();
        $this->bankType = Arr::first($types) ? Arr::first($types)->accountNo : '';
    }



    /**
     * Get Account number
     * @return array
     */
    public function bankTypes() {
        // $this->loading = true;
        return DB::select('PaymentMIS_PROC_SELECT_COMMERCIALTEAM_ACCOUNT_BANK :BANK_NAME', [
            'BANK_NAME' => $this->activeTab,
        ]);
    }





    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $bankMIS = $this->getData();
        $bankTypes = $this->bankTypes();

        return view('livewire.commercial-team.bank-statement', [
            'mis' => $bankMIS,
            'bankTypes' => $bankTypes
        ]);
    }




    /**
     * Download excel
     * @param mixed $value
     * @return \Illuminate\Support\Collection|bool
     */
    public function download($value = ''): Collection|bool {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Reports_Bank_Statement :procType, :acctNo', [
            'procType' => $this->activeTab . '-export',
            'acctNo' => $this->bankType
        ], $this->perPage, $this->orderBy);
    }



    /**
     * Headers for export
     * @return array
     */
    public function headers(): array {
        return [
            "Credit Date",
            "Deposit Date",
            "Reference Number",
            "Transaction Branch",
            "Credit",
            "Debit"
        ];
    }

    /**
     * Format for the Excel
     * @param \App\Interface\Excel\SpreadSheet $worksheet
     * @param mixed $dataset
     * @return void
     */
    public function formatter(\App\Interface\Excel\SpreadSheet $worksheet, $dataset): void {
        $worksheet->setStartFrom(2);
        $worksheet->setFilename($this->_useToday($this->export_file_name . '_' . strtoupper($this->activeTab), now()->format('d-m-Y')));
    }



    /**
     * Get the Main Dataset
     * @return mixed
     */
    public function getData() {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Reports_Bank_Statement :procType, :acctNo', [
            'procType' => $this->activeTab,
            'acctNo' => $this->bankType
        ], $this->perPage, $this->orderBy);
    }
}
