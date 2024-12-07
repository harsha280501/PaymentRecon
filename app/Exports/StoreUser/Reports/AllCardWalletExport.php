<?php

namespace App\Exports\StoreUser\Reports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllCardWalletExport implements FromCollection, WithHeadings {

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        // return collect(DB::select('PaymentMIS_PROC_SELECT_STORE_SAPSales :PROC_TYPE,:PROC_USERID,:PROC_STOREID,:PROC_DATE', [
        //     'PROC_TYPE' => 'SAPSales',
        //     'PROC_USERID' => auth()->user()->userUID,
        //     'PROC_STOREID' => auth()->user()->storeUID,
        //     'PROC_DATE' => null
        // ]));

        return $this->data;
    }


    public function headings(): array {
        return [
            'Sales Date',
            'Card(HDFC,ICICI,SBI,AMEX)',
            'Hdfc UPI',
            'Wallet(PHONEPAY,PAYTM)',
            'Total Sales',
            'HDFC',
            'ICICI',
            'SBI',
            'AMEX',
            'UPIH',
            'PayTM',
            'PhonePe',
            'Total Card Collection',
            'Total Upi Collection',
            'Total Wallet Collection',
            'Total Collection',
            'Difference',
            'Status',
        ];
    }
}
