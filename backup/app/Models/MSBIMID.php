<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MSBIMID extends Model {
    use HasFactory;


    protected $table = 'tbl_mSBI_MIS';

    protected $primaryKey = 'sbiMIDUID';


    protected $fillable = [
        'MID',
        'POS',
        'storeID',
        'retekCode',
        'openingDt',
        'brandName',
        'Status',
        'closureDate',
        'relevance',
        'Store Code',
        'EDCServiceProvider',
        'fileName',
        'isActive',
        'createdBy',
        'createdDate',
        'modifiedBy',
        'modifiedDate',
    ];

    public $timestamps = false;


}
