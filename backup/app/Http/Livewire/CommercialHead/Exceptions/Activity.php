<?php

namespace App\Http\Livewire\CommercialHead\Exceptions;

use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\UseDefaults;
use App\Traits\UseOrderBy;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Activity extends Component {

    use HasInfinityScroll, UseOrderBy, UseDefaults, ParseMonths;






    public $status = '';


    public $locations = [];



    public $location = '';






    protected $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Exception_User Activity';







    public function mount() {
        $this->locations = $this->dataset('location');
        $this->_months = $this->_months()->toArray();
    }






    public function headers() {
        return [
            "Date / Time",
            "Type",
            "Store ID",
            "Store Name",
            "Login Email",
            "IP Address",
            "Location"
        ];
    }






    /**
     * Export functionality
     * @return void
     */
    public function export($dataset = [], $all = '') {

        $data = $this->dataset('export');
        $headers = $this->headers();

        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }

        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists

        fputcsv($file, $headers); // adding headers to the excel

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
     * Get the aMain reports
     * 
     */
    public function dataset(string $type) {

        $params = [
            'procType' => $type,
            'status' => $this->status,
            'location' => $this->location,
            'from' => $this->startDate,
            'to' => $this->endDate
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Exception_User_Activity :procType, :status, :location, :from, :to',
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

        $dataset = $this->dataset('main');

        return view('livewire.commercial-head.exceptions.activity', [
            'dataset' => $dataset,
        ]);
    }
}
