<?php

namespace App\Http\Livewire\CommercialTeam\Reports;


use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\UseLocation;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use Maatwebsite\Excel\Facades\Excel;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;
use App\Traits\UseDefaults;
use Illuminate\Pagination\LengthAwarePaginator;

class Mpos extends Component implements UseExcelDataset {

    use HasInfinityScroll, WithExportDate, UseOrderBy, ParseMonths, UseLocation, UseDefaults;






    
    /** 
     * Select timeline
     * @var string
     */
    public $datewise = 'ThisYear';








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
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Cash_Tender_Wise_Sales';










    /**
     * end for filtering from dates
     * @var
     */
    public $store = '';








    /**
     * Stores array for filtering 
     * @var array
     */
    public $stores = [];









    /**
     * Initialize variables
     * @return void
     */
    public function mount() {
        // getting the store data
        $this->cities = $this->_cities();
        $this->_months = $this->_months()->toArray();
        $this->stores = $this->_stores();
    }








    /**
     * Resets all the properties
     * @return void
     */
    public function back() {
        $this->resetExcept('activeTab');
        $this->emit('resetAll');
        $this->emit('reset:all');
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
     * Headers for the Excel Export
     * @return array
     */
    public function headers(): array {
        return [
            'Sales Date',
            'Store ID',
            'RETEK Code',
            'Brand Desc',
            'City',
            'Cash',
        ];
    }

    





    /**
     * Export Data for the Excel
     * @param string $value
     * @return Collection|boolean
     */
    public function download(string $value): Collection|bool {

        $params = [
            'procType' => 'export',
            'storeId' => $this->store,
            'from' => $this->startdate,
            'to' => $this->enddate,
            'city' => trim($this->_city),
            'brand' => $this->_brand,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_MPOSSales :procType, :storeId, :city, :brand, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }




  



    /**
     * Get the aMain reports
     * @return LengthAwarePaginator
     */
    public function getData() {

        $params = [
            'procType' => 'combined',
            'storeId' => $this->store,
            'from' => $this->startdate,
            'to' => $this->enddate,
            'city' => trim($this->_city),
            'brand' => $this->_brand,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALTEAM_MPOSSales :procType, :storeId, :city, :brand, :from, :to',
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

        $dataset = $this->getData();
        $this->brands = $this->_brands();

        // getting the main data
        return view('livewire.commercial-team.reports.mpos', [
            'datas' => $dataset,
        ]);
    }
}
