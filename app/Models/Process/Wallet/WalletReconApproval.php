<?php

namespace App\Models\Process\Wallet;

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

    protected $primaryKey = 'mposWalletSalesRecoUID';




    /**
     * Set the Fillable to prevent mass assignment
     * @var array
     */
    protected $fillable = [
        //
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