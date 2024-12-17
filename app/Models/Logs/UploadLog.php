<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Model;

class UploadLog extends Model {

    protected $table = 'tbl_UploadLogs';



    /**
     * Primary id is set to
     *
     * @var string
     */
    protected $primaryKey = 'LogId';





    /***
     * Time stamps
     */
    const CREATED_AT = 'createdDate';






    /***
     * Time stamps
     */
    const UPDATED_AT = 'modifiedDate';




    protected $fillable = [
        'logType',
        'bankName',
        'fileName',
        'uploadTableName',
        'fileType',
        'totalRecordCount',
        'completedCount',
        'startingRecord',
        'endingRecord',
        'status',
        'completedAt',
        'isError',
        'errorAt',
        'errorEmailedTo',
        'errorMessage',
        'uploadedAt'
    ];
}