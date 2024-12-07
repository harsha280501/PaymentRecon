<?php

namespace App\Models\Process\MPOS\Card;

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


    protected $table = 'MLF_Outward_MPOSCardSalesReco_ApprovalProcess';


    /**
     * Table primary key
     * @var string
     */

    protected $primaryKey = 'mposCardSalesRecoUID';






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
        'mposCardSalesRecoUID',
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
        return $this->belongsTo(CardRecon::class, 'mposCardSalesRecoUID', 'mposCardSalesRecoUID');
    }



}