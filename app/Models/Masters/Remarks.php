<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remarks extends Model {
    use HasFactory;

    protected $table = 'tbl_mRemarks';

    /**
     * Primary id is set to
     *
     * @var string
     */

    protected $primaryKey = 'remarkUID';



    /***
     * Time stamps
     */
    const CREATED_AT = 'createdDate';

    /***
     * Time stamps
     */
    const UPDATED_AT = 'modifiedDate';

}