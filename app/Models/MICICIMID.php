<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MICICIMID extends Model {
    use HasFactory;


    protected $table = 'tbl_mIcici_MID';

    protected $primaryKey = 'iciciMIDUID';


    protected $fillable = [

        'MID',
        'storeID',
        'openingDt',
        'oldRetekCode',
        'newRetekCode',
        'brandCode',
        'Status',
        'closureDate',
        'conversionDt',
        'relevance',
        'POS',
        'Store Code',
        'EDCServiceProvider',
        'filename',
        'isActive',
        'createdBy',
        'createdDate',
        'modifiedBy',
        'modifiedDate',

    ];

    public $timestamps = false;


}
