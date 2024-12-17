<?php

namespace App\Models\Process\Card;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardBankRecon extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $table = 'MFL_Outward_MPOSCardSalesReco';


    /**
     * Table primary key
     * @var string
     */

    protected $primaryKey = 'mposCardSalesRecoUID';




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
    public function processRecords(): HasMany {
        return $this->hasMany(CardReconApproval::class, 'mposCardSalesRecoUID', 'mposCardSalesRecoUID');
    }


}