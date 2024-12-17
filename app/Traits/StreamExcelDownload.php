<?php

namespace App\Traits;

use App\Interface\Excel\SpreadSheet;
use App\Interface\Excel\UseExcelDataset;

use Illuminate\Contracts\Container\BindingResolutionException;

trait StreamExcelDownload {


    /**
     * Stream download this file
     * @return bool
     */
    public function export(SpreadSheet $spreadSheet, string $value = '') {

        // checking the implementations
        if (!in_array(UseExcelDataset::class, class_implements($this))) {
            throw new BindingResolutionException("The Class needs to Implement \App\Interface\UseExcelDataset");
        }



        // main Dataset
        $dataset = $this->download($value)->toArray();

        // checking if not data is returned
        if (count($dataset) < 1) {
            $this->emit('no-data');
            return false;
        }


        $headers = [];
        // if (!in_array("App\Interface\Excel\WithHeaders", class_implements($this))) {
        $headers = $this->headers();
        // }

        // checking the implementations
        // if (!in_array("App\Interface\Excel\WithFormatting", class_implements($this))) {
        $this->formatter($spreadSheet, $dataset);
        // }


        // sending the main data
        $tempFile = $spreadSheet->generateAndDownload($dataset, $headers);
        $filename = $spreadSheet->filename;

        // Download the file using Livewire's download method
        return response()->stream(
            function () use ($tempFile) {
                echo file_get_contents($tempFile);
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="' . $filename . '"',
            ]
        );
    }


}