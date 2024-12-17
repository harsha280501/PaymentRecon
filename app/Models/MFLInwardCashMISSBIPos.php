<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardCashMISSBIPos extends Model
{
    use HasFactory;


    protected $table = 'MFL_inward_CashMIS_SBIPos';

    protected $primaryKey = 'CashMISSbiPosUID';


    protected $fillable = [
      'sapCode',
      'retakeCode',
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
      'addlField1',
      'addlField2',
      'addlField3',
      'recordUpdatedOn',
      'isActive',
      'createdBy',
      'createdDate',
      'modifiedBy',
      'modifiedDate',
     ];

    public $timestamps = false;


}