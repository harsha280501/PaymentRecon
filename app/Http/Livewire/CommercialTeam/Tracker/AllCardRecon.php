<?php

namespace App\Http\Livewire\CommercialTeam\Tracker;

use Livewire\Component;
use App\Traits\UseOrderBy;

use App\Traits\ParseMonths;

use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Interface\Excel\UseExcelDataset;
use App\Traits\UseDefaults;
use App\Traits\UseSyncFilters;

class AllCardRecon extends Component implements UseExcelDataset {

    use HasInfinityScroll, WithExportDate, ParseMonths, UseOrderBy, UseSyncFilters, UseDefaults;




    /**
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIALTEAM_Tracker_All_Tender_Reconciliation';






    /**
     * Quering the search url
     * @var array
     */
    protected $queryString = [
        'startDate' => ['as' => 'from', 'except' => ''],
        'endDate' => ['as' => 'to', 'except' => ''],
    ];





    /**
     * Matched status filter 
     * @var string
     */
    public $status = '';







    /**
     * Initializ the component
     * @return void
     */
    public function mount() {
        $this->reset();
        $this->_months = $this->_months()->toArray();
    }




    public function headers(): array {

        return [
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Brand",
            "Location",

            "Card Sales",
            "UPI Sales",
            "Wallet Sales",
            "Cash Sales",
            "Total Sales",

            "Card Collection",
            "UPI Collection",
            "Wallet Collection",
            "Cash Collection",
            "Total Collection",

            "Card Store Reponse",
            "UPI Store Reponse",
            "Wallet Store Reponse",
            "Cash Store Reponse",
            "Total Store Reponse",

            "Card Difference",
            "UPI Difference",
            "Wallet Difference",
            "Cash Difference",
            "Total Difference",
            "Status"
        ];
    }






    /**
     * ! I was in a hurry
     * @return mixed|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export() {

        $data = $this->download('');
        $headers = $this->headers();
        $_totals = $this->getTotals();

        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists

        fputcsv($file, ['Total Count: ', $_totals[0]->TotalCount]);
        fputcsv($file, ['Matched Count: ', $_totals[0]->MatchedCount]);
        fputcsv($file, ['Not Matched Count: ', $_totals[0]->NotMatchedCount]);
        fputcsv($file, ['']);

        fputcsv($file, ['', '', '', '', '', 'Total', '', '', '', '', $_totals[0]->sales_totalF, '', '', '', '', $_totals[0]->collection_totalF, '', '', '', '', $_totals[0]->adjustment_totalF, '', '', '', '', $_totals[0]->difference_totalF]);
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
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '"',
            ]
        );
    }


    /**
     * Brand store and location filter dataset
     * @param string $type
     * @return array
     */
    public function filtersSyncDataset(string $type) {
        $params = [
            "procType" => $type,
            "store" => $this->_store,
            "brand" => $this->_brand,
            "location" => $this->_location
        ];

        return DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_All_Card_Reconciliation_Filters :procType, :store, :brand, :location',
            $params
        );
    }



    /**
     * Get totals
     * @return array
     */
    public function getTotals() {

        $params = [
            'procType' => 'get_totals',
            'store' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->status,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_All_Card_Reconciliation :procType, :store, :brand, :location, :status, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }


    /**
     * Download method to get the data for export
     * @param ?string $value
     * @return \Illuminate\Support\Collection|bool
     */
    public function download(string $value): Collection|bool {
        $params = [
            'procType' => 'export',
            'store' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->status,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_All_Card_Reconciliation :procType, :store, :brand, :location, :status, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }



    /**
     * Data source
     * @return array
     */
    public function getData() {

        $params = [
            'procType' => 'all',
            'store' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->status,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_Tracker_All_Card_Reconciliation :procType, :store, :brand, :location, :status, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }


    /**
     * Render the HTML File
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        return view('livewire.commercial-team.tracker.all-card-recon', [
            'dataset' => $this->getData(),
            '_totals' => $this->getTotals()
        ]);
    }
}
