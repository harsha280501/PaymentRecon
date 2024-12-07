<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardWalletMISPhonePayPos extends Model {
  use HasFactory;


  protected $table = 'MFL_inward_WalletMIS_PhonePayPos';

  protected $primaryKey = 'PhonePayPosUID';


  protected $fillable = [
    'colBank',
    'storeId',
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
    'totalGst',
    'netAmt',
    'terminalName',
    'storeName',
    'instrument',
    'creationDt',
    'payType',
    'merRefId',
    'phonepayRefId',
    'serviceProvider',
    'bankRef',
    'isActive',
    'CreatedBy',
    'CreatedDate',
    'modifiedBy',
    'modifiedDate',
    'missingRemarks',
    'unAllocatedRemarks',
    'unAllocatedCorrectionDate',
    'unAllocatedStatus',
    'storeID',
    'retekCode',
    'brand',
  ];

  public $timestamps = false;


}
