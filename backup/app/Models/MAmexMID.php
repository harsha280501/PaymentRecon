<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MAmexMID extends Model {
    use HasFactory;


    protected $table = 'tbl_mAmex_MID';

    protected $primaryKey = 'amexMIDUID';


    protected $fillable = [
        'MID',
        'POS',
        'storeID',
        'retekCode',
        'brandName',
        'Status',
        'openingDt',
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
