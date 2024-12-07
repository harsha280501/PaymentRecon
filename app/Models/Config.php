<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = "tbl_mSysConfig";
    protected $primaryKey = "sysConfigUID";




    public static function reconciliedDate(): string {
        return Carbon::parse(self::where(column: 'configName', operator: '=', value: 'reconcil-upto')->first(columns: 'configValue')?->configValue)->format('d-m-Y');
    }

}
