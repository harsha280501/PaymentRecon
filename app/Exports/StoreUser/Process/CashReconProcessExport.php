<?php

namespace App\Exports\StoreUser\Process;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CashReconProcessExport implements FromCollection, WithHeadings {


    public $data;
    public $type;

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

            'StoreID',
            'RetekCode',
            'Brand',
            'PickupBank',
            'Status',
            'ApprovedBy',
            'ExpDepDate',
            'CashPickupDate',
            'ApprovedDate',
            'DirectDepDate',
            'CashSale',
            'DepositAmount',
            'DiffSaleDeposit',
            'SaleReconDifferenceAmount',
            'CashDirectDep',
            'ReconStatus',
        ];
    }
}
