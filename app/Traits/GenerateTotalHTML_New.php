<?php


namespace App\Traits;


/**
 * Livewire Page with Tabs
 */
trait GenerateTotalHTML {



    public function generateHTML(mixed $callback) {

        $dataset = call_user_func($callback);
        $totalCount = $dataset->count();
        $validCount = $dataset->where('missingRemarks', '=', 'Valid')->count();
        $notValidCount = $dataset->where('missingRemarks', '<>', 'Valid')->count();

        $depositDateNullCount = $dataset->filter(fn($item) => is_null($item->depositDt))->count();
        $creditDateNullCount = $dataset->filter(fn($item) => is_null($item->crDt))->count();
        $depositAmountNullCount = $dataset->filter(fn($item) => is_null($item->depositAmount))->count();
        $totalDepositAmount = $dataset->sum('depositAmount');

        return "
        <div style=\"display: flex; flex-direction: column; padding: 1em; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 400px; margin: auto; font-family: Arial, sans-serif;\">
            <div style=\"display: flex; gap: 1em; align-items: center; padding: 0.5em; border-bottom: 1px solid #e0e0e0;\">
                <h5 style=\"margin: 0; color: #555; font-weight: normal;\">Total Count</h5>
                <h3 style=\"margin: 0; color: #333; font-weight: bold;\">$totalCount</h3>
            </div>
            
            <div style=\"display: flex; gap: 1em; align-items: center; padding: 0.5em; border-bottom: 1px solid #e0e0e0;\">
                <h5 style=\"margin: 0; color: #4caf50;\">Valid Count</h5>
                <h3 style=\"margin: 0; color: #4caf50; font-weight: bold;\">$validCount</h3>
            </div>

            <div style=\"display: flex; gap: 1em; align-items: center; padding: 0.5em; border-bottom: 1px solid #e0e0e0;\">
                <h5 style=\"margin: 0; color: #f44336;\">Not Valid Count</h5>
                <h3 style=\"margin: 0; color: #f44336; font-weight: bold;\">$notValidCount</h3>
            </div>

            <div style=\"display: flex; gap: 1em; align-items: center; padding: 0.5em; border-bottom: 1px solid #e0e0e0;\">
                <h5 style=\"margin: 0; color: #ff9800;\">Deposit Date Null Count</h5>
                <h3 style=\"margin: 0; color: #ff9800; font-weight: bold;\">$depositDateNullCount</h3>
            </div>

            <div style=\"display: flex; gap: 1em; align-items: center; padding: 0.5em; border-bottom: 1px solid #e0e0e0;\">
                <h5 style=\"margin: 0; color: #ff5722;\">Credit Date Null Count</h5>
                <h3 style=\"margin: 0; color: #ff5722; font-weight: bold;\">$creditDateNullCount</h3>
            </div>

            <div style=\"display: flex; gap: 1em; align-items: center; padding: 0.5em; border-bottom: 1px solid #e0e0e0;\">
                <h5 style=\"margin: 0; color: #9c27b0;\">Deposit Amount Null Count</h5>
                <h3 style=\"margin: 0; color: #9c27b0; font-weight: bold;\">$depositAmountNullCount</h3>
            </div>

            <div style=\"display: flex; gap: 1em; align-items: center; padding: 0.5em;\">
                <h5 style=\"margin: 0; color: #3f51b5;\">Total Deposit Amount</h5>
                <h3 style=\"margin: 0; color: #3f51b5; font-weight: bold;\">$totalDepositAmount</h3>
            </div>
        </div>
    ";
    }





}