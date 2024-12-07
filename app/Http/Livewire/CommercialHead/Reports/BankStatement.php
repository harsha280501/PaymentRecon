<?php

namespace App\Http\Livewire\CommercialHead\Reports;


use App\Exports\CommercialHead\BankStatementExport;
use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;
use App\Traits\ParseMonths;
use App\Traits\StreamExcelDownload;
use App\Traits\UseOrderBy;
use App\Traits\WithExportDate;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BankStatement extends Component implements UseExcelDataset, WithHeaders {

    use HasTabs, HasInfinityScroll, UseOrderBy, WithExportDate, ParseMonths;






    /**
     * Update Search value
     * @var array
     */
    protected $listeners = [
        'searchUpdated'
    ];







    /**
     * Has Tabs
     * @var string
     */
    public string $activeTab = "hdfc";









    /**
     * Show the Back Arrow
     *
     * @var boolean
     */
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
     * Account Number for the Dataset
     *
     * @var [type]
     */
    public $bankType;








    /**
     * Search String to Store it in the DB
     *
     * @var string
     */
    public $search = '';









    /**
     * Query String to Display
     * @var array
     */
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
        $this->_months = $this->_months()->toArray();
    }







    
    /**
     * Update the Search variable
     * @param string $search
     * @return void
     */
    public function searchUpdated(string $search) {
        $this->search = $search;
    }







    
    /**
     * Date filter
     * @param mixed $obj
     * @return void
     */
    public function filterDate($obj) {
        $this->filtering = true;
        $this->from = $obj['start'];
        $this->to = $obj['end'];
    }








    /**
     * Reset all the filters
     * @return void
     */
    public function back() {
        $this->filtering = false;
        $this->resetExcept(['activeTab', 'bankType']);
        $this->emit('resetall');
        $this->emit('resetAll');
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
            "Description",
            "Debit",
            "Credit"
        ];
    }



    
    



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
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '_' . strtoupper($this->activeTab) . '"',
            ]
        );
    }







    /**
     * Switching between tabs
     * @param mixed $tab
     * @return void
     */
    public function switchTab($tab) {
        $this->resetExcept('activeTab');
        $this->emit('resetAll');

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
        return DB::select('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_ACCOUNT_BANK :BANK_NAME', [
            'BANK_NAME' => $this->activeTab,
        ]);
    }








    /**
     * Download excel
     * @param mixed $value
     * @return \Illuminate\Support\Collection|bool
     */
    public function download($value = ''): Collection|bool {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Bank_Statement :procType, :acctNo, :search, :from, :to', [
            'procType' => $this->activeTab . '-export',
            'acctNo' => $this->bankType,
            'search' => $this->search,
            'from' => $this->from,
            'to' => $this->to,
        ], $this->perPage, $this->orderBy);
    }






    /**
     * Get the Main Dataset
     * @return mixed
     */
    public function getData() {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Bank_Statement :procType, :acctNo, :search, :from, :to', [
            'procType' => $this->activeTab,
            'acctNo' => $this->bankType,
            'search' => $this->search,
            'from' => $this->from,
            'to' => $this->to,
        ], $this->perPage, $this->orderBy);
    }







    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $bankMIS = $this->getData();
        $bankTypes = $this->bankTypes();

        return view('livewire.commercial-head.reports.bank-statement', [
            'mis' => $bankMIS,
            'bankTypes' => $bankTypes
        ]);
    }
}