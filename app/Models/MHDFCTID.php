<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MHDFCTID extends Model {
    use HasFactory;


    protected $table = 'tbl_mHdfc_TID';

    protected $primaryKey = 'hdfcTIDUID';


    protected $fillable = [
        'TID',
        'storeID',
        'openingDt',
        'newRetekCode',
        'oldRetekCode',
        'brandName',
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
