<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoreUpdateHistory extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $table = 'tbl_UpdateStoreID_History';


    /**
     * Table primary key
     * @var string
     */

    protected $primaryKey = 'UID';




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
        "UID",
        "updatedDate",
        "depositDt",
        "newStoreID",
        "oldStoreID",
        "dateFrom",
        "dateTo",
        "Colbank",
        "isActive",
        "Remarks",
    ];

}


