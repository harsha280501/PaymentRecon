<?php

namespace App\Exports\StoreUser\Tracker;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CardExport implements FromCollection, WithHeadings {

    public function __construct(public Collection $data) {
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }


    public function headings(): array {

        return [
            "StoreID",
            "RetekCode",
            "Brand",
            "CardSale",
            "SalesDate",
            "CollectionBank",
            "DepositDt",
            "DepositAmount",
            "DiffSaleDeposit",
            "Status"
        ];
    }
}
