<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardBankStatementHDFC extends Model
{
    use HasFactory;


    protected $table = 'MFL_Inward_BankStatement_HDFC';

    protected $primaryKey = 'hdfcBankUID';


    protected $fillable = [
      'colBank',
      'accountNo',
      'depositDate',
      'creditDate',
      'description',
      'remaksReferenceNo',      
      'debit',
      'credit',      
      'transactionBr',
      'filename',
      'isActive',
      'createdBy',
      'createdDate',
      'modifiedBy',
      'modifiedDate',
      'matchedStatus',
      'reconTimestamp'
     ];

    public $timestamps = false;


}
