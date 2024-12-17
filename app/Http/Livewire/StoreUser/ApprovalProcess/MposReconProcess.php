<?php

namespace App\Http\Livewire\StoreUser\ApprovalProcess;

use App\Traits\HasTabs;
use Livewire\Component;
use App\Interface\UseTabs;
use App\Traits\ParseMonths;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use App\Interface\Excel\WithHeaders;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;
use App\Traits\UseDefaults;
use App\Traits\UseOrderBy;
use App\Traits\WithStoreFormatting;

class MposReconProcess extends Component implements UseExcelDataset, WithFormatting, WithHeaders {

    use HasInfinityScroll, HasTabs, ParseMonths, StreamExcelDownload, WithExportDate, UseOrderBy, UseDefaults, WithStoreFormatting;


    /**
     * (Main) Display tab
     * @var string
     */
    public $activeTab = 'main';




    
    public $status = '';





    /** f
     * Filenameor export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Approved_Cash_Reconciliation';


    






    public function headers(): array {

        return [
            "Sales Date",
            "Deposit Date",
            "Bank Drop ID",
            "Deposit SlipNo",
            "Status",
            "Reconciliation Status",
            "Tender Amount",
            "Deposit Amount",
            "Tender to CashMIS Diff [Tender-Deposit]",
            "Store Response Entry",
        ];
    }


    
    public function download(string $type = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Approved_Process_MPOS_Reconciliation :procType, :storeId, :from, :to, :status',
            [
                'procType' => 'export',
                'storeId' => auth()->user()->storeUID,
                'from' => $this->startDate,
                'to' => $this->endDate,
                'status' => $this->status
            ],
            $this->perPage,
            $this->orderBy,
        );
    }



    

    /**
     * Data source
     * @return array
     */
    public function getData() {
        // Parameters to pass to the Query
        $params = [
            'procType' => $this->activeTab,
            'storeId' => auth()->user()->storeUID,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'status' => $this->status
        ];

        // Procedure Instance
        return DB::withOrderBySelect(
            storedProcedure: 'PaymentMIS_PROC_SELECT_STOREUSER_Approved_Process_MPOS_Reconciliation :procType, :storeId, :from, :to, :status',
            params: $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy,

        );
    }


    

    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $cashRecon = $this->getData();

        return view('livewire.store-user.approval-process.mpos-recon-process ', [
            'cashRecons' => $cashRecon
        ]);
    }

}
