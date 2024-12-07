<?php

namespace App\Exports\CommercialHead\Reports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MPOSExport implements FromCollection, WithHeadings {

    public Collection $data;

    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return $this->data;
    }


    public function headings(): array {

        return [
            'Date',
            'Store ID',
            'RETEK Code',
            'Brand Desc',
            'Cash',
        ];
    }
}
