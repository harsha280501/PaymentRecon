<?php

namespace App\Exports\StoreUser\Process;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SAPProcessExport implements FromCollection, WithHeadings {



    public function __construct(
        public Collection $data,
        public string $type
    ) {
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }



    public function headings(): array {

        if ($this->type == 'wallet') {
            return [
                'walletSalesRecoUID',
                'storeID',
                'retekCode',
                'brand',
                'walletSale',
                'transactionDate',
                'collectionBank',
                'merCode',
                'depositDate',
                'depositAmount',
                'diffSaleDeposit',
                'status',
                'approvedBy',
                'approvedDate',
                'saleReconDifferenceAmount',
                'reconStatus',
            ];
        }


        return [
            'CardSalesRecoUID',
            'StoreID',
            'RetekCode',
            'Brand',
            'CollectionBank',
            'Status',
            'ReconStatus',
            'CardSale',
            'ApprovedBy',
            'SalesDate',
            'ApprovedDate',
            'DepositDate',
            'DepositAmount',
            'DiffSaleDeposit',
            'SaleReconDifferenceAmount'
        ];
    }
}
