<?php

namespace App\Models\Process\SAP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardRecon extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $table = 'MFL_Outward_CardSalesReco';


    /**
     * Table primary key
     * @var string
     */

    protected $primaryKey = 'cardSalesRecoUID';





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
        "storeID",
        "retekCode",
        "brand",
        "cardSale",
        "transactionDate",
        "collectionBank",
        "depositDt",
        "depositAmount",
        "diffSaleDeposit",
        "status",
        "approvedBy",
        "approvedDate",
        "saleReconDifferenceAmount",
        "reconStatus",
        "adjAmount",
        "reconDifference",
        "processDt",
        "approvalRemarks",
        "salesBank",
    ];



    /**
     * Relations: Process
     * @description
     * Has Many Process Records Items
     * @return void
     */
    public function processRecords(): HasMany {
        return $this->hasMany(CardReconApproval::class, 'mposCardSalesRecoUID', 'mposCardSalesRecoUID');
    }


}