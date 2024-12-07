<?php

namespace App\Http\Livewire\CommercialHead\Exceptions;

use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;
use App\Traits\ParseMonths;
use App\Traits\UseDefaults;
use App\Traits\UseOrderBy;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MailList extends Component {

    use HasInfinityScroll, HasTabs, ParseMonths, UseOrderBy, UseDefaults;




    public $activeTab = 'bankdrop-mismatch';








    /**
     * Storres Array
     * @var string
     */
    public $stores = [];







    /**
     * Store
     * @var string
     */
    public $store = '';






    protected $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Exception_Mail_List_BankDrop_mismatch';






    protected $queryString = [
        'activeTab' => ['as' => 'tab']
    ];








    /**
     * Initialize variables
     * @return void
     */
    public function mount() {
        $this->_months = $this->_months()->toArray();
        $this->stores = $this->stores();
    }





    /**
     * Reload the filters
     * @return void
     */
    public function back() {
        $this->emit('resetAll');
        $this->resetExcept('activeTab');
    }






    /**
     * Export function
     * @return void
     */
    public function export() {

        $data = $this->dataset();
        $headers = $this->headers();

        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }


        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists


        if ($this->activeTab == 'bankdrop-mismatch') {
            fputcsv($file, [
                '', 'Month to Date', '', '', '', '',
                'Year to Date', '', '', '', ''
            ]);

            fputcsv($file, [
                '', 'No. of Records', '', '', '', '',
                'No. of Records', '', '', '', ''
            ]);
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
            }, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '"',
            ]);
    }











    /**
     * Get the Main reports
     * @return LengthAwarePaginator
     */
    public function stores() {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_MailList :procType, :store, :from, :to', [
                'procType' => 'bankdrop-mismatch-stores',
                'store' => null,
                'from' => null,
                'to' => null,
            ],
            $this->perPage,
            $this->orderBy
        );
    }






    public function headers() {
        return [
            "Store ID",
            "Cash Tender",
            "Bankdrop ID Generated",
            "Bank drop ID Missing",
            "Matched Bank Deposit Slip",
            "Bank Deposit Slip missing",
            "Cash Tender",
            "Bankdrop ID Generated",
            "Bank drop ID Missing",
            "Matched Bank Deposit Slip",
            "Bank Deposit Slip missing"
        ];
    }






    /**
     * Get the aMain reports
     * @return LengthAwarePaginator
     */
    public function dataset() {

        $params = [
            'procType' => $this->activeTab . '-export',
            'store' => $this->store,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_MailList :procType, :store, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }






    /**
     * Lifecycle
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->dataset()->toArray();
        // dd($this->getUIDs($dataset));

        return view('livewire.commercial-head.exceptions.mail-list', [
            'dataset' => $dataset,
        ]);
    }
}
