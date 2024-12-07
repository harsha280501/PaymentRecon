<?php

namespace App\Exports\StoreUser;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SAPExport implements FromCollection, WithHeadings
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
        // return collect(DB::select('PaymentMIS_PROC_SELECT_STORE_SAPSales :PROC_TYPE,:PROC_USERID,:PROC_STOREID,:PROC_DATE', [
        //     'PROC_TYPE' => 'SAPSales',
        //     'PROC_USERID' => auth()->user()->userUID,
        //     'PROC_STOREID' => auth()->user()->storeUID,
        //     'PROC_DATE' => null
        // ]));

        return $this->data;
    }


    public function headings(): array
    {
        return [
            'CALDAY',
            'Store ID',
            'RETEK_CODE',
            'Brand Desc',
            'PSBI',
            'MPHP',
            'PUBI',
            'MPAY',
            'Cash/CASH',
            'PAMX',
            'PHDF',
            'UPIH',
            'UPIA',
            'PICI',
            'Store'
        ];
    }
}
