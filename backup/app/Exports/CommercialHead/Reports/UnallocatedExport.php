<?php

namespace App\Exports\CommercialHead\Reports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UnallocatedExport implements FromCollection, WithHeadings {



    public function __construct(public $data, public $type) {
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }


    public function headings(): array {
        if ($this->type == 'cash') {
            return [
                "Store ID",
                "Retek Code",
                "Col Bank",
                "PkupPt Code",
                "Deposit Date",
                "Deposit Amount",
                "Dep Slip No",
                "File name",
                "Location"
            ];
        }

        if ($this->type == 'card') {
            return [
                "Store ID",
                "Retek Code",
                "Col Bank",
                "PkupPt Code",
                "Deposit Date",
                "Deposit Amount",
                "Filename"
            ];
        }

        if ($this->type == 'upi') {
            return [
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Deposit Date",
                "Missing Remarks",
                "Deposit Amount",
                "Filename",
            ];
        }

        return [
            "Store ID",
            "Retek Code",
            "Col Bank",
            "PkupPt Code",
            "Deposit Date",
            "Deposit Amount",
            "File name",
            "Store Name"
        ];
    }
}
