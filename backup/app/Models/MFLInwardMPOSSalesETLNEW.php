<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardMPOSSalesETLNEW extends Model
{
    use HasFactory;


    protected $table = 'MFL_inward_MPOS_SalesETL_NEW';

    //protected $primaryKey = 'mflAxisPosCashRawUID';


    protected $fillable = [
        'Date',
        'Store ID',
        'RETEK Code',
        'Store Name',
        'Tender Value',
        'TENDERTYPE',
        'Tender Description',
        'Transaction Type'
    ];

    public $timestamps = false;


}