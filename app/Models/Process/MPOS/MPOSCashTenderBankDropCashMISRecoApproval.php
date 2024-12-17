<?php

namespace App\Models\Process\MPOS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MPOSCashTenderBankDropCashMISRecoApproval extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $table = 'MFL_Outward_MPOSCashTenderBankDropCashMISReco_ApprovalProcess';


    /**
     * Table primary key
     * @var string
     */

    protected $primaryKey = 'mposBkMISSalesUID';




    /**
     * Time stamps
     * @var string
     */
    const CREATED_AT = 'createdDate';

    /**
     * Time stamps
     * @var string
     */
    const UPDATED_AT = 'modifiedDate';





    /**
     * Set the Fillable to prevent mass assignment
     * @var array
     */
    protected $fillable = [
        'storeID',
        'retekCode',
        'brand',
        'depositDate',
        'businessDropDate',
        'bankDropAmount',
        'depositAmount',
        'depositSlipNo',
        'DiffAmount',
        'status',
        'adjAmount',
        'approvedBy',
        'approvedDate',
        'saleReconDifferenceAmount',
        'reconStatus',
        'isActive',
        'createdBy',
        'createdDate',
        'modifiedBy',
        'modifiedDate',
        'tenderAdj',
        'bankAdj',
        'cheadRemarks'
    ];




    /**
     * Relations: Process
     * @description
     * Has Many Process Records Items
     * @return void
     */
    public function processRecords(): HasMany {
        return $this->hasMany(CashBankReconApproval::class, 'mposCashBankMISSalesRecoUID', 'mposCashBankMISSalesRecoUID');
    }

}