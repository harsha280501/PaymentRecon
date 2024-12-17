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
      'storeID',
      'openingDt',
      'oldRetekCode',
      'newRetekCode',
      'brandName',
      'Status',
      'closureDate',
      'relevance',
      'POS',
      'Store Code',
      'EDCServiceProvider',
      'filename',
      'conversionDt',
      'isActive',
      'createdBy',
      'createdDate',
      'modifiedBy',
      'modifiedDate',
    ];

    public $timestamps = false;


}
