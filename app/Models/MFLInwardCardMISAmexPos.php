<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardCardMISAmexPos extends Model {
  use HasFactory;


  protected $table = 'MFL_Inward_CardMIS_AmexPos';

  protected $primaryKey = 'CardMISAmexPosUID';


  protected $fillable = [

    'colBank',
    'acctNo',
    'merCode',
    'tid',
    'mid',
    'depositDt',
    'crDt',
    'depositAmount',
    'intnlAmt',
    'domesticAmt',
    'mdrRate',
    'msfComm',
    'cgstAmt',
    'sgstAmt',
    'igstAmt',
    'ugstAmt',
    'gstTotal',
    'netAmount',
    'GlTxn',
    'cardTypes',
    'cardNumber',
    'transactionType',
    'procDt',
    'approvCode',
    'settlAmount',
    'servTax',
    'sbCess',
    'kkCess',
    'drCrType',
    'arnNo',
    'midCity',
    'recFmt',
    'batNbr',
    'tranId',
    'upValue',
    'merchantTrackid',
    'invoiceNumber',
    'gstnTransactionId',
    'udf1',
    'udf2',
    'udf3',
    'udf4',
    'udf5',
    'sequenceNumber',
    'tranType',
    'merchantName',
    'merchantVpa',
    'payerVpa',
    'orderId',
    'currency',
    'nameAndLoc',
    'mcc',
    'onusOffus',
    'penaltyMdrRate',
    'penaltyMdrAmt',
    'penaltyServiceTax',
    'cashbackAmt',
    'incMdrRate',
    'incAmt',
    'incServiceTax',
    'penaltySbc',
    'penaltyKcc',
    'branchCode',
    'circle',
    'CardType',
    'sponsorbank',
    'PenaltyGST',
    'GSTIN',
    'Paymentmode',
    'Interchange',
    'TranIdentifier',
    'SuperMID',
    'ParentMID',
    'AirlineTicketNumber',
    'AdjustmentType',
    'isActive',
    'createdBy',
    'createdDate',
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