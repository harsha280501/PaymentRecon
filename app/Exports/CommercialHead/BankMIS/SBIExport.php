<?php


namespace App\Exports\CommercialHead\BankMIS;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SBIExport implements FromCollection, WithHeadings {

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

        if ($this->type === "card") {
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
                'mdrRate',
                'msfComm',
                'gstTotal',
                'netAmount',
                'glTxn',
                'cardType',
                'cardNumber',
                'approvCode',
                'servTax',
                'sbCess',
                'kkCess',
                'arnNo',
                'batNbr',
                'tranType',
                'nameAndLoc',
                'mcc',
                'onusOffus',
                'penaltyMdrRate',
                'penaltyMdrAmt',
                'penaltyServiceTax',
                'cashbackAmt',
                'incMdrRate',
                'incAmt',
                'incServiceTax',
                'penaltySbc',
                'penaltyKcc',
                'branchCode',
                'circle',
                'CardType',
                'sponsorbank',
                'PenaltyGST',
                'gstin',
                'Paymentmode',
                'Interchange',
                'tranIdentifier',
                'superMID',
                'parentMI',
            ];
        }

        return [
            'storeID',
            'retake_code',
            'col_bank',
            'pkup_pt_code',
            'cust_code',
            'prd_code',
            'location_name',
            'deposit_dt',
            'cr_dt',
            'dep_slip_no',
            'deposit_amount',
            'return_reason',
            'deposit_br',
            'deposit_br_name',
            'no_of_inst',
            'd_s_addl_info1',
            'd_s_addl_info2',
            'd_s_addl_info3',
            'd_s_addl_info4',
            'd_s_addl_info5',
            'inst_no',
            'inst_dt',
            'inst_amt',
            'drn_bk',
            'drn_br',
            'drawer_name',
            'pooled_ac_no',
            'e1',
            'e2',
            'addl_field_1',
            'addl_field_2',
            'addl_field_3',
            'filename',
            'uploadedBy',
            'record_updated_on',
        ];
    }
}