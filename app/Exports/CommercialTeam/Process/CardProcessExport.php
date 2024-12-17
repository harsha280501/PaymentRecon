<?php

namespace App\Exports\CommercialTeam\Process;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CardProcessExport implements FromCollection, WithHeadings {

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
            'merCode',
            'tid',
            'mid',
            'depositDt',
            'crDt',
            'depositAmount',
            'msfComm',
            'gstTotal',
            'netAmount',
            'creditAmount',
            'bankDepositDt',
            'diffSaleDeposit',
            'status',
            'reconStatus',
            'Store Name',
            'Brand Desc',
            'Location',
            'adjAmount'
        ];
    }
}