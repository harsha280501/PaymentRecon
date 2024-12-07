<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardCashAgencyHCMSBIPos extends Model {
  use HasFactory;


  protected $table = 'MFL_Inward_CashAgencyHCM_SBIPos';

  protected $primaryKey = 'HCMAgencyUID';


  protected $fillable = [
    "storeID",
    "retekCode",
    "colBank",
    "brand",
    "stateOffice",
    "locationName",
    "cityName",
    "clientName",
    "depositDate",
    "HCMCustomerCode",
    "frequency",
    "heirarchyCode1",
    "accountCode",
    "customerName",
    "filename",
    "area",
    "cashPickupLimit",
    "depositSlipNo",
    "scratchCardSlipNumber",
    "cashPickupAmount",
    "DENOM_2000",
    "DENOM_1000",
    "DENOM_500",
    "DENOM_200",
    "DENOM_100",
    "DENOM_50",
    "DENOM_20",
    "DENOM_10",
    "DENOM_5",
    "DENOM_2",
    "DENOM_1",
    "others",
    "total",
    "remarks",
    "authorizationStatus",
    "callStatus",
    "CRNNo",
    "Region",
    "depositType",
    "OTPStatus",
    "missingRemarks",
    "unAllocatedRemarks",
    "unAllocatedCorrectionDate",
    "unAllocatedStatus",
    "isActive",
    "createdBy",
    "createdDate",
    "modifiedBy",
    "modifiedDate",
    "isMovedAllBank",
    "isDuplicate",
  ];

  public $timestamps = false;


}
