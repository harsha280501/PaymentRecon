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
      'storeID',
      'openingDt',
      'oldRetekCode',
      'newRetekCode',
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
