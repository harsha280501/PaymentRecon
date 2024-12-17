<?php

namespace App\Traits;

use App\Interface\Excel\SpreadSheet;
use App\Interface\Excel\UseExcelDataset;

use Illuminate\Contracts\Container\BindingResolutionException;

trait StreamSimpleCSV {


    /**
     * Stream download this file
     * @return bool
     */
    public function export(SpreadSheet $spreadSheet, string $value = '') {

        if (!in_array("App\Interface\Excel\UseExcelDataset", class_implements($this))) {
            throw new BindingResolutionException("The Class needs to Implement \App\Interface\UseExcelDataset");
        }

        $headers = [];
        $dataset = $this->download($value)->toArray();

        // checking if data is returned
        if (count($dataset) < 1) {
            $this->emit('no-data');
            return false;
        }

        // checking the the headers are returned
        if (in_array("App\Interface\Excel\WithHeaders", class_implements($this))) {
            $headers = $this->headers();
        }

        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists

        // writting excel
        foreach ($dataset as $row) {
            $row = (array) $row;
            fputcsv($file, $row);
        }

        // Download the file using Livewire's download method
        return response()->stream(
            function () use ($filePath) {
                echo file_get_contents($filePath);
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="' . $filename . '"',
            ]
        );
    }







    public function store($dataset) {

    }

}