<?php

namespace App\Exports\CommercialHead\Process;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WalletReconProcessExport implements FromCollection, WithHeadings {




    public function __construct(
        public Collection $data,
        public string $type
    ) {
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }


    public function headings(): array {
        return [
            'WalletSalesRecoUID',
            'ExDepDate',
            'Amount',
            'PickupBank',
            'CreatedBy',
            'StoreID',
            'RetekCode',
            'Brand',
            'Locationstore',
            'Store Name',
            'DepositAmount',
            'CashDirectDep',
            'DiffSaleDeposit',
            'Status',
        ];
    }
}
