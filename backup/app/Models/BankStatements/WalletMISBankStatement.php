<?php

namespace App\Models\BankStatements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletMISBankStatement extends Model {
    use HasFactory;

    protected $table = "MFL_Outward_WalletMISBankStReco";
    protected $primaryKey = "walletMisBankStRecoUID";


    protected $fillable = [
        "storeID",
        "retekCode",
        "colBank",
        "merCode",
        "tid",
        "mid",
        "depositDt",
        "creditDt",
        "depositAmount",
        "msfComm",
        "gstTotal",
        "netAmount",
        "creditAmount",
        "bankDepositDt",
        "diffSaleDeposit",
        "bankRrefORutrNo",
        "reconTimestamp",
        "status",
        "isActive",
        "createdBy",
        "createdDate",
        "modifiedBy",
        "modifiedDate",
        "reconStatus",
        "adjAmount",
        "reconDifference",
        "processDt",
        "approvalRemarks",

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
