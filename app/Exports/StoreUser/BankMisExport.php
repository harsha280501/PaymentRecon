<?php

namespace App\Exports\StoreUser;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BankMisExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect(DB::select('PaymentMIS_PROC_SELECT_STORE_AxisPos_BankMis :PROC_TYPE, :PROC_USERID, :PROC_STOREID, :PROC_DATE', [
            'PROC_TYPE' => 'Bankmis',
            'PROC_USERID' => auth()->user()->userUID,
            'PROC_STOREID' => auth()->user()->storeUID,
            'PROC_DATE' => null,
        ]));
    }

    public function headings(): array
    {
        return [
            'CasMISAxisPosUID',
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
            'hirName',
            'depositBr',
            'depositBrName',
            'locationShort',
            'clgType',
            'clgDt',
            'recDt',
            'rtnDt',
            'revDt',
            'realisationDt',
            'pkupDt',
            'divisionCode',
            'divisionName',
            'adj',
            'noOfInst',
            'recoveredAmount',
            'subCustomerCode',
            'subCustomerName',
            'dS_Addl_InfoCode1',
            'dS_AddlInfo1',
            'dS_Addl_InfoCode2',
            'dS_AddlInfo2',
            'dS_Addl_InfoCode3',
            'dS_AddlInfo3',
            'dS_Addl_InfoCode4',
            'dS_AddlInfo4',
            'dS_Addl_InfoCode5',
            'dS_AddlInfo5',
            'instSl',
            'instNo',
            'instDt',
            'instAmt',
            'instType',
            'instAmtBreakup',
            'adjAmt',
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
            'returnAmt',
            'insAddl_InfoCode1',
            'insAddlInfo1',
            'insAddl_InfoCode2',
            'insAddlInfo2',
            'insAddl_InfoCode3',
            'insAddlInfo3',
            'insAddl_InfoCode4',
            'insAddlInfo4',
            'insAddl_InfoCode5',
            'insAddlInfo5',
            'remarks1',
            'remarks2',
            'remarks3',
            'pooledAcNo',
            'pooledDeptAmt',
            'deptDt',
            'poolSl',
            'rowType',
            'entryId',
            'typeOfEn',
            'e1',
            'e2',
            'e3',
            'recordUpdatedOn',
            'addlField1',
            'addlField2',
            'addlField3',
            'isActive',
            'CreatedBy',
            'CreatedDate',
        ];

    }
}