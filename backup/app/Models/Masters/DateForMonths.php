<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateForMonths extends Model {
    use HasFactory;

    protected $table = 'tbl_mDateForMonths';

    /**
     * Primary id is set to
     *
     * @var string
     */

    protected $primaryKey = 'dateUID';



    /***
     * Time stamps
     */
    const CREATED_AT = 'createdDt';

    /***
     * Time stamps
     */
    const UPDATED_AT = 'modifiedDt';

}