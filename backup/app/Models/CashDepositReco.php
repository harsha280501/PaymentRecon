<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CashDepositReco extends Model {
  use HasFactory;


  protected $table = 'MFL_inward_CashMIS_HdfcPos_FROM_HDFC_BANKSTATMENT';

  protected $primaryKey = 'hdfcMISBkUID';

  public $timestamps = false;



  protected $fillable = [
    "storeID",
    "retekCode",
    "salesDate",
    "creditDate",
    "depositDate",
    "accountNo",
    "colBank",
    "description",
    "transactionBranch",
    "creditAmount",
    "debitAmount",
    "remarks",
    "missingRemarks",
    "tender",
    "isActive",
    "createdBy",
    "modifiedBy"
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