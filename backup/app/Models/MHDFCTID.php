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
        'POS',
        'storeID',
        'retekCode',
        'brandName',
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
