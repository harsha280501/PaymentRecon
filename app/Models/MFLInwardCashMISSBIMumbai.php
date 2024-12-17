<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardCashMISSBIMumbai extends Model {
  use HasFactory;


  protected $table = 'MFL_Inward_CashMIS_SBI_Mumbai';

  protected $primaryKey = 'CashMISSbiMumUID';

  public $timestamps = false;



  protected $fillable = [

      'storeID'
      ,'retekCode'
      ,'colBank'
      ,'brand'
      ,'depositAmount'
      ,'depositDate'
      ,'shopID'
      ,'clientName'
      ,'customerName'
      ,'customerCode'
      ,'customerPointCode'
      ,'locationName'
      ,'sealTagNo'      
      ,'missingRemarks'
      ,'filename'
      ,'isActive'
      ,'createdBy'
      ,'createdDate'
      ,'modifiedBy'
      ,'modifiedDate',
      
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