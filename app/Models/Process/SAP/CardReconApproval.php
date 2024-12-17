<?php

namespace App\Models\Process\SAP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardReconApproval extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $table = 'MFL_Outward_CardSalesReco_ApprovalProcess';


    /**
     * Table primary key
     * @var string
     */

    protected $primaryKey = 'cardApprovalprocessUID';





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




    /**
     * Set the Fillable to prevent mass assignment
     * @var array
     */
    protected $fillable = [
        "cardSalesRecoUID",
        "creditDate",
        "item",
        "saleAmount",
        "depositAmount",
        "reasonMismatch",
        "supportDocupload",
        "corrrectionDate",
        "approveStatus",
        "createdBy",
        "approvedBy",
        "approvalDate",
        "remarks",
        "bankName",
        "cheadRemarks",
        "recoSalesDate",
        "recoStoreID",
        "recoSalesAmount",
        "recoDepositAmount",
        "approveStatus"
    ];

}