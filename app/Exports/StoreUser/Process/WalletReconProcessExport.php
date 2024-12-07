<?php

namespace App\Exports\StoreUser\Process;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WalletReconProcessExport implements FromCollection, WithHeadings {


    public $data;

    public function __construct($data) {
        $this->data = $data;
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
            "WalletSale",
            "TransactionDate",
            "CollectionBank",
            "DepositDate",
            "DepositAmount",
            "DiffSaleDeposit",
            "Status",
            "ApprovedBy",
            "ApprovedDate",
            "SaleReconDifferenceAmount",
            "ReconStatus",
            "ProcessDt",
        ];
    }
}
