<?php

namespace App\Exports\CommercialHead;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SAPExport implements FromCollection, WithHeadings {

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

            "SalesDate",
            "Store ID",
            "Retek Code",
            "Brand Desc",
            "AMEX",
            "HDFC",
            "ICICI",
            "SBI",
            "UPI HDFC",
            "CASH",
            "PhonePay",
            "PayTM",
            "VouchGram",
            "Gift Vr Redeemed",
            "Total"
        ];
    }
}
