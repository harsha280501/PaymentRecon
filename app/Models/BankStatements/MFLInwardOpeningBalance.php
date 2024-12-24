<?php

namespace App\Models\BankStatements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardOpeningBalance extends Model {
    use HasFactory;

    protected $table = "MFL_Inward_OpeningBalanceFromCommerical";
    protected $primaryKey = "openBalanceUID";


    protected $fillable = [
        "storeID",
        "retekCode",
        "openingBalanceDate",
        "openingBalanceYear",
        "cashOpBalance",
        "cardOpBalance",
        "upiOpBalance",
        "walletOpBalance",
        "totalOpBalance",
        "openBalanceRemarks",  
        "filename",      
        "isActive",
        "createdBy",
        "createdDate",
        "modifiedBy",
        "modifiedDate"       

    ];

    /**
     * Time stamps
     * @var string
     */
    const CREATED_AT = 'createdDate';

    /**
     * Time stamps
     * @var string
     */
    const UPDATED_AT = 'modifiedDate';

}
