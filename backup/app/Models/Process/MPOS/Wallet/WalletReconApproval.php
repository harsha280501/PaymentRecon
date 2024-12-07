<?php

namespace App\Models\Process\MPOS\Wallet;

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

    protected $table = 'MLF_Outward_MPOSWalletSalesReco_ApprovalProcess';


    /**
     * Table primary key
     * @var string
     */

    protected $primaryKey = 'mposWalletApprovalprocessUID';




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
        'item',
        'bankName',
        'creditDate',
        'slipnoORReferenceNo',
        'amount',
        'supportDocupload',
        'approveStatus',
        'createdBy',
        'approvedBy',
        'approvalDate',
        'createdDate',
        'modifiedDate',
        'modifiedBy',
        'remarks',
    ];




    /**
     * Relations: Process
     * @description
     * Has Many Process Records Items
     * @return void
     */
    public function process(): BelongsTo {
        return $this->belongsTo(WalletRecon::class, 'mposWalletSalesRecoUID', 'mposWalletSalesRecoUID');
    }


}