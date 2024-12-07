<?php

namespace App\Http\Livewire\StoreUser\ApprovalProcess;

use App\Traits\HasTabs;
use App\Traits\UseDefaults;
use Livewire\Component;
use App\Traits\ParseMonths;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use App\Interface\Excel\WithHeaders;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;
use App\Traits\UseOrderBy;
use App\Traits\WithStoreFormatting;

class CardReconProcess extends Component implements UseExcelDataset, WithFormatting, WithHeaders {

    use HasInfinityScroll, HasTabs, ParseMonths, StreamExcelDownload, WithExportDate, UseOrderBy, UseDefaults, WithStoreFormatting;




    public $activeTab = 'card';
    

    
    public $status = '';


    /** 
     * Filenameor export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Approved_Card_Reconciliation';




    public function headers(): array {

        return [
            "Sales Date",
            "Deposit Date",
            "Status",
            "Recon Status",
            "Card Sale",
            "Deposit Amount",
            "Difference",
            "Adjusted Amount",
        ];
    }



    public function download(string $type = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_Approved_Process_Card_Reconciliation :procType, :store, :from, :to, :status',
            [
                'procType' => 'export',
                'store' => auth()->user()->storeUID,
                'from' => $this->startDate,
                'to' => $this->endDate,
                'status' => $this->status
            ],
            $this->perPage,
            $this->orderBy
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
            'store' => auth()->user()->storeUID,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'status' => $this->status
        ];

        // Procedure Instance
        return DB::withOrderBySelect(
            storedProcedure: 'PaymentMIS_PROC_SELECT_STOREUSER_Approved_Process_Card_Reconciliation :procType, :store, :from, :to, :status',
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
        return view('livewire.store-user.approval-process.card-recon-process ', [
            'cashRecons' => $cashRecon
        ]);
    }


}
