<?php

namespace App\Exports\StoreUser\Reports;


class ReconSummary {

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
