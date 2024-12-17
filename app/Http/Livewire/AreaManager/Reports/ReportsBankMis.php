<?php

namespace App\Http\Livewire\AreaManager\Reports;

use App\Exports\AreaManager\BankMIS\AmexposExport;
use App\Exports\AreaManager\BankMIS\AxisExport;
use App\Exports\AreaManager\BankMIS\HDFCExport;
use App\Exports\AreaManager\BankMIS\ICICIExport;
use App\Exports\AreaManager\BankMIS\IDFCExport;
use App\Exports\AreaManager\BankMIS\SBIExport;
use App\Exports\AreaManager\BankMIS\WalletExport;
use App\Exports\AreaManager\BankMIS\WalletPaytmExport;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ReportsBankMis extends Component
{


    use WithPagination;

    protected $tableData;

    protected $bankTypes;

    public $mainTypes = [
        'cash',
        'card',
        'upi',
        'phonepay',
        'paytm'
    ];


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

        $this->bankType = Arr::first($types);
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
        return view('livewire.area-manager.reports.reports-bank-mis', [
            'mis' => $bankMIS,
            'bankTypes' => $bankTypes
        ]);
    }

    /**
     * Get the bankTypes for specific banks
     * @return \Illuminate\Support\Collection
     */
    public function bankTypes()
    {
        // $this->loading = true;
        return DB::table('tbl_mBankTypes')
            ->where('bankName', $this->activeTab)
            ->pluck('bankType');
    }


    public function exportExcel()
    {

        if ($this->activeTab == 'hdfc') {
            return Excel::download(new HDFCExport($this->fetchData(), $this->bankType), 'hdfc-bankmis-export.xlsx');
        }
        if ($this->activeTab == 'axis') {
            return Excel::download(new AxisExport($this->fetchData(), $this->bankType), 'axis-bankmis-export.xlsx');
        }

        if ($this->activeTab == 'icici') {
            return Excel::download(new ICICIExport($this->fetchData(), $this->bankType), 'icici-bankmis-export.xlsx');
        }

        if ($this->activeTab == 'sbi') {
            return Excel::download(new SBIExport($this->fetchData(), $this->bankType), 'sbi-bankmis-export.xlsx');
        }

        if ($this->activeTab == 'idfc') {
            return Excel::download(new IDFCExport($this->fetchData(), $this->bankType), 'idfc-bankmis-export.xlsx');
        }
        if ($this->activeTab == 'wallet'){
            if ($this->bankType == 'phonepay') {
                return Excel::download(new WalletExport($this->fetchData(), $this->bankType), 'wallet-bankmis-export.xlsx');
            }
            elseif ($this->bankType == 'paytm') {
                return Excel::download(new WalletPaytmExport($this->fetchData(), $this->bankType), 'walletPt-bankmis-export.xlsx');
            }
        }


        if ($this->activeTab == 'amexpos') {
            return Excel::download(new AmexposExport($this->fetchData(), $this->bankType), 'amexpos-bankmis-export.xlsx');
        }

        return false;
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
        if ($this->bankType === 'upi') {
            return collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_BankMIS_HDFC :bankType', [
                'bankType' => 'UPI',
            ]));
        }

        // if card data is fetched
        if ($this->bankType === 'card') {
            return collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_BankMIS_HDFC :bankType', [
                'bankType' => 'Card'
            ]));
        }

        return collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_BankMIS_HDFC :bankType', [
            'bankType' => 'Cash'
        ]));
    }

    public function getAxisData()
    {
        return collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_BankMIS_Axis :bankType', [
            'bankType' => 'Cash',
        ]));
    }


    public function getICICIData()
    {
        // if card data is fetched
        if ($this->bankType === 'card') {
            return collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_BankMIS_ICICI :bankType', [
                'bankType' => 'Card'
            ]));
        }

        // default data
        return collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_BankMIS_ICICI :bankType', [
            'bankType' => 'Cash'
        ]));
    }


    public function getSBIData()
    {
        // if card data is fetched
        if ($this->bankType === 'card') {
            return collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_BankMIS_SBI :bankType', [
                'bankType' => 'Card',
            ]));
        }


        return collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_BankMIS_SBI :bankType', [
            'bankType' => 'Cash',
        ]));
    }


    public function getIDFCData()
    {
        return collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_BankMIS_IDFC :bankType', [
            'bankType' => 'Cash'
        ]));
    }


    public function getWalletData()
    {
        if($this->bankType=='paytm'){
            return collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_BankMIS_Wallet_PAYTM :bankType', [
                'bankType' => 'Paytm'
            ]));
        }

        return collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_BankMIS_Wallet :bankType', [
            'bankType' => 'PhonePay'
        ]));
    }

    public function getAmexPosData()
    {
        return collect(DB::select('PaymentMIS_PROC_SELECT_AREAMANAGER_BankMIS_Amexpos :bankType', [
            'bankType' => 'Card',
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
