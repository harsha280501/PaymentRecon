<?php

namespace App\Models\Process\SAP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletReconApproval extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'MFL_Outward_WalletSalesReco_ApprovalProcess';


    /**
     * Table primary key
     * @var string
     */

    protected $primaryKey = 'walletApprovalprocessUID';





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
        'walletSalesRecoUID',
        'item',
        'bankName',
        'creditDate',
        'referenceNo',
        'saleAmount',
        'depositAmount',
        'reasonMismatch',
        'supportDocupload',
        'corrrectionDate',
        'approveStatus',
        'createdBy',
        'approvedBy',
        'approvalDate',
        'createdDate',
        'modifiedDate',
        'modifiedBy',
        'remarks',
        'cheadRemarks',
    ];



    /**
     * Relations: Process
     * @description
     * Has Many Process Records Items
     * @return void
     */
    public function process(): BelongsTo {
        return $this->belongsTo(App\Models\Process\SAP\WalletRecon::class, 'walletSalesRecoUID', 'walletSalesRecoUID');
    }


}