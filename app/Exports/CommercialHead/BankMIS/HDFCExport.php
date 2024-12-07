<?php

namespace App\Exports\CommercialHead\BankMIS;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HDFCExport implements FromCollection, WithHeadings {

    public Collection $data;
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
                'depositDt',
                'crDt',
                'intnlAmt',
                'domesticAmt',
                'msfComm',
                'cgstAmt',
                'sgstAmt',
                'igstAmt',
                'ugstAmt',
                'netAmount',
                'cardTypes',
                'cardNumber',
                'approvCode',
                'servTax',
                'sbCess',
                'kkCess',
                'drCrType',
                'arn_no',
                'recFmt',
                'bat_nbr',
                'tran_id',
                'upValue',
                'merchantTrackId',
                'invoiceNumber',
                'gstnTransactionId',
                'udf1',
                'udf2',
                'udf3',
                'udf4',
                'udf5',
                'sequence_number',
                'Adjustment',
                'filename',
                'createdBy',
            ];
        }


        if ($this->type === 'upi') {
            return [
                'storeID',
                'retekCode',
                'col_bank',
                'acctNo',
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
                'ugstAmt',
                'netAmount',
                'arnNo',
                'tranId',
                'invoiceNumber',
                'udf1',
                'udf2',
                'udf3',
                'udf4',
                'udf5',
                'tranType',
                'merchantName',
                'merchantVpa',
                'payerVpa',
                'orderId',
                'currency',
                'filename',
                'createdBy',
            ];
        }

        return [
            'storeID',
            'retekCode',
            'colBank',
            'pkupPtCode',
            'prdCode',
            'locationName',
            'depositDt',
            'crDt',
            'depSlipNo',
            'depositAmount',
            'returnReason',
            'locationShort',
            'pkupDt',
            'noOfInst',
            'instNo',
            'instDt',
            'instAmt',
            'drnBk',
            'drawerName',
            'remarks1',
            'remarks2',
            'pooledDeptAmt',
            'deptDt',
            'rowType',
            'entryId',
            'typeOfEn',
            'e1',
            'e2',
            'e3',
            'record_updated_on',
            'addlField1',
            'addlField2',
            'addlField3',
            'filename',
            'createdBy'
        ];
    }
}