<?php

namespace App\Models\Process\MPOS\Cash;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashBankReconApproval extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'MFL_Outward_MPOSCashBankMISSalesReco_ApprovalProcess';


    /**
     * Table primary key
     * @var string
     */

    protected $primaryKey = 'mposCashBankMISSalesRecoUID';




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
        'remarks'
    ];


    /**
     * Relations: Process
     * @description
     * Has Many Process Records Items
     * @return void
     */
    public function process(): BelongsTo {
        return $this->belongsTo(CashBankRecon::class, 'mposCashBankMISSalesRecoUID', 'mposCashBankMISSalesRecoUID');
    }
}