<?php

namespace App\Exports\CommercialHead\Reports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllCardWalletExport implements FromCollection, WithHeadings {

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
            "CALDAY",
            "CASH",
            "CARD",
            "WALLET",
            "UPI",
            "Sales Total",
            "CASH",
            "HDFC",
            "ICICI",
            "SBI",
            "AMEX",
            "UPIH",
            "PayTM",
            "PhonePe",
            "Collection Total",
            "Total Cash Collection",
            "Total Card Collection",
            "Total Upi Collection",
            "Total Wallet Collection",
            "Difference",
            "Status"
        ];
    }
}
