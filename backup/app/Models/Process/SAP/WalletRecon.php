<?php

namespace App\Models\Process\SAP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WalletRecon extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $table = 'MFL_Outward_WalletSalesReco';


    /**
     * Table primary key
     * @var string
     */

    protected $primaryKey = 'walletSalesRecoUID';





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
        'storeID',
        'retekCode',
        'brand',
        'walletSale',
        'transactionDate',
        'collectionBank',
        'depositDate',
        'depositAmount',
        'diffSaleDeposit',
        'status',
        'isActive',
        'createdBy',
        'createdDate',
        'modifiedBy',
        'modifiedDate',
        'approvedBy',
        'approvedDate',
        'saleReconDifferenceAmount',
        'reconStatus',
        'adjAmount',
        'reconDifference'
    ];


    /**
     * Relations: Process
     * @description
     * Has Many Process Records Items
     * @return void
     */
    public function processRecords(): HasMany {
        return $this->hasMany(App\Models\Process\SAP\WalletReconApproval::class, 'walletSalesRecoUID', 'walletSalesRecoUID');
    }
}