<?php


namespace App\Exports\CommercialHead\BankMIS;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WalletExport implements FromCollection, WithHeadings {

    public $data;
    public $type;

    public function __construct($data, $type) {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }


    public function headings(): array {
        return [
            'storeID',
            'retekCode',
            'colBank',
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
            'terminalName',
            'storeName',
            'instrument',
            'creationDt',
            'payType',
            'merRefId',
            'phonepayRefId',
            'serviceProvider',
            'bankRef',
            'filename',
            'createdBy',
        ];
    }
}