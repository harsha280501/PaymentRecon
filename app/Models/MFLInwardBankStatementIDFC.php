<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardBankStatementIDFC extends Model
{
    use HasFactory;


    protected $table = 'MFL_Inward_BankStatement_IDFC';

    protected $primaryKey = 'idfcBankUID';


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
        'modifiedDate'
     ];

    public $timestamps = false;


}
