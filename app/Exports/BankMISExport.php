<?php

namespace App\Exports;

use App\Models\BankMSI;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BankMISExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return BankMSI::all();
    }

    public function headings(): array
    {
        return [
            'mflAxisPosCashRawUID',
            'bankName',
            'pickupPTCode',
            'transactionType',
            'TRCR',
            'customerCode',
            'PRDCode',
            'locationName',
            'depositDate',
            'adjustmentDate',
            'creditDate',
            'depositSlipNo',
            'depositAmount',
            'adjustmentAmount',
            'returnReason',
            'HIRCode',
            'HIRName',
            'depositBranch',
            'depositBranchName',
            'locationShort',
            'CLGType',
            'CLGDate',
            'recordDate',
            'returnDate',
            'revisedDate',
            'realisationDate',
            'pickupDate',
            'divisionCode',
            'divisionName',
            'adjustment',
            'noOfInstallment',
            'recoveredAmount',
            'subCustomerCode',
            'subCustomerName',
            'dsAddlInfoCode1',
            'dsAddlInfo1',
            'dsAddlInfoCode2',
            'dsAddlInfo2',
            'dsAddlInfoCode3',
            'dsAddlInfo3',
            'dsAddlInfoCode4',
            'dsAddlInfo4',
            'dsAddlInfoCode5',
            'dsAddlInfo5',
            'instSL',
            'instNo',
            'instDate',
            'instAmount',
            'instType',
            'instAmountBreakup',
            'adjAmount',
            'recoveredAmt',
            'reversalAmt',
            'drnOn',
            'drnOnLocation',
            'drnBk',
            'drnBr',
            'subCust',
            'subCustName',
            'drCod',
            'drawerName',
            'returnAmount',
            'insAddlInfoCode1',
            'insAddlInfo1',
            'insAddlInfoCode2',
            'insAddlInfo2',
            'insAddlInfoCode3',
            'insAddlInfo3',
            'insAddlInfoCode4',
            'insAddlInfo4',
            'insAddlInfoCode5',
            'insAddlInfo5',
            'remarks1',
            'remarks2',
            'remarks3',
            'pooledAcNo',
            'pooledDeptAmt',
            'deptDate',
            'poolSl',
            'rowType',
            'entryId',
            'typeOfEn',
            'e1',
            'e2',
            'e3',
            'recordUpdatedOn',
            'addl_field_1',
            'addl_field_2',
            'addl_field_3',
            'isActive',
            'createdBy',
            'createdDate',
            'modifiedBy',
            'modifiedDate',
        ];
    }
}
