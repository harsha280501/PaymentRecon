<?php

namespace App\Http\Livewire\CommercialHead\Exceptions;


use App\Exports\CommercialHead\BankStatementExport;
use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use Maatwebsite\Excel\Facades\Excel;

class BankStatement extends Component {

    use HasTabs, HasInfinityScroll;

    protected $tableData;

    protected $bankTypes;

    public $activeTab = "hdfc";

    public $bankType;


    public function mount() {
        $this->switchTab("hdfc");
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
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        // default data

        // dd($this->loading);
        $bankMIS = $this->getData();
        $bankTypes = $this->bankTypes();

        // dd($this->loading);
        // main view
        return view('livewire.commercial-head.reports.bank-statement', [
            'mis' => $bankMIS,
            'bankTypes' => $bankTypes
        ]);
    }


    public function bankTypes() {
        // $this->loading = true;
        return DB::select('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_ACCOUNT_BANK :BANK_NAME', [
            'BANK_NAME' => $this->activeTab,
        ]);
    }
    /**
     * Excel exports
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel() {
        // if upi data is asked
        if ($this->activeTab === 'hdfc') {
            return Excel::download(new BankStatementExport($this->fetchData()), 'bank-statement.xlsx');
        }

        // if card data is fetched
        if ($this->activeTab === 'axis') {
            return Excel::download(new BankStatementExport($this->fetchData()), 'bank-statement.xlsx');
        }

        // if card data is fetched
        if ($this->activeTab === 'icici') {
            return Excel::download(new BankStatementExport($this->fetchData()), 'bank-statement.xlsx');
        }

        if ($this->activeTab === 'sbi') {
            return Excel::download(new BankStatementExport($this->fetchData()), 'bank-statement.xlsx');
        }


        if ($this->activeTab === 'idfc') {
            return Excel::download(new BankStatementExport($this->fetchData()), 'bank-statement.xlsx');
        }

        return Excel::download(new BankStatementExport($this->fetchData()), 'bank-statement.xlsx');
    }



    public function getData() {
        $this->fetchData();

        if (!$this->tableData) {
            $this->tableData = collect([]);
        }
        return $this->tableData;
    }

    protected function fetchData() {
        // if tab is hdfc
        if ($this->activeTab == 'hdfc') {
            $this->tableData = $this->getHDFCData();
        }
        // get requested tabs
        if ($this->activeTab == 'axis') {
            $this->tableData = $this->getAxisData();
        }
        // get requested tabs
        if ($this->activeTab == 'icici') {
            $this->tableData = $this->getICICIData();
        }
        // get requested tabs
        if ($this->activeTab == 'sbi') {
            $this->tableData = $this->getSBIData();
        }
        // get requested tabs
        if ($this->activeTab == 'idfc') {
            $this->tableData = $this->getIDFCData();
        }

        // get requested tabs
        if ($this->activeTab == 'wallet') {
            // dd($this->bankType);
            $this->tableData = $this->getWalletData();
        }

        if ($this->activeTab == 'amexpos') {
            $this->tableData = $this->getAmexPosData();
        }

        return $this->tableData;
    }

    public function getHDFCData() {
        return DB::infinite('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BANKSTATEMENT_HDFC :acctNo', [
            'acctNo' => $this->bankType
        ], $this->perPage);
    }

    public function getAxisData() {
        return DB::infinite('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BANKSTATEMENT_AXIS :acctNo', [
            'acctNo' => $this->bankType
        ], $this->perPage);
    }


    public function getICICIData() {
        return DB::infinite('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BANKSTATEMENT_ICICI :acctNo', [
            'acctNo' => $this->bankType
        ], $this->perPage);
    }


    public function getSBIData() {
        return DB::infinite('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BANKSTATEMENT_SBI :acctNo', [
            'acctNo' => $this->bankType
        ], $this->perPage);
    }


    public function getIDFCData() {
        return DB::infinite('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BANKSTATEMENT_IDFC :acctNo', [
            'acctNo' => $this->bankType
        ], $this->perPage);
    }
}