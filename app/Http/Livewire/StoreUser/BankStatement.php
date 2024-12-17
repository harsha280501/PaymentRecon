<?php

namespace App\Http\Livewire\StoreUser;

use App\Exports\StoreUser\BankStatementExport;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class BankStatement extends Component
{

    use WithPagination;

    protected $tableData;

    protected $bankTypes;

    public $activeTab = "hdfc";

    public $bankType;

    public $page = 1;

    public function mount()
    {
        $this->switchTab("hdfc");
    }

    /**
     * Switching between tabs
     * @param mixed $tab
     * @return void
     */
    public function switchTab($tab)
    {

        $this->activeTab = $tab;
        $types = $this->bankTypes();
        $this->bankType = Arr::first($types) ? Arr::first($types)->accountNo : '';
        $this->page = 1;
        $this->resetPage();

    }

    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        // default data

        // dd($this->loading);
        $bankMIS = $this->getData();
        $bankTypes = $this->bankTypes();

        // dd($this->loading);
        // main view
        return view('livewire.store-user.bank-statement', [
            'mis' => $bankMIS,
            'bankTypes' => $bankTypes
        ]);
    }


    public function bankTypes()
    {
        // $this->loading = true;
        return DB::select('PaymentMIS_PROC_SELECT_STOREUSER_ACCOUNT_BANK :BANK_NAME', [
            'BANK_NAME' => $this->activeTab,
        ]);
    }
    /**
     * Excel exports
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel()
    {
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

    /**
     * Get the main data
     * @return LengthAwarePaginator
     */
    public function getData()
    {
        $this->fetchData();

        if (!$this->tableData) {
            $this->tableData = collect([]);
        }
        // paginating the results
        return $this->paginate($this->tableData, 10, $this->page);
    }

    protected function fetchData()
    {
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

    public function getHDFCData()
    {
        // if upi data is asked

        return collect(DB::select('PaymentMIS_PROC_SELECT_STOREUSER_BANKSTATEMENT_HDFC :acctNo', [
            'acctNo' => $this->bankType
        ]));
    }

    public function getAxisData()
    {
        return collect(DB::select('PaymentMIS_PROC_SELECT_STOREUSER_BANKSTATEMENT_Axis :acctNo', [
            'acctNo' => $this->bankType
        ]));
    }


    public function getICICIData()
    {
        return collect(DB::select('PaymentMIS_PROC_SELECT_STOREUSER_BANKSTATEMENT_ICICI :acctNo', [
            'acctNo' => $this->bankType
        ]));

    }


    public function getSBIData()
    {
        return collect(DB::select('PaymentMIS_PROC_SELECT_STOREUSER_BANKSTATEMENT_SBI :acctNo', [
            'acctNo' => $this->bankType
        ]));
    }


    public function getIDFCData()
    {
        return collect(DB::select('PaymentMIS_PROC_SELECT_STOREUSER_BANKSTATEMENT_IDFC :acctNo', [
            'acctNo' => $this->bankType
        ]));
    }

    /**
     * Paginating the Data
     * @param mixed $items
     * @param mixed $perPage
     * @param mixed $page
     * @param mixed $options
     * @return LengthAwarePaginator
     */
    private function paginate($items, $perPage, $page, $options = [])
    {
        // getting the default page
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);

        // paginating the data
        $paginator = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
        // return panigated data
        return $paginator;
    }


    /**
     * Render pagination
     * @return string
     */
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
}
