<?php

namespace App\Exports\CommercialTeam\Tracker;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WalletExport implements FromCollection, WithHeadings {


    public function __construct(
        public $data
    ) {
    }



    public function headings(): array {

        return [
            "storeID",
            "retekCode",
            "brand",
            "walletSale",
            "transactionDate",
            "collectionBank",
            "depositDt",
            "depositAmount",
            "diffSaleDeposit",
            "status"
        ];
    }




    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }


}