<?php

namespace App\Exports\CommercialHead\Process;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MPOSProcessExport implements FromCollection, WithHeadings {



    public function __construct(
        public Collection $data,
        public string $type) {
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }



    public function headings(): array {

        return [
            "CashTenderBkDrpUID",
            "depositDate",
            "bankDropDate",
            "amount",
            "bankDropID",
            "colBank",
            "createdBy",
            "storeID",
            "retekCode",
            "brand",
            "Location",
            "StoreName",
            "depositAmount",
            "tenderAmount",
            "bankDropAmount",
            "bankCashDifference",
            "depositAmountF",
            "tenderAmountF",
            "bank_cash_differenceF",
            "status",
            "reconStatus",
            "adjAmount",
            "createdDate",
            "approvalRemarks",
        ];
    }
}