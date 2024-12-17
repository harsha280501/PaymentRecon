<?php

namespace App\Exports\Admin;

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

        return $this->data;

    }

    public function headings(): array
    {
        return [
            'CALDAY',
            'Store ID',
            'RETEK_CODE',
            'Brand Desc',
            'PAMX',
            'PHDF',
            'PICI',
            'PSBI',
            'PUBI',
            'UPIA',
            'UPIH',
            'CASH',
            'MPAY',
            'MPHP',
            'Store'
        ];
    }
}




