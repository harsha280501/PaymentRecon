<?php

namespace App\Exports\CommercialTeam;

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
            'CALMONTH',
            'Location',
            'Tender Type',
            'Transaction Number',
            'RETEK_CODE',
            'Tender value',
            'Tender Description',
            'Store ID',
            'Brand Desc',
            'Type',
            'CUSTOMER',
        ];
    }
}
