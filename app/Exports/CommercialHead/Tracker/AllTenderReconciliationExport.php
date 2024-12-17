<?php

namespace App\Exports\CommercialHead\Tracker;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllTenderReconciliationExport implements FromCollection, WithHeadings {

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
            "SalesDate",
            "DepositDate",
            "StoreID",
            "RetekCode",
            "Sales HDFC",
            "Sales ICICI",
            "Sales SBI",
            "Sales AMEX",
            "Sales UPI",
            "TotalSales",
            "Coll HDFC",
            "Coll ICICI",
            "Coll SBI",
            "Coll AMEX",
            "Coll UPIH",
            "TotalCollection",
            "Status",
            "Difference",
        ];
    }
}
