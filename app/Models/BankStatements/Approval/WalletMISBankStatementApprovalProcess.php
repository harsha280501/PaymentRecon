<?php

namespace App\Models\BankStatements\Approval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletMISBankStatementApprovalProcess extends Model {
    use HasFactory;

    protected $table = "MLF_Outward_WalletMISBankStReco_ApprovalProcess";
    protected $primaryKey = "bankStWalletApprovalprocessUID";


    protected $fillable = [
        "walletMisBkStRecoUID",
        "item",
        "bankName",
        "creditDate",
        "slipnoORReferenceNo",
        "differenceAmount",
        "remarks",
        "supportDocupload",
        "reasonMismatch",
        "reasonDisapprove",
        "approveStatus",
        "createdBy",
        "approvedBy",
        "approvalDate",
        "createdDate",
        "modifiedDate",
        "modifiedBy",
        "amount",
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
