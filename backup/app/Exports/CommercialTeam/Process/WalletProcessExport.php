<?php

namespace App\Exports\CommercialTeam\Process;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WalletProcessExport implements FromCollection, WithHeadings {

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }

    public function headings(): array {
        return [
            'storeID',
            'retekCode',
            'colBank',
            'tid',
            'depositDt',
            'creditDt',
            'depositAmount',
            'gstTotal',
            'netAmount',
            'creditAmount',
            'diffSaleDeposit',
            'bankRrefORutrNo',
            'status',
            'reconStatus',
            'adjAmount'
        ];
    }
}