<?php

namespace App\Exports\CommercialHead\Reports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class OtherReports implements FromCollection, WithHeadings {



    public function __construct(public $data, public $type) {
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }


    public function headings(): array {
        if ($this->type == 'mpos-sap') {
            return [
                "Sales Date",
                "Store ID",
                "Retek Code",
                "Brand",
                "SAP Cash",
                "MPOS Cash",
                "Difference",
                "Status"
            ];
        }

        if ($this->type == 'zero-sales') {
            return [
                "Sales Date",
                "Store ID",
                "Retek Code",
                "Brand",
                "Total Sales"
            ];
        }

        if ($this->type == 'overall-summary') {
            return [
                "Month Index",
                "Store ID",
                "Retek Code",
                "Brand",
                "Month",
                "Opening Balance Cash",
                "Opening Balance Card",
                "Opening Balance UPI",
                "Opening Balance Wallet",
                "Sales Cash",
                "Sales Card",
                "Sales UPI",
                "Sales Wallet",
                "Collection Cash",
                "Collection Card",
                "Collection UPI",
                "Collection Wallet",
                "Closing Balance Cash",
                "Closing Balance Card",
                "Closing Balance UPI",
                "Closing Balance Wallet",
            ];
        }

        return [
            "Store ID",
            "Retek Code",
            "Brand",
            "Bank",
            "Account No.",
            "Deposit Date",
            "Sales Date",
            "Description",
            "TID",
            "Debit",
            "Credit",
            "Transaction Branch"
        ];
    }
}
