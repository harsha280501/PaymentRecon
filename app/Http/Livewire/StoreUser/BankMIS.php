<?php

namespace App\Http\Livewire\StoreUser;


use Livewire\Component;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\WithExportDate;

use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Traits\StreamExcelDownload;
use App\Traits\WithStoreFormatting;

use App\Interface\Excel\SpreadSheet;
use App\Interface\Excel\WithHeaders;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\UseExcelDataset;

class BankMIS extends Component implements UseExcelDataset, WithFormatting, WithHeaders {

    use HasInfinityScroll, WithExportDate, StreamExcelDownload, WithStoreFormatting, UseOrderBy, ParseMonths;



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





    public $export_file_name = 'Payment_MIS_Reports_Bank_MIS_Export';




    /**
     * Temp: Has Filters for the current Tab
     * @var array
     */
    public $implementedFilters = [
        'all-cash-mis',
        'all-card-mis',
        'all-wallet-mis',
        'all-upi-mis',
    ];




    public $sync_report_name = [
        'all-cash-mis' => 'Cash MIS',
        'all-card-mis' => 'Card MIS',
        'all-wallet-mis' => 'Wallet MIS',
        'all-upi-mis' => 'UPI_MIS'
    ];


    public $sync_file_name = [
        'all-cash-mis' => 'Cash_MIS',
        'all-card-mis' => 'Card_MIS',
        'all-wallet-mis' => 'Wallet_MIS',
        'all-upi-mis' => 'UPI_MIS'
    ];




    /**
     * Active Tab
     * @var string
     */
    public $activeTab = "hdfc";



    /**
     * Single Type
     * @var 
     */
    public $bankType;





    /**
     * Switch Tab 2 main
     * @return void
     */
    public function mount() {
        $this->switchTab("all-cash-mis");
        $this->_months = $this->_months()->toArray();
    }





    /**
     * Switching between tabs
     * @param mixed $tab
     * @return void
     */
    public function switchTab($tab) {

        $this->activeTab = $tab;
        // resetting all varaibles
        $this->resetExcept('activeTab');
        $this->emit('resetAll');
    }




    /**
     * Render main views
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        // default data
        $bankMIS = $this->allBankMIS();
        $cash_banks = $this->banks('all-cash-mis');
        $card_banks = $this->banks('all-card-mis');
        $upi_banks = $this->banks('all-upi-mis');
        $wallet_banks = $this->banks('all-wallet-mis');

        // main view    
        return view('livewire.store-user.bank-m-i-s', [
            'mis' => $bankMIS,
            'cash_banks' => $cash_banks,
            'card_banks' => $card_banks,
            'wallet_banks' => $wallet_banks,
            'upi_banks' => $upi_banks
        ]);
    }




    /**
     * Date filter
     * @param mixed $obj
     * @return void
     */
    public function filterDate($obj) {
        $this->filtering = true;
        $this->from = $obj['start'];
        $this->to = $obj['end'];
    }


    public function formatter(SpreadSheet $worksheet, $dataset): void {

        $worksheet->setStartFrom(7);
        // $worksheet->setFilename($this->_useToday($this->export_file_name, now()->format('d-m-Y')));
        $worksheet->setFilename($this->_useToday($this->export_file_name . '_' . $this->sync_file_name[$this->activeTab], now()->format('d-m-Y')));


        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 2, 'Report Name: ' . $this->sync_report_name[$this->activeTab]);

        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 1, 'Store ID: ' . auth()->user()->main()['Store ID']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 2, 'Retek Code: ' . auth()->user()->main()['RETEK Code']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 3, 'Store Type: ' . auth()->user()->main()['StoreTypeasperBrand']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('A' . 4, 'Brand: ' . auth()->user()->main()['Brand Desc']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('D' . 1, 'Region: ' . auth()->user()->main()['Region']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('D' . 2, 'Location: ' . auth()->user()->main()['Location']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('D' . 3, 'City: ' . auth()->user()->main()['City']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('D' . 4, 'State: ' . auth()->user()->main()['State']);
        $worksheet->spreadsheet->getActiveSheet()->setCellValue('H' . 1, 'Franchisee Name: ' . auth()->user()->main()['franchiseeName']);
    }
    /**
     * Required to Download Excel files
     * @param string $value
     * @return \Illuminate\Support\Collection|bool
     */
    public function download(string $value = ''): Collection|bool {
        $params = [
            'procType' => $this->activeTab . '-export',
            'bankName' => $this->bankName,
            'daterange' => $value,
            'from' => $this->from,
            'to' => $this->to,
            'storeId' => auth()->user()->storeUID
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_BankMIS_All_Bank_Reports_MIS :procType, :bankName, :daterange, :from, :to, :storeId',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }




    public function headers(): array {
        if ($this->activeTab === "all-wallet-mis") {
            return [
                'Sales Date',
                'Deposit Date',
                'Collection Bank',
                'Terminal ID',
                'Mid',
                'Deposit Amount',
            ];
        }


        if ($this->activeTab === 'all-card-mis') {
            return [
                'Sales Date',
                'Deposit Date',
                'Collection Bank',
                'Merchant Code',
                'Terminal Number',
                'Deposit Amount'
            ];
        }

        if ($this->activeTab === 'all-upi-mis') {
            return [
                'Sales Date',
                'Deposit Date',
                'Collection Bank',
                'Merchant Code',
                'Terminal Number',
                'Deposit Amount'
            ];
        }

        return [
            'Sales Date',
            'Deposit Date',
            'Collection Bank',
            'Pick Up Location',
            'Slip Number',
            'Deposit Amount'
        ];
    }





    public function banks(string $tab = 'all-cash-mis') {
        // Main Params to the query
        $params = [
            'procType' => $tab . '-banks',
            'bankName' => null,
            'daterange' => '',
            'from' => null,
            'to' => null,
            'storeId' => auth()->user()->storeUID
        ];

        // returns data
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_BankMIS_All_Bank_Reports_MIS :procType, :bankName, :daterange, :from, :to, :storeId',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }



    /**
     * Get the main data
     * @return mixed
     */
    public function allBankMIS() {

        // Main Params to the query
        $params = [
            'procType' => $this->activeTab,
            'bankName' => $this->bankName,
            'daterange' => '',
            'from' => $this->from,
            'to' => $this->to,
            'storeId' => auth()->user()->storeUID
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_STOREUSER_BankMIS_All_Bank_Reports_MIS :procType, :bankName, :daterange, :from, :to, :storeId',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }


    /**
     * Updating the bank name triggers the back button
     * @param mixed $item
     * @return void
     */
    public function updated($item) {
        if ($item === 'bankName') {
            $this->filtering = true;
        }
    }


    /**
     * Reset all the filters
     * @return void
     */
    public function back() {
        $this->filtering = false;
        $this->resetExcept('activeTab');
        $this->emit('resetall');
        $this->emit('resetAll');
    }
}
