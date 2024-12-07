<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFranchiseeDebit extends Model {
  use HasFactory;


  protected $table = 'mFranchiseDebit';

  protected $primaryKey = 'franchiseeUID';


  protected $fillable = [
    'storeID',
    'brand',
    'colBank',
    'salesPeriod',
    'dateOfDebit',
    'docNo',
    'debit',
    'isActive',
    'createdBy',
    'createdDate',
    'modifiedBy',
    'modifiedDate',
    'filename',
    'missingRemarks',
    'unAllocatedRemarks',
    'unAllocatedCorrectionDate',
    'unAllocatedStatus',
  ];

  public $timestamps = false;
}