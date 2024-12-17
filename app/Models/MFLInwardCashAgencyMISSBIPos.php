<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardCashAgencyMISSBIPos extends Model
{
    use HasFactory;


    protected $table = 'MFL_Inward_CashAgencyMIS_SBIPos';

    protected $primaryKey = 'agencyMISSbiPosUID';


    protected $fillable = [
      'storeID',
      'retekCode',
      'colBank',
      'depositDate',
      'region',
      'location',
      'pointName',
      'pointAddress',
      'pickupAgencyCode',
      'city',
      'poolingAccNo',
      'clientName',
      'clientCode',
      'SAPCode',
      'LOIDate',
      'cashLimit',
      'pickupFrequency',
      'HCINo',
      'pickupAmount',
      'depositSlipNo',
      'depositAmount',
      'sealingTagNo',
      'depositBranchName',
      'depositBranchCode',
      'vaultAmount',
      'two2000',
      'one1000',
      'five500',
      'two200',
      'one100',
      'fifty50',
      'twenty20',
      'ten10',
      'five5',
      'others',
      'total',
      'difference',
      'previousDayVaultDepositAmount',
      'accountNo',
      'branchName',
      'noOfChequesPickupDone',
      'recieptNo',
      'depositionBank',
      'depositionDate',
      'remarks',
      'status',
      'pointId',
      'filename',
      'isActive',
      'createdBy',
      'createdDate',
      'modifiedBy',
      'modifiedDate'
     ];

    public $timestamps = false;


}
