<?php

namespace App\Exports\CommercialHead\Process;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CashReconProcessExport implements FromCollection, WithHeadings {



    public function __construct(
        public $data, public $tab
    ) {
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }


    public function headings(): array {

        if ($this->tab == 'cash2bank') {
            return [
                'cashMisBkStRecoUID',
                'crDt',
                'retekCode',
                'creditAmount',
                'colBank',
                'refNo',
                'depositAmount',
                'diffSaleDeposit',
                'status'
            ];
        }

        return [
            'cashSalesRecoUID',
            'exDepDate',
            'saleDates',
            'amount',
            'slipNumber',
            'pickupBank',
            'createdBy',
            'storeID',
            'retekCode',
            'brand',
            'locationstore',
            '[Store Name]',
            'depositAmount',
            'cashDirectDep',
            'diffSaleDeposit',
            'status',
        ];
    }
}