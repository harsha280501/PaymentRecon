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
        'POS',
        'storeID',
        'retekCode',
        'brandCode',
        'openingDt',
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
