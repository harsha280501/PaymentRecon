<?php

namespace App\Exports\CommercialHead\Reports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReconSummary implements FromCollection, WithHeadings {

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
            "Date",
            "Store ID",
            "Retek Code",
            "Store Type",
            "Brand",
            "Region",
            "Location",
            "City",
            "State",
            "SAP Code",
            "SALES CASH",
            "SALES CARD",
            "SALES WALLET",
            "SALES UPI",
            "TOTAL SALES",
            "COLLECTION CASH",
            "COLLECTION CARD",
            "COLLECTION WALLET",
            "COLLECTION UPI",
            "TOTAL COLLECTION",
            "CASH DIFFERENCE",
            "CARD DIFFERENCE",
            "WALLET DIFFERENCE",
            "UPI DIFFERENCE",
            "TOTAL DIFFERENCE",
        ];
    }
}
