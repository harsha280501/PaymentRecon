<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardBankStatementICICI extends Model
{
    use HasFactory;


    protected $table = 'MFL_Inward_BankStatement_ICICI';

    protected $primaryKey = 'iciciBankUID';


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
        'origSolID',
        'filename',
        'isActive',
        'createdBy',
        'createdDate',
        'modifiedBy',
        'modifiedDate'
     ];

    public $timestamps = false;


}
