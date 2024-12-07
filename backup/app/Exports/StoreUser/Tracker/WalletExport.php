<?php

namespace App\Exports\StoreUser\Tracker;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WalletExport implements FromCollection, WithHeadings {



    public function __construct(
        public $data
    ) {
    }



    public function headings(): array {

        return [
            "StoreID",
            "RetekCode",
            "Brand",
            "WalletSale",
            "SalesDate",
            "CollectionBank",
            "DepositDt",
            "DepositAmount",
            "DiffSaleDeposit",
            "Status"
        ];
    }




    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }
}
