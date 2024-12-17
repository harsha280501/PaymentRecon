<?php

namespace App\Http\Livewire\CommercialTeam\Reports;



use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\UseLocation;
use Livewire\WithPagination;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use Maatwebsite\Excel\Facades\Excel;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;
use App\Exports\CommercialHead\SAPExport;
use App\Traits\UseDefaults;

class ReportsSAP extends Component implements UseExcelDataset {


    use HasInfinityScroll, WithExportDate, UseOrderBy, ParseMonths, UseLocation, UseDefaults;











    /** Filename for export
     * @var string
    */
    public $export_file_name = 'Payment_MIS_Reports_Daily_Tender_Wise_Store_Sales';













    /**
     * end for filtering from dates
     * @var
     */
    public $store = '';









    /**
     * Store Filter List Array
     *
     * @var array
     */
    public $stores = [];







    /**
     * Mount function
     *
     * @return void
     */
    public function mount() {


        $this->cities = $this->_cities();
        $this->_months = $this->_months()->toArray();
        // getting the store data
        $this->stores = DB::select('PaymentMIS_PROC_SELECT_USER_STORE :storeId, :userId, :roleId, :procType', [
            'storeId' => auth()->user()->storeUID,
            'userId' => auth()->user()->userUID,
            'roleId' => auth()->user()->roleUID,
            'procType' => 'users-stores02'
        ]);
    }






        

    /**
     * Resets all the properties
     * @return void
     */
    public function back() {
        $this->resetExcept(['brands']);
        $this->emit('resetAll');
    }









    /**
     * Excel Export Headers
     *
     * @return array
     */
    public function headers(): array {
        return [

            "Sale Date",
            "Store ID",
            "Retek Code",
            "Brand Desc",
            "City",
            "AMEX",
            "HDFC",
            "ICICI",
            "SBI",
            "UPI-HDFC",
            "CASH",
            "PAYTM",
            "PHONE PE",
            "Total",
            "Vouchgram",
            "Gift. Vr. Reedemed",
            "Grand Total",
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
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '"',
            ]
        );
    }





    /**
     * Download function for Excel
     *
     * @param string $value
     * @return Collection|boolean
     */
    public function download(string $value): Collection|bool {

        $params = [
            'procType' => 'export',
            'from' => $this->startDate,
            'to' => $this->endDate,
            'store' => $this->store,
            'city' => trim($this->_city),
            'brand' => $this->_brand,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_SAPSales :procType, :store, :city, :brand, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }










    /**
     * Get the aMain reports
     * @return array
     */
    public function getData() {

        $params = [
            'procType' => 'combined',
            'from' => $this->startDate,
            'to' => $this->endDate,
            'store' => $this->store,
            'city' => trim($this->_city),
            'brand' => $this->_brand,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_SAPSales :procType, :store, :city, :brand, :from, :to',
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
        $reports = $this->getData();
        $this->brands = $this->_brands();

        // getting the main data
        return view('livewire.commercial-team.reports.reports-s-a-p', [
            'reports' => $reports
        ]);
    }
}
