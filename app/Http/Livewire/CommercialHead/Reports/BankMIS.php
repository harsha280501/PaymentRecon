<?php

namespace App\Http\Livewire\CommercialHead\Reports;

use App\Exports\CommercialHead\Reports\BankMISExport;
use App\Interface\Excel\SpreadSheet;
use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasInfinityScroll;
use App\Traits\HasTabs;
use App\Traits\ParseMonths;
use App\Traits\StreamExcelDownload;
use App\Traits\UseDefaults;
use App\Traits\UseOrderBy;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Http\Request;


class BankMIS extends Component implements UseExcelDataset, WithHeaders
{

    use UseOrderBy, HasInfinityScroll, HasTabs, ParseMonths, WithExportDate;
    /**
     * Select the Payment Type
     * @var
     */
    protected $bankTypes;
    /**
     * Filtering, to show the back arrow
     *
     * @var boolean
     */
    public $filtering = false;
    /**
     * Filter dates (start)
     * @var
     */
    public $from = null;
    /**
     * Filter dates (end)
     * @var
     */
    public $to = null;
    /**
     * search by bank
     */
    public $bankName = '';
    /**
     * Filter by Store
     * @var string
     */
    public $store = '';
    /**
     * Store Filter list Array
     *
     * @var array
     */
    public $stores = [];
    /**
     * Store Filter list Array
     *
     * @var array
     */
    public $slips = [];
    /**
     * Store Filter list Array
     *
     * @var array
     */
    public $slip = '';
    /**
     * Active Tab
     * @var string
     */
    public $activeTab = "all-cash-mis";
    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];
    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Bank_MIS';
    /**
     * Filename to use in Export
     * @var array
     */
    public $sync_file_name = [
        'all-cash-mis' => 'All_Cash_MIS',
        'all-card-mis' => 'All_Card_MIS',
        'all-upi-mis' => 'All_UPI_MIS',
        'all-wallet-mis' => 'All_Wallet_MIS',
        'op-balance' => 'Opening_Balance',
    ];
    /**
     * Single Type
     * @var
     */
    public $bankType;
    /**
     * Cash Bank Names
     * @var array
     */
    public $cash_banks = [];
    /**
     * Card Bank Names
     * @var array
     */
    public $card_banks = [];
    /**
     * UPI Bank Names
     * @var array
     */
    public $upi_banks = [];
    /**
     * Wallet Bank Names
     * @var array
     */
    public $wallet_banks = [];
    // public $selectedTid = '';
    // protected $listeners = ['updateTid' => 'setSelectedTid'];
    public $searchRoute = "reports.bankMIS.searchStore";

    /**
     * Switch Tab 2 main
     * @return void
     */
    public function mount()
    {
        $this->_months = $this->_months()->toArray();
        // $this->cash_banks = $this->banks('all-cash-mis');
        $this->card_banks = $this->banks('all-card-mis');
        // $this->upi_banks = $this->banks('all-upi-mis');
        $this->wallet_banks = $this->banks('all-wallet-mis');
        $this->searchRoute;
    }

    // public function setSelectedTid($selectedTid)
    // {
    //     $this->selectedTid = $selectedTid;
    // }

    /**
     * Switching between tabs
     * @param mixed $tab
     * @return void
     */
    public function switchTab($tab): void
    {
        $this->activeTab = $tab;
        $this->emit('resetAll');
        $this->resetExcept('activeTab');
    }

    /**
     * Updating the bank name triggers the back button
     * @param mixed $item
     * @return void
     */
    public function updated($item)
    {
        if ($item === 'bankName' && $this->activeTab == 'all-cash-mis') {
            $this->emit('triggered:change');
            $this->filtering = true;
            $this->slip = '';
        }
    }
    /**
     * Date filter
     * @param mixed $obj
     * @return void
     */
    public function filterDate($obj)
    {
        $this->filtering = true;
        $this->from = $obj['start'];
        $this->to = $obj['end'];
    }

    /**
     * Reset all the filters
     * @return void
     */
    public function back()
    {
        $this->filtering = false;
        $this->slips = [];
        $this->resetExcept(['activeTab', 'card_banks', 'wallet_banks']);
        $this->emit('triggered:change');
        $this->emit('resetAll');
    }

    public function filtersSyncDataset(string $type)
    {

        $main = DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS :procType, :storeId,:bankName, :slipNo, :from, :to', [
            'procType' => 'all-cash-mis-' . $type,
            'storeId' => '',
            'bankName' => $this->bankName,
            'slipNo' => '',
            'from' => null,
            'to' => null
        ])->toArray();

        return $main;
    }

    public function headers(): array
    {
        if ($this->activeTab === "all-wallet-mis") {
            return [
                'Credit Date',
                'Deposit Date',
                'Store ID',
                'Retek Code',
                'Collection Bank',
                'TID',
                'Deposit Amount',
                'Fee',
                'GST',
                'Net Amount',
                'Bank Ref/UTR No'
            ];
        }

        if ($this->activeTab === 'all-card-mis') {
            return [
                'Credit Date',
                'Deposit Date',
                'Store ID',
                'Retek Code',
                'Collection Bank',

                'Merchant Code',
                'TID',
                'Deposit Amount',
                'MSF',
                'GST',
                'Net Amount'
            ];
        }

        if ($this->activeTab === 'all-upi-mis') {
            return [
                'Credit Date',
                'Deposit Date',
                'Store ID',
                'Retek Code',
                'Collection Bank',
                'Merchant Code',
                'TID',
                'Deposit Amount',
                'MSF',
                'GST',
                'Net Amount'
            ];
        }

        if ($this->activeTab === 'op-balance') {
            return [
                'storeID',
                'retekCode',
                'openingBalanceDate',
                'openingBalanceYear',
                'totalOpBalance',
            ];
        }

        return [
            'Credit Date',
            'Deposit Date',
            'Store ID',
            'Retek Code',
            'Pick Up Location ',
            'Deposit Through',
            'Collection Bank',
            'Slip Number',
            'Deposit Amount'
        ];
    }

    /**
     * Store Filter
     */
    public function stores()
    {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS :procType, :storeId, :bankName, :slipNo, :from, :to', [
            'procType' => $this->activeTab . '-stores',
            'storeId' => $this->store,
            'bankName' => $this->bankName,
            'slipNo' => '',
            'from' => $this->from,
            'to' => $this->to
        ]);
    }

    /**
     * Banks dataset
     * @param string $tab
     * @return array
     */
    public function banks(string $tab = 'all-cash-mis')
    {
        // returns data
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS :procType, :storeId, :bankName, :slipNo, :from, :to', [
            'procType' => $tab . '-banks',
            'storeId' => $this->store,
            'bankName' => $this->bankName,
            'slipNo' => '',
            'from' => $this->from,
            'to' => $this->to
        ]);
    }

    /**
     * @return mixed|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        $data = $this->download('');
        $headers = $this->headers();

        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }

        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists

        fputcsv($file, $headers);

        foreach ($data as $row) {
            $row = (array) $row;
            fputcsv($file, $row);
        }

        fclose($file);

        return response()->stream(
            function () use ($filePath) {
                echo file_get_contents($filePath);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '_' . $this->sync_file_name[$this->activeTab] . '"',
            ]
        );
    }

    /**
     * Get the total amounts
     * @return Collection|array
     */
    public function getTotals(): Collection|array
    {

        // if ($this->selectedTid) {
        //     $params = [
        //         'procType' => $this->activeTab . '-totals', // Concatenate active tab and '-totals'
        //         'storeId' => $this->store,
        //         'bankName' => $this->bankName,
        //         'slipNo' => $this->slip,
        //         'from' => $this->from,
        //         'to' => $this->to,
        //         'selectedTid' => $this->selectedTid, // Include selectedTid in parameters
        //         'PageSize' => $this->perPage,
        //         'orderBy' => $this->orderBy
        //     ];

        //     // Execute query and return results as a collection
        //     return collect(DB::select(
        //         'EXEC PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS
        //             @procType = :procType,
        //             @storeId = :storeId,
        //             @bankName = :bankName,
        //             @slipNo = :slipNo,
        //             @from = :from,
        //             @to = :to,
        //             @selectedTid = :selectedTid,
        //             @PageSize = :PageSize,
        //             @OrderBy = :orderBy',
        //         $params
        //     ));
        // } else {}
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS :procType, :storeId, :bankName, :slipNo, :from, :to',
            [
                'procType' => $this->activeTab . '-totals',
                'storeId' => $this->store,
                'bankName' => $this->bankName,
                'slipNo' => $this->slip,
                'from' => $this->from,
                'to' => $this->to
            ],
            $this->perPage,
            $this->orderBy
        );
    }
    /**
     * Export the filtered dataset
     */
    public function download(string $value = ''): Collection|bool
    {
        // Main Params to the query
        $params = [
            'procType' => $this->activeTab . '-export',
            'storeId' => $this->store,
            'bankName' => $this->bankName,
            'slipNo' => $this->slip,
            'from' => $this->from,
            'to' => $this->to
        ];

        // Paginating the Query
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS :procType, :storeId, :bankName, :slipNo, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }

    /**
     * Get the main data
     * @return mixed
     */
    public function allBankMIS()
    {
        // if ($this->selectedTid) {
        //     $params = [
        //         'procType' => $this->activeTab,
        //         'storeId' => $this->store,
        //         'bankName' => $this->bankName,
        //         'slipNo' => $this->slip,
        //         'from' => $this->from,
        //         'to' => $this->to,
        //         'selectedTid' => $this->selectedTid,
        //         'PageSize' => $this->perPage,
        //         'orderBy' => $this->orderBy
        //     ];
        //     return collect(DB::select(
        //         'EXEC PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS
        //         @procType = :procType,
        //         @storeId = :storeId,
        //         @bankName = :bankName,
        //         @slipNo = :slipNo,
        //         @from = :from,
        //         @to = :to,
        //         @selectedTid = :selectedTid,
        //         @PageSize = :PageSize,
        //         @OrderBy = :orderBy',
        //         $params
        //     ));
        // } else {}
        // Main Params to the query
        $params = [
            'procType' => $this->activeTab,
            'storeId' => $this->store,
            'bankName' => $this->bankName,
            'slipNo' => $this->slip,
            'from' => $this->from,
            'to' => $this->to
        ];

        // Paginating the Query
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS :procType, :storeId, :bankName, :slipNo, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }

    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {

        $bankMIS = $this->allBankMIS();
        // $this->stores = $this->stores();
        $totals = $this->getTotals();
        $this->card_banks = $this->banks('all-card-mis');
        $this->wallet_banks = $this->banks('all-wallet-mis');

        // main view
        return view('livewire.commercial-head.reports.bank-m-i-s', [
            'mis' => $bankMIS,
            'totals' => $totals
        ]);
    }

    public function searchStore(Request $request)
    {
        $searchTerm = $request->input('search');
        $params = [
            'procType' => $request->currentTab . '-stores',
            'storeId' => $this->store,
            'bankName' => $this->bankName,
            'slipNo' => $this->slip,
            'from' => $this->from,
            'to' => $this->to,
            'search' => $searchTerm ?? null,
            'PageSize' => $this->perPage,
            'orderBy' => $this->orderBy
        ];
        $stores = collect(DB::select(
            'EXEC PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS
                        @procType = :procType,
                        @storeId = :storeId,
                        @bankName = :bankName,
                        @slipNo = :slipNo,
                        @from = :from,
                        @to = :to,
                        @search = :search,
                        @PageSize = :PageSize,
                        @OrderBy = :orderBy',
            $params
        ));
        $formattedStores = $stores->map(function ($store) {
            return [
                'id' => $store->store,
                'text' => $store->store,
            ];
        });

        return response()->json([
            'results' => $formattedStores
        ]);
    }
    // public function searchTid(Request $request)
    // {
    //     $searchTerm = $request->input('search');

    //     $params = [
    //         'procType' => 'Card-TID',
    //         'storeId' => $this->store,
    //         'bankName' => $this->bankName,
    //         'slipNo' => $this->slip,
    //         'from' => $this->from,
    //         'to' => $this->to,
    //         'search' => $searchTerm ?? null,
    //         'PageSize' => $this->perPage,
    //         'orderBy' => $this->orderBy
    //     ];

    //     $searchedTid = DB::select(
    //         'EXEC PaymentMIS_PROC_SELECT_COMMERCIALHEAD_BankMIS_All_Bank_Reports_MIS
    //         @procType = :procType,
    //         @storeId = :storeId,
    //         @bankName = :bankName,
    //         @slipNo = :slipNo,
    //         @from = :from,
    //         @to = :to,
    //         @search = :search,
    //         @PageSize = :PageSize,
    //         @OrderBy = :orderBy',
    //         $params
    //     );

    //     $results = collect($searchedTid)->map(function ($item) {
    //         return [
    //             'id' => $item->tid,
    //             'text' => $item->tid
    //         ];
    //     });
    //     return response()->json(['results' => $results]);
    // }

}
