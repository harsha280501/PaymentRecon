<?php

namespace App\Exports\StoreUser\Process;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UPIReconProcessExport implements FromCollection, WithHeadings {


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
            "UPISale",
            "SalesDate",
            "CollectionBank",
            "DepositDate",
            "DepositAmount",
            "DiffSaleDeposit",
            "Status",
            "ApprovedBy",
            "ApprovedDate",
            "SaleReconDifferenceAmount",
            "ReconStatus",
            "AdjAmount",
            "ReconDifference",
            "ProcessDt",
            "ApprovalRemarks"
        ];
    }
}
