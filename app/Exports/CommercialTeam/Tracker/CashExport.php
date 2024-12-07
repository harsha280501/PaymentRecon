<?php

namespace App\Exports\CommercialTeam\Tracker;

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
            "storeID",
            "retekCode",
            "mposDate",
            "depositDate",
            "colBank",
            "cashTenderStatus",
            "cashMISStatus",
            "bankDropID",
            "depositSlipNo",
            "tenderAmount",
            "bankDropAmount",
            "depositAmount",
            "tender_bank_difference",
            "bank_cash_difference",
            "bankdrop_cash_difference"

        ];
    }
}
