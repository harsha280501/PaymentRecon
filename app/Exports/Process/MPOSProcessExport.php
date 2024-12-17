<?php

namespace App\Exports\CommercialHead\Process;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MPOSProcessExport implements FromCollection, WithHeadings {



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
            "CashTenderBkDrpUID",
            "DepositDate",
            "BankDropDate",
            "Amount",
            "BankDropID",
            "ColBank",
            "CreatedBy",
            "StoreID",
            "RetekCode",
            "Brand",
            "Location",
            "StoreName",
            "DepositAmount",
            "TenderAmount",
            "BankDropAmount",
            "BankCashDifference",
            "DepositAmountF",
            "TenderAmountF",
            "Bank_cash_differenceF",
            "Status",
            "ReconStatus",
            "AdjAmount",
            "CreatedDate",
            "ApprovalRemarks",
        ];
    }
}
