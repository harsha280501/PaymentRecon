<?php

namespace App\Exports\CommercialTeam\Process;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CashProcessExport implements FromCollection, WithHeadings {

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
            'crDt',
            'retekCode',
            'Brand Desc',
            'depostSlipNo',
            'creditAmount',
            'colBank',
            'refNo',
            'depositAmount',
            'diffSaleDeposit',
            'status',
            'storeID',
            'Store Name',
            'locationName',
            'depositDt',
            'reconStatus',
            'adjAmount',
        ];
    }
}