<?php

namespace App\Models\Process;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllTenderReco extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $table = 'MFL_Outward_CardSalesReco_ALLCARDUPI';


    /**
     * Table primary key
     * @var string
     */

    protected $primaryKey = 'allTenderRecoUID';






    /***
     * Time stamps
     */
    const CREATED_AT = 'createdDate';

    /***
     * Time stamps
     */
    const UPDATED_AT = 'modifiedDate';





    /**
     * Set the Fillable to prevent mass assignment
     * @var array
     */
    protected $fillable = [
        "salesDate",
        "depositDate",
        "storeID",
        "status",
        "retekCode",
        "brand",
        "location",
        "salesCash",
        "salesCard",
        "salesHDFCCard",
        "salesAMEXCard",
        "salesICICICard",
        "salesSBICard",
        "salesUPI",
        "salesWallet",
        "salesPayTM",
        "salesPHONEPAY",
        "salesTotal",
        "collectionCash",
        "collectionCard",
        "collectionHDFCCard",
        "collectionAMEXCard",
        "collectionICICICard",
        "collectionSBICard",
        "collectionUPI",
        "collectionWallet",
        "collectionPayTM",
        "collectionPHONEPAY",
        "collectionTotal",
        "adjustmentCashTotal",
        "adjustmentCardTotal",
        "adjustmentHDFCCard",
        "adjustmentAMEXCard",
        "adjustmentICICICard",
        "adjustmentSBICard",
        "adjustmentUPI",
        "adjustmentWallet",
        "adjustmentPayTM",
        "adjustmentPHONEPAY",
        "adjustmentTotal",
        "differenceCash",
        "differenceCard",
        "differenceHDFCCard",
        "differenceAMEXCard",
        "differenceICICICard",
        "differenceSBICard",
        "differenceUPI",
        "differenceWallet",
        "differencePayTM",
        "differencePHONEPAY",
        "differenceTotal",
    ];






    /**
     * update alltender on cash approval
     * @return void
     */
    public static function updateItem() {
        dd(1);
    }



}