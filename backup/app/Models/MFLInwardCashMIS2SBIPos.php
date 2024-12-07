<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardCashMIS2SBIPos extends Model {
  use HasFactory;


  protected $table = 'MFL_inward_CashMIS2_SBIPos';

  protected $primaryKey = 'CashMISSbiPosUID';

  public $timestamps = false;



  protected $fillable = [

      'colBank'
      ,'SRNo'
      ,'UTR'
      ,'VAN'
      ,'depositAmount'
      ,'depositDt'
      ,'chequeDate'
      ,'chequeNumber'
      ,'corpName'
      ,'corporateID'
      ,'creditAccountNumber'
      ,'creditTime'
      ,'creditCancelDate'
      ,'dealerAmount'
      ,'dealerCode'
      ,'dealerName'
      ,'depositBranchCodeCDM'
      ,'depositBranchName'
      ,'district'
      ,'fileNameExcel'
      ,'inputMode'
      ,'pinCode'
      ,'presentationDate'
      ,'product'
      ,'regionName'
      ,'reportGenerationDate'
      ,'returnReason'
      ,'senderAccountName'
      ,'senderAccountNumber'
      ,'senderBank'
      ,'senderBankLocation'
      ,'senderIFSC'
      ,'transactionStatus'
      ,'uniqueReferenceNumber'
      ,'missingRemarks'
      ,'filename'
      ,'isActive'
      ,'createdBy'
      ,'createdDate'
      ,'modifiedBy'
      ,'modifiedDate',
      'missingRemarks',
      'unAllocatedRemarks',
      'unAllocatedCorrectionDate',
      'unAllocatedStatus',
      'storeID',
      'retekCode',
      'brand',
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