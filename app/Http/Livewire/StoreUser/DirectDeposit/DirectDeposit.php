<?php

namespace App\Http\Livewire\StoreUser\DirectDeposit;

use App\Exports\StoreUser\DirectDeposit\DepositExport;
use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\UseRemarks;
use App\Traits\ParseMonths;
use Livewire\WithFileUploads;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\WithExportDate;


class DirectDeposit extends Component {


    use HasInfinityScroll, ParseMonths, UseOrderBy, UseRemarks, WithFileUploads, UseOrderBy, WithExportDate;



    /**
     * Used for filtering 
     * @var 
     */
    public $filtering = false;





    /**
     * Date filter: Start
     * @var 
     */
    public $startdate = null;



    /**
     * Date filter: end
     * @var 
     */
    public $enddate = null;



    /**
     * Remarks
     * @var array
     */
    public $remarks = [];



    public $retekCode;
    public $depositSlipNo;
    public $amount;
    public $date;
    public $bank;
    public $accountNo;
    public $bankBranch;
    public $location;
    public $city;
    public $state;
    public $salesDateFrom;
    public $salesDateTo;
    public $cashDepositBy;
    public $otherRemarks;
    public $reason;
    public $depositSlipProof;




    /**
     * Filter dates
     * @param mixed $data
     * @return void
     */
    public function filterDate($data) {
        $this->filtering = true;
        $this->startdate = $data['start'];
        $this->enddate = $data['end'];
    }




    /**
     * Return to main
     * @return void
     */
    public function back() {
        $this->resetExcept('');
        $this->emit('resetAll');
    }




    /**
     * Render the main function
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        return view('livewire.store-user.direct-deposit.direct-deposit', [
            'dataset' => $this->dataset()
        ]);
    }

    /**
     * Get the Main data
     * @return array
     */
    public function dataset() {
        return DB::withOrderBySelect('PaymentMIS_PROC_STOREUSER_SELECT_Direct_Deposit :procType, :storeId, :from, :to', [
            'procType' => 'DirectDeposit',
            'storeId' => auth()->user()->storeUID,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ], $this->perPage, $this->orderBy);
    }





    public function export(string $type = '') {
        $main = DB::withOrderBySelect(
            'PaymentMIS_PROC_STOREUSER_SELECT_Direct_Deposit :procType, :storeId, :from, :to',
            [
                'procType' => 'export-DirectDeposit',
                'storeId' => auth()->user()->storeUID,
                'from' => $this->startdate,
                'to' => $this->enddate,
            ],
            $this->perPage,
            $this->orderBy
        );


        if (count($main) < 1) {
            $this->emit('no-data');
            return;
        }

        return Excel::download(new DepositExport($main), $this->_useToday('Payment_MIS_Deposit_', $type));
    }
}
