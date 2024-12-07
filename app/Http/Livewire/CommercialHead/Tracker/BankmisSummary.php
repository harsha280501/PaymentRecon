<?php

namespace App\Http\Livewire\CommercialHead\Tracker;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BankmisSummary extends Component
{
    public $startDate; 
    public $endDate;   
    public $perPage = 200; 
    public $orderBy = 'desc'; 

   
   
    public function getData()
    {
        $params = [
            ':from' => $this->startDate,
            ':to'   => $this->endDate,
        ];

        return DB::select(
            "EXEC PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_BankMIS_Summary :from, :to",
            $params
        );
    }

    /**
     * Prepare data for download.
     */
    public function download()
    {
        $data = $this->getData();

        // CSV headers
        $headers = [
            "Date",
            "Bank",
            "Bank Mis",
            "Reco Collection",
            "Unallocated",
            "Difference",
        ];

        $fileName = "BankMIS_Summary_" . now()->format('Ymd_His') . ".csv";

        return response()->streamDownload(function () use ($data, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($data as $row) {
                fputcsv($file, (array) $row);
            }

            fclose($file);
        }, $fileName);
    }

   
    public function render()
    {
        $data = collect($this->getData());

        return view('livewire.commercial-head.tracker.bankmis-summary', [
            'data' => $data->forPage(request()->get('page', 1), $this->perPage),
        ]);
    }
}
