<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDateFormat extends Model
{
    use HasFactory;


    protected $table = 'tbl_mDateFormat';

    protected $primaryKey = 'dateformatUID';


    protected $fillable = [
      'bankName'
      ,'bankDateFormat'
      ,'convertDBDateFormat'
      ,'convertDisplayFormat'
      ,'description'      
      ,'isActive'
      ,'createdBy'
      ,'createdDate'
      ,'modifiedBy'
      ,'modifiedDate',
      ];

    public $timestamps = false;


}