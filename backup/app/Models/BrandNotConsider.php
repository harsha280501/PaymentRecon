<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrandNotConsider extends Model {
    
    use HasFactory;


    protected $table = 'Not_Consider_Brand';

    protected $primaryKey = 'brandUID';


    protected $fillable = [
        'brand',        
        'isActive',
        'createdBy',
        'createdDate',
        'modifiedBy',
        'modifiedDate',
    ];

    public $timestamps = false;


}
