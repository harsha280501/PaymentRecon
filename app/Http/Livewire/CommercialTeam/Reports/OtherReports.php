<?php

namespace App\Http\Livewire\CommercialTeam\Reports;


use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;
use App\Traits\ParseMonths;
use App\Traits\StreamExcelDownload;
use App\Traits\UseOrderBy;
use App\Traits\WithExportDate;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;




class OtherReports extends Component implements UseExcelDataset, WithHeaders {

    use HasInfinityScroll, WithExportDate, ParseMonths, HasTabs, UseOrderBy, StreamExcelDownload;


    /**
     * activeTab
     * @var string
     */
    public $activeTab = 'mpos-sap';




    /**
     * Select timeline
     * @var string
     */
    public $datewise = 'ThisYear';








    public $sync_tab_name = [
        'mpos-sap' => 'Mpos_Vs_Sap',
        'bank-drop-missing' => 'Bank_Drop_Missing',
        'zero-sales' => 'Zero_Sales',
        'overall-summary' => 'Outstanding_Summary',
        'chargeback-summary' => 'Chargeback_Summary',
    ];








    /**
     * Filtering content
     * @var
     */
    public $filtering = false;







    /**
     * StartDate for filtering from dates
     * @var
     */
    public $startdate = null;








    /**
     * end for filtering from dates
     * @var
     */
    public $enddate = null;










    /**
     * end for filtering from dates
     * @var
     */
    public $store = '';








    /**
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Other_Reports';








    /**
     * end for filtering from dates
     * @var
     */
    public $stores = [];









    /**
     * Display the Active Tab in the url
     *
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];








    /**
     * Initial Method
     *
     * @return void
     */
    public function mount() {
        $this->resetExcept('activeTab');
        $this->_months = $this->_months()->toArray();
        $this->stores = $this->stores();
    }










    /**
     * Resets all the properties
     * @return void
     */
    public function back() {
        $this->resetExcept('activeTab');
        $this->emit('reset:all');
        $this->emit('resetAll');
    }






    



    /**
     * Date filters
     * @param mixed $request
     * @return void
     */
    public function filterDate($request) {
        $this->startdate = $request['start'];
        $this->enddate = $request['end'];
        $this->filtering = true;
    }




    




    /**
     * Headers for Excel
     *
     * @return array
     */
    public function headers(): array {
        if ($this->activeTab == 'mpos-sap') {
            return [
                "Sales Date",
                "Store ID",
                "Retek Code",
                "Brand",
                "Status",
                "SAP Cash",
                "MPOS Cash",
                "Difference",
            ];
        }

        if ($this->activeTab == 'zero-sales') {
            return [
                "Sales Date",
                "Store ID",
                "Retek Code",
                "Brand",
                "Total Sales"
            ];
        }

        if ($this->activeTab == 'overall-summary') {
            return [

                "Store ID",
                "Retek Code",
                "Brand",
                "Month",
                "Opening Balance Cash",
                "Opening Balance Card",
                "Opening Balance UPI",
                "Opening Balance Wallet",
                "Sales Cash",
                "Sales Card",
                "Sales UPI",
                "Sales Wallet",
                "Collection Cash",
                "Collection Card",
                "Collection UPI",
                "Collection Wallet",
                "Closing Balance Cash",
                "Closing Balance Card",
                "Closing Balance UPI",
                "Closing Balance Wallet",
            ];
        }

        return [
            "Sales Date",
            "Credit Date",
            "Store ID",
            "Retek Code",
            "Brand",
            "TID",
            // "Bank",
            "Account No",
            "Description",
            "Transaction Branch",
            "Credit",
            "Debit",
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
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '_' . $this->sync_tab_name[$this->activeTab] . '"',
            ]
        );
    }








    /**
     * Returns Store List
     * @return array
     */
    public function stores() {
        return DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => auth()->user()->storeUID,
            'userId' => auth()->user()->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'users-stores'
        ]);
    }





    





    public function download($value = ''): Collection|bool {

        $params = [
            'procType' => $this->activeTab,
            'store' => $this->store,
            'from' => $this->startdate,
            'to' => $this->enddate
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Reports_Other_Reports_Exports :procType, :store, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }











    /**
     * Get the aMain reports
     * @return LengthAwarePaginator
     */
    public function dataset() {

        $params = [
            'procType' => $this->activeTab,
            'store' => $this->store,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Reports_Other_Reports :procType, :store, :from, :to',
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
        $dataset = $this->dataset();

        // getting the main data
        return view('livewire.commercial-team.reports.other-reports', [
            'datas' => $dataset,
        ]);
    }

}
