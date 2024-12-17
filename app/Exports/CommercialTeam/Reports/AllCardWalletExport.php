<?php

namespace App\Exports\CommercialTeam\Reports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllCardWalletExport implements FromCollection, WithHeadings
{

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }


    public function headings(): array
    {
        return [
            "storeID",
            "retekCode",
            "CALDAY",
            "CARD",
            "WALLET",
            "UPI",
            "sales_total",
            "HDFC",
            "ICICI",
            "SBI",
            "AMEX",
            "UPIH",
            "PayTM",
            "PhonePe",
            "collection_total",
            "total_card_collection",
            "total_upi_collection",
            "total_wallet_collection",
            "difference",
            "status",
            "sort_difference"

        ];
    }
}
