<?php

namespace App\Exports\CommercialHead\Reports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BankMISExport implements FromCollection, WithHeadings
{

    public Collection $data;
    public $type;

    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;
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

        if ($this->type === "all-wallet-mis") {
            return [
                'depositDt',
                'creditDt',
                'storeID',
                'retekCode',
                'colBank',
                'tid',
                'mid',
                'depositAmount',
                'msfComm',
                'gstTotal',
                'netAmount',
                'bankRrefORutrNo'
            ];
        }


        if ($this->type === 'all-card-mis') {
            return [
                'depositDt',
                'creditDt',
                'storeID',
                'retekCode',
                'colBank',
                'accountNo',
                'merCode',
                'tid',
                'depositAmount',
                'msfComm',
                'gstTotal',
                'netAmount'
            ];
        }

        return [
            'storeID',
            'retekCode',
            'colBank',
            'locationName',
            'depositDt',
            'crDt',
            'depostSlipNo',
            'depositAmount'
        ];
    }
}
