<?php

namespace App\Models\BankStatements\Approval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashMISBankStatementApprovalProcess extends Model {
    use HasFactory;

    protected $table = "MLF_Outward_CashMISBankStReco_ApprovalProcess";
    protected $primaryKey = "bankStatmentApprovalprocessUID";


    protected $fillable = [
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
