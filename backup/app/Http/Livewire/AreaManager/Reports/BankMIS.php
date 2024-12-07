<?php

namespace App\Http\Livewire\AreaManager\Reports;

use App\Exports\Admin\BankMIS\AmexposExport;
use App\Exports\Admin\BankMIS\AxisExport;
use App\Exports\Admin\BankMIS\HDFCExport;
use App\Exports\Admin\BankMIS\ICICIExport;
use App\Exports\Admin\BankMIS\IDFCExport;
use App\Exports\Admin\BankMIS\SBIExport;
use App\Exports\Admin\BankMIS\WalletExport;
use App\Exports\Admin\BankMIS\WalletPaytmExport;
use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class BankMIS extends Component {


    use HasTabs, HasInfinityScroll;




    public $filtering = false;




    /**
     * Filter dates (start)
     * @var 
     */
    public $from = null;






    /**
     * Filter dates (end)
     * @var 
     */
    public $to = null;





    /**
     * search by bank
     */
    public $bankName = '';





    /**
     * Temp: Has Filters for the current Tab
     * @var array
     */
    public $implementedFilters = [
        'all-cash-mis',
        'all-card-mis',
        'all-wallet-mis',
    ];




    /**
     * Active Tab
     * @var string
     */
    public $activeTab = "all-cash-mis";




    /**
     * Date filter
     * @param mixed $obj
     * @return void
     */
    public function filterDates($obj) {
        $this->filtering = true;
        $this->from = $obj['start'];
        $this->to = $obj['end'];
    }


    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        // default data
        $bankMIS = $this->allBankMIS();

        // dd($this->loading);
        // main view
        return view('livewire.area-manager.reports.bank-m-i-s', [
            'mis' => $bankMIS
        ]);
    }

    /**
     * Export the filtered dataset
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export() {
        dd('Exported');
    }




    /**
     * Get the main data
     * @return mixed
     */
    public function allBankMIS() {

        // Main Params to the query
        $params = [
            'procType' => $this->activeTab,
            'bankName' => $this->bankName,
            'from' => $this->from,
            'to' => $this->to
        ];

        // Paginating the Query
        return DB::infinite(
            'PaymentMIS_PROC_SELECT_AREA_MANAGER_BankMIS_All_Bank_Reports_MIS :procType, :bankName, :from, :to',
            $params, $this->perPage
        );
    }


    /**
     * Updating the bank name triggers the back button
     * @param mixed $item
     * @return void
     */
    public function updated($item) {
        if ($item === 'bankName') {
            $this->filtering = true;
        }
    }


    /**
     * Reset all the filters
     * @return void
     */
    public function back() {
        $this->filtering = false;
        $this->resetExcept('activeTab');
        $this->emit('resetall');
    }

}