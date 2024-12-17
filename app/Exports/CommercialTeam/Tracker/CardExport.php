<?php

namespace App\Exports\CommercialTeam\Tracker;

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
            "storeID",
            "retekCode",
            "brand",
            "cardSale",
            "transactionDate",
            "collectionBank",
            "depositDt",
            "depositAmount",
            "diffSaleDeposit",
            "status"
        ];
    }
}
