<?php

namespace App\Exports\StoreUser\Reports;

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
            'AMAZON',
            'Amex Offline Card',
            'Cash',
            'Customer Advance',
            'Falcon',
            'HDFC Reco',
            'HDFC UPI',
            'ICICI Reco',
            'Innoviti Card',
            'Innoviti Phonepe',
            'Innoviti UPI',
            'Online COD',
            'Online Prepay',
            'Online Return',
            'Other CC',
            'Paytm',
            'Paytm QR',
            'PhonePe',
            'Plutus',
            'QC GC Redemption',
            'SBI Reco',
            'Store Credit',
            'TataCliq',
            'UBI Reco',
            'Vouchergram',
            'WESTBURYFL',
            'OTHERS',
            'TOTAL'
        ];
    }

}