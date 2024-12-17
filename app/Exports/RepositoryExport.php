<?php

namespace App\Exports\CommercialHead;

use Maatwebsite\Excel\Concerns\FromCollection;

class RepositoryExport implements FromCollection
{

    public $main;

    public function __construct($main)
    {
        $this->main = $main;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->main;
    }
}