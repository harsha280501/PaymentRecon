<?php


namespace App\Exports\CommercialHead\Exception;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WalletExport implements FromCollection, WithHeadings {


    public function __construct(
        public $data
    ) {
    }



    public function headings(): array {

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




    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }


}