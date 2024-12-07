<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MRepository extends Model
{
    use HasFactory;


    protected $table = 'tbl_mRepository';

    protected $primaryKey = 'repositoryUID';


    protected $fillable = [
        'importDate',
        'fileName',
        'isActive',
        'createdBy',
        'createdDate',
        'modifiedBy',
        'modifiedDate',
    ];

    public $timestamps = false;


}