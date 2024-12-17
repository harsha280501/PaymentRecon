<?php


namespace App\Exports\CommercialHead\BankMIS;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AmexposExport implements FromCollection, WithHeadings {

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
            'acctNo',
            'merCode',
            'tid',
            'mid',
            'depositDt',
            'crDt',
            'depositAmount',
            'glTxn',
            'cardNumber',
            'transactionType',
            'approvCode',
            'settlAmount',
            'servTax',
            'arnNo',
            'midCity',
            'tranType',
            'airlineTicketNumber',
            'adjustmentType',
            'filename',
            'createdBy',
        ];
    }
}