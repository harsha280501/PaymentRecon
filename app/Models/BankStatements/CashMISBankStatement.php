<?php

namespace App\Models\BankStatements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashMISBankStatement extends Model {
    use HasFactory;

    protected $table = "MFL_Outward_CashMISBkStReco";
    protected $primaryKey = "cashMisBkStRecoUID";


    protected $fillable = [
        'storeID',
        'retekCode',
        'colBank',
        'locationName',
        'crDt',
        'depostSlipNo',
        'depositAmount',
        'depositDt',
        'creditAmount',
        'refNo',
        'diffSaleDeposit',
        'status',
        'isActive',
        'createdBy',
        'createdDate',
        'modifiedBy',
        'modifiedDate',
        'reconStatus',
        'adjAmount',
        'reconDifference',
        'processDt',
        'approvalRemarks',

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
