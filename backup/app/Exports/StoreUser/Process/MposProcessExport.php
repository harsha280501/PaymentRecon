<?php

namespace App\Exports\StoreUser\Process;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MposProcessExport implements FromCollection, WithHeadings {

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
            "Status",
            "BankDropID",
            "DepositSlipNo",
            "TenderAmount",
            "BankDropAmount",
            "DepositAmount",
            "Bank_cash_difference",
            "TenderAmount",
            "DepositAmount",
            "BankDropAmount",
            "Bank_cash_difference",
            "RetekCode",
            "Brand",
            "Location",
            "ReconStatus"

        ];
    }
}
