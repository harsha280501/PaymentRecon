<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardBankStatementAxis extends Model
{
    use HasFactory;


    protected $table = 'MFL_Inward_BankStatement_Axis';

    protected $primaryKey = 'axisBankUID';


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
