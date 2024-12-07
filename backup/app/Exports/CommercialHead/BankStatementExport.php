<?php

namespace App\Exports\CommercialHead;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BankStatementExport implements FromCollection, WithHeadings
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
            'isActive',
            'colBank',
            'accountNo',
            'depositDt',
            'bookDt',
            'description',
            'ledger_bal',
            'credit',
            'debit',
            'crDt',
            'refNo',
            'transactionBr',
            'createdBy',
            'createdDate'
        ];
    }
}
