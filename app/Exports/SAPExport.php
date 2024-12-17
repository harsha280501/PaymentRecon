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

            "Sales Date", "Store ID", "RETEK_CODE", "Brand Desc", "AMEX", "HDFC", "ICICI", "SBI", "UBI", "UPI Others", "UPI HDFC", "CASH", "PayTM", "PhonePay", "Gift Vr not Redeemed/GCRD", "STORE"
        ];
    }
}
