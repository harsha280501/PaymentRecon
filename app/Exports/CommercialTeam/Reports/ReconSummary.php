<?php

namespace App\Exports\CommercialTeam\Reports;

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
            "CASH",
            "CARD",
            "WALLET",
            "UPI",
            "Total Sales",
            "HDFC Cash",
            "ICICI Cash",
            "SBI Cash",
            "AXIS Cash",
            "IDFC Cash",
            "Total Cash Collection",
            "HDFC Card",
            "ICICI Card",
            "SBI Card",
            "AMEX Card",
            "HDFC UPI",
            "PayTM",
            "PhonePe",
            "Total Card Collection",
            "Total UPI Collection",
            "Total Wallet Collection",
            "Total Collection",

            "Cash difference",
            "Card Difference",
            "Total Difference",
        ];
    }
}
