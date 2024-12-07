<?php

namespace App\Exports\StoreUser\Tracker;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CashExport implements FromCollection, WithHeadings {

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
            "SalesDate",
            "DepositDate",
            "ColBank",
            "BankDropID",
            "DepositSlipNo",
            "TenderAmount",
            "BankDropAmount",
            "DepositAmount",
            "TenderBankDifference",
            "BankCashDifference",
            "BankdropCashDifference",
            "CashBankStatus"
        ];
    }
}
