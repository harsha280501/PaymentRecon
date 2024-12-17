<?php

namespace App\Exports\StoreUser\DirectDeposit;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DepositExport implements FromCollection, WithHeadings {

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
            "sapCode",
            "brand",
            "Region",
            "depositSlipNo",
            "amount",
            "directDepositDate",
            "bank",
            "accountNo",
            "bankBranch",
            "location",
            "city",
            "state",
            "salesDateFrom",
            "salesDateTo",
            "cashDepositBy",
            "otherRemarks",
            "reason",
            "depositSlipProof",
            "status",
            "approvalRemarks",
            "SalesTender",
        ];
    }
}
