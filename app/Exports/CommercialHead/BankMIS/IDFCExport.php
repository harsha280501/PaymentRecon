<?php


namespace App\Exports\CommercialHead\BankMIS;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IDFCExport implements FromCollection, WithHeadings
{

    public $data;
    public $type;

    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;
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
            'CashMISIdfcPosUID',
            'storeID',
            'retekCode',
            'colBank',
            'pkupPtCode',
            'tranType',
            'drCr',
            'custCode',
            'prdCode',
            'locationName',
            'depositDt',
            'adjDt',
            'crDt',
            'depSlipNo',
            'depositAmount',
            'adjAmount',
            'returnReason',
            'hirCode',
            'recDt',
            'rtnDt',
            'revDt',
            'realisationDt',
            'divisionCode',
            'subCustomerCode',
            'dS_Addl_InfoCode1',
            'dS_Addl_InfoCode2',
            'dS_Addl_InfoCode3',
            'instNo',
            'instAmt',
            'instAmtBreakup',
            'adjAmt',
            'recoveredAmt',
            'reversalAmt',
            'drnBk',
            'returnAmt',
            'insAddl_InfoCode1',
            'insAddl_InfoCode2',
            'insAddl_InfoCode3',
            'insAddl_InfoCode4',
            'insAddl_InfoCode5',
            'remarks1',
            'remarks2',
            'remarks3',
            'pooledAcNo',
            'pooledDeptAmt',
            'recordUpdatedOn',
            'addlField1',
            'addlField2',
            'addlField3',
            'createdBy',
            'filename'
        ];
    }
}
