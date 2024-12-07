<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    /**
     * table name is not per ps-12 standards
     * @var string
     */
    protected $table = 'tbl_mRole';

    /**
     * Primary id is set to
     *
     * @var string
     */

    protected $primaryKey = 'roleUID';

    /***
     * Time stamps
     */
    const CREATED_AT = 'createdDate';
    const UPDATED_AT = 'modifiedDate';
}