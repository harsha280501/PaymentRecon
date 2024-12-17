<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardStoreIDMissingTransactions extends Model {
  use HasFactory;


  protected $table = 'MFL_Inward_StoreID_Missing_Transactions';

  protected $primaryKey = 'storeMissingUID';

  public $timestamps = false;



  protected $fillable = [
    "UID",
    "storeID",
    "retekCode",
    "tid",
    "mid",
    "colBank",
    "brand",
    "pkupPtCode",
    "salesDate",
    "depositDate",
    "depositAmount",
    "depSlipNo",
    "filename",
    "locationShort",
    "type",
    "missingRemarks",
    "storeUpdateRemarks",
    "missingRemarks",
    "isActive",
    "unAllocatedStatus",
    "unAllocatedRemarks",
    "unAllocatedCorrectionDate",
    "createdDate",
    "createdBy",
    "modifiedDate",
    "modifiedBy",
    "isInserted",
    "updatedStoreID",
    "updatedRetekCode",
    "updatedTender",
  ];



  /***
   * Time stamps
   */
  const CREATED_AT = 'createdDate';

  /***
   * Time stamps
   */
  const UPDATED_AT = 'modifiedDate';
}