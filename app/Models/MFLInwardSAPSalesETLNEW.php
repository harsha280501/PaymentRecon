<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFLInwardSAPSalesETLNEW extends Model
{
    use HasFactory;


    protected $table = 'MFL_Inward_SAP_SalesETL_NEW';

    //protected $primaryKey = 'mflAxisPosCashRawUID';


    protected $fillable = [
        'CALDAY',
        'CALMONTH',
        'Location',
        'Tender Type',
        'Transaction Number',
        'RETEK_CODE',
        'Tender value',
        'Tender Description',
        'Store ID',
        'Brand Desc',
        'TenderType',
        'Type',
        'CUSTOMER'
    ];

    public $timestamps = false;


}