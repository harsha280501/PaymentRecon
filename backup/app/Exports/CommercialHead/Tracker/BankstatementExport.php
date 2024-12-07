<?php

namespace App\Exports\CommercialHead\Tracker;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BankstatementExport implements FromCollection, WithHeadings {



    public function __construct(public $data, public $type) {
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }


    public function headings(): array {

        if ($this->type == 'card') {
            return [
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status",
                "Deposit Date",
                "Sales Date",
                "Bank Deposit Date	",
                "Msf Commission",
                "Gst Total",
                "Deposit Amount	",
                "Credit Amount",
                "Difference Sales Deposit"
            ];
        }

        if ($this->type == 'wallet') {
            return [

                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status",
                "Sales Date",
                "Deposit Date",
                "Depost Slip No",
                "Deposit Amount",
                "Credit Amount",
                "Difference Sale Deposit"
            ];
        }

        if ($this->type == 'upi') {
            return [
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status	",
                "Deposit Date",
                "Sales Date",
                "Bank Deposit Date",
                "Msf Commission",
                "Gst Total",
                "Net Amount",
                "Credit Amount",
                "Difference Sales Deposit",
            ];
        }

        return [

            "Store ID",
            "Retek Code",
            "Col Bank",
            "Status",
            "Sales Date",
            "Deposit Date",
            "Depost Slip No",
            "Deposit Amount",
            "Credit Amount",
            "Difference Sale Deposit"
        ];
    }
}
