<?php


namespace App\Exports\CommercialTeam\BankMIS;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WalletExport implements FromCollection, WithHeadings
{

    public $data;
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
        return [
            'PhonePayPosUID',
            'colBank',
            'storeId',
            'merCode',
            'tid',
            'mid',
            'depositDt',
            'crDt',
            'depositAmount',
            'msfComm',
            'cgstAmt',
            'sgstAmt',
            'igstAmt',
            'totalGst',
            'netAmt',
            'terminalName',
            'storeName',
            'instrument',
            'creationDt',
            'payType',
            'merRefId',
            'phonepayRefId',
            'serviceProvider',
            'bankRef',
            'isActive',
            'CreatedBy',
            'CreatedDate',
            'modifiedBy',
            'modifiedDate',
        ];
    }
}
