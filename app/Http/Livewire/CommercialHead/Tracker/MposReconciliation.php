<?php

namespace App\Http\Livewire\CommercialHead\Tracker;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Models\MFLInwardStoreIDMissingTransactions;
use App\Models\Store;
use App\Traits\HasTabs;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\StreamSimpleCSV;
use App\Traits\UseDefaults;
use App\Traits\UseHelpers;
use App\Traits\UseOrderBy;
use App\Traits\UseSyncFilters;
use App\Traits\WithExportDate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\WithFileUploads;

class MposReconciliation extends Component implements UseExcelDataset, WithHeaders
{

    use HasInfinityScroll, HasTabs, WithExportDate, ParseMonths, UseSyncFilters, UseDefaults, WithFileUploads, UseHelpers;





    public $banks = [];






    /**
     * Undocumented variable
     *
     * @var string
     */
    public $orderBy = 'mposDate:desc';












    /**
     * Status Order by
     * @var string
     */
    public $status = '';












    /**
     * Filtering
     * @var string
     */
    public $bank = '';










    /**
     * Display error message
     * @var string
     */
    public $message = '';










    /**
     * Show bankdrop id and amount
     *
     * @var boolean
     */
    public $showBankDrop = false;










    /**
     * Match status filter
     * @var string
     */
    public $matchStatus = '';










    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Tracker_Cash_Reconciliation';







    /**
     * Store ids for update resourcess
     * @var array
     */
    public $storeIDs = [];







    /**
     * File - Resource
     * @var
     */
    public $importFile = null;









    /**
     * File updload rules
     * @var array
     */
    public $fileRules = [
        "Unique Id" => "required",
        "Sales Date" => "required",
        "Deposit Date" => "nullable",
        "Store ID" => "required|regex:/^[0-9]{4}$/",
        "Retek Code" => "required|regex:/^[0-9]{5}$/",
        "Brand" => "nullable",
        "ColBank" => "nullable",
        "Status" => "nullable",
        "Tender Amount" => "nullable",
        "Deposit Amount" => "nullable",
        "Store Response Entry" => "nullable",
        "Difference [Tender - Deposit - Store Response]" => "nullable",
        "New Sale Date" => "nullable",
        "New Store ID" => "nullable",
        "New Retek Code" => "nullable",
        "New Tender[ColBank]" => "nullable",
    ];








    /**
     * Init
     * @return void
     */
    public function mount()
    {
        $this->reset();
        $this->_months = $this->_months()->toArray();
        $this->banks = $this->getData('cash-banks');
        // $this->storeIDs = $this->filtersSyncDataset('stores_retekCode');
    }

    public function populateStoreIDs()
    {
        $this->storeIDs = $this->filtersSyncDataset('stores_retekCode');
    }







    /**
     * Order by multiple columns
     *
     * @param [type] $col
     * @return void
     */
    public function orderBy($col)
    {
        // assigning the order
        $this->orderBy = $col . ':' . ($this->replaceWord($this->orderBy, $col) == 'asc' ? 'desc' : 'asc');
    }






    public function replaceWord($string, $word)
    {
        // Escape special characters in the word to avoid regex errors
        $escapedWord = preg_quote($word, '/');

        // Use regex to replace the word with an empty string
        $newString = preg_replace('/\b' . $escapedWord . '\b/', '', $string);

        return substr($newString, 1);
    }







    /**
     * Get The Sale Amount
     * @param array $dataset
     * @return bool|string
     */
    public function getSalesAmount(array $dataset)
    {

        $_reco = DB::table('MFL_Outward_MPOS2CashTenderBankDropCashMISReco')
            ->where('storeID', '=', $dataset['storeID'])
            ->where('mposDate', '=', Carbon::parse($dataset['salesDate'])->format('Y-m-d'))
            ->where(function ($query) use ($dataset) {
                $query->where('colBank', '=', $dataset['colBank'])
                    ->orWhere('colBank', '=', $dataset['colBank']);
            })->first(['tenderAmount', 'storeID']);

        $_brand = Store::where('Store ID', '=', $_reco?->storeID)->first()?->{'Brand Desc'};

        return json_encode(['tenderAmount' => !$_reco?->tenderAmount ? '0.00' : $_reco?->tenderAmount, 'brand' => !$_brand ? '-' : $_brand]);
    }






    /**
     * Move item to unallocated
     * @param array $dataset
     * @return bool
     */
    public function moveToUnallocated(array $dataset)
    {
        try {
            DB::beginTransaction();

            foreach ($dataset as $data) {

                # get the item
                $_reco = \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISReco::where('CashTenderBkDrpUID', '=', $data)->first();


                if ($_reco->adjAmount != null) {
                    $this->emit('unallocated:failed', ['message' => 'Cannot move item to Unallocated - Adjustment Amount is not empty']);
                    return false;

                }


                # insert into unallocated
                MFLInwardStoreIDMissingTransactions::insert([
                    "UID" => $_reco->CashTenderBkDrpUID,
                    "storeID" => $_reco->storeID,
                    "retekCode" => $_reco->retekCode,
                    "colBank" => $_reco->collBank,
                    "depositDate" => $_reco->depositDate,
                    "depositAmount" => $_reco->depositAmount,
                    "storeUpdateRemarks" => 'Moved to Unallocated by Commercial head',
                    "type" => 'mismatch-cash',
                    "adjAmount" => $_reco->adjAmount
                ]);


                # update store response entry
                $_reco->update([
                    'adjAmount' => -1 * $_reco->depositAmount,
                ]);
            }

            DB::commit();
            $this->emit('unallocated:success', ['message' => 'Successful!']);
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('unallocated:failed', ['message' => $th->getMessage()]);
            return false;
        }

    }













    /**
     * importing the file
     * @return bool
     */
    public function updatedImportFile()
    {

        $this->message = 'File : Loading ...';
        // save the file and validate
        $filename = $this->importFile->store('card-reconciliation');
        $file_path = storage_path() . '/app/public/' . $filename;

        $sheet = $this->reader($file_path);
        $this->message = 'File: Validating ...';

        $index = 0;

        try {

            DB::beginTransaction();

            foreach ($sheet as $item) {

                $_withHeaders = [
                    "Unique Id" => $item['A'],
                    "Sales Date" => $item['B'],
                    "Deposit Date" => $item['C'],
                    "Store ID" => $item['D'],
                    "Retek Code" => $item['E'],
                    "Brand" => $item['F'],
                    "ColBank" => $item['G'],
                    "Status" => $item['H'],
                    "Card Sales" => $item['I'],
                    "Deposit Amount" => $item['J'],
                    "Store Response Entry" => $item['K'],
                    "Difference Difference [Tender - Deposit - Store Response]" => $item['L'],
                    "New Sale Date" => $item['N'],
                    "New Store ID" => $item['O'],
                    "New Retek Code" => $item['P'],
                    "New Tender[ColBank]" => $item['Q'],
                ];


                if ($index <= 7) {
                    $index++;
                    continue;
                }


                if (!$this->validateArray($_withHeaders, $this->fileRules, $index)) {
                    return false;
                }


                if (!$_withHeaders["New Sale Date"] && !$_withHeaders["New Store ID"] && !$_withHeaders["New Retek Code"] && !$_withHeaders["New Tender[ColBank]"]) {
                    $index++;
                    continue;
                }

                $status = $this->uploadExcelData([
                    "storeID" => $_withHeaders["New Store ID"],
                    "retekCode" => $_withHeaders["New Retek Code"],
                    "colBank" => $_withHeaders["New Tender[ColBank]"],
                    "salesDate" => $_withHeaders["New Sale Date"],
                    "reconItem" => $_withHeaders["Unique Id"]
                ]);



                if (!$status) {
                    DB::rollback();
                    $this->message = 'File: Server error ... ' . 'Something went Wrong' . '- The Data updated by using this file will be reverted back to its original state :)';

                    return false;
                }

                $index++;
            }


            DB::commit();
            $this->emit('file:imported');
            return true;

        } catch (\Throwable $th) {
            DB::rollback();
            $this->message = 'File: Server error ... ' . $th->getMessage() . '- The Data updated by using this file will be reverted back to its original state :)';
            return false;
        }
    }




    public function uploadExcelData(array $dataset)
    {
        try {

            $_reco = \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISReco::where('CashTenderBkDrpUID', '=', $dataset['reconItem'])->first();


            if (!$_reco || !$_reco->depositAmount) {
                return true;
            }

            $calc = $_reco->tenderAmount - ($_reco->depositAmount - $_reco->adjAmount);

            # get the approval process records
            $records = \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISRecoApproval::where('CashTenderBkDrpUID', '=', $dataset['reconItem'])
                ->where('approveStatus', 'Pending');


            $records->update([
                'approveStatus' => 'Rejected',
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'modifiedDate' => now(),
                'cheadRemarks' => 'Uploaded by Commercial head'
            ]);


            # update the item as
            $_reco->update([
                'adjAmount' => -1 * $_reco->depositAmount,
                'cashMISStatus' => ($calc <= -100 && $calc >= 100) ? 'Matched' : 'Not Matched',
                'reconStatus' => ($calc <= -100 && $calc >= 100) ? 'Compeleted' : ($_reco->reconStatus == 'Pending for Approval' ? 'Rejected' : 'Pending'),
                'bankCashDifference' => $calc,
                'storeUpdateRemarks' => 'Updated Store ID - ' . $_reco->storeUID . ' to ' . $dataset['storeID'] .
                    ' and Sales Date - ' . $_reco->transactionDate . ' to ' . $dataset['salesDate'] .
                    ' and Collection Bank - ' . $_reco->collectionBank . ' to ' . $dataset['colBank']
            ]);


            # insert new item to the recon
            \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISReco::insert([
                'mposDate' => Carbon::parse($dataset['salesDate'])->format('Y-m-d'),
                'depositDate' => $_reco->depositDate,
                'colBank' => $dataset['colBank'],
                'adjAmount' => $_reco->depositAmount,
                'storeID' => $dataset['storeID'],
                'retekCode' => $dataset['retekCode'],
                'storeUpdateRemarks' => 'Updated from Store ID - ' . $_reco->storeUID .
                    ' and Sales Date - ' . $_reco->transactionDate . ' to ' . $dataset['salesDate'] .
                    ' and Collection Bank - ' . $_reco->collectionBank . ' to ' . $dataset['colBank']
            ]);

            # Update the Reconciliation Data
            DB::statement('sp_UpdateCashReconcilation :storeID, :saleDate, :depositDate, :bank, :recoID', [
                'storeID' => $dataset['storeID'],
                'saleDate' => $dataset['salesDate'],
                'depositDate' => $_reco->depositDt,
                'bank' => $dataset['colBank'],
                'recoID' => $dataset['reconItem']
            ]);

        } catch (\Throwable $th) {

            dd($th->getMessage());
            return false;
        }

        return true;
    }







    /**
     * Upate a recon item
     * @param array $dataset
     * @return bool
     */
    public function recon(array $dataset)
    {

        try {
            DB::beginTransaction();

            $_reco = \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISReco::where('CashTenderBkDrpUID', '=', $dataset['reconItem'])->first();


            if (!$_reco || !$_reco->depositAmount) {
                return true;
            }

            $calc = $_reco->tenderAmount - ($_reco->depositAmount - $_reco->adjAmount);

            # get the approval process records
            $records = \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISRecoApproval::where('CashTenderBkDrpUID', '=', $dataset['reconItem'])
                ->where('approveStatus', 'Pending');


            $records->update([
                'approveStatus' => 'Rejected',
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'modifiedDate' => now(),
                'cheadRemarks' => 'Uploaded by Commercial head'
            ]);


            # update the item as
            $_reco->update([
                'adjAmount' => -1 * $_reco->depositAmount,
                'cashMISStatus' => ($calc <= -100 && $calc >= 100) ? 'Matched' : 'Not Matched',
                'reconStatus' => ($calc <= -100 && $calc >= 100) ? 'Compeleted' : ($_reco->reconStatus == 'Pending for Approval' ? 'Rejected' : 'Pending'),
                'bankCashDifference' => $calc,
                'storeUpdateRemarks' => 'Updated Store ID - ' . $_reco->storeUID . ' to ' . $dataset['storeID'] .
                    ' and Sales Date - ' . $_reco->transactionDate . ' to ' . $dataset['salesDate'] .
                    ' and Collection Bank - ' . $_reco->collectionBank . ' to ' . $dataset['colBank']
            ]);

            # insert new item to the recon
            \App\Models\Process\MPOS\MPOSCashTenderBankDropCashMISReco::insert([
                'mposDate' => Carbon::parse($dataset['salesDate'])->format('Y-m-d'),
                'depositDate' => $_reco->depositDate,
                'colBank' => $dataset['colBank'],
                'adjAmount' => $_reco->depositAmount,
                'storeID' => $dataset['storeID'],
                'retekCode' => $dataset['retekCode'],
                'storeUpdateRemarks' => 'Updated from Store ID - ' . $_reco->storeUID .
                    ' and Sales Date - ' . $_reco->transactionDate . ' to ' . $dataset['salesDate'] .
                    ' and Collection Bank - ' . $_reco->collectionBank . ' to ' . $dataset['colBank']
            ]);

            DB::statement('sp_UpdateCashReconcilation :storeID, :saleDate, :depositDate, :bank, :recoID', [
                'storeID' => $dataset['storeID'],
                'saleDate' => $dataset['salesDate'],
                'depositDate' => $_reco->depositDt,
                'bank' => $dataset['colBank'],
                'recoID' => $dataset['reconItem']
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            $this->emit('recon:failed', ['message' => $th->getMessage()]);
            return false;
        }


        $this->emit('recon:updated');
        return true;
    }







    public function importExcelExport()
    {

        $headers = $this->headers('importable');
        $data = $this->getData('importable-withoutBankdrop-export');

        $filePath = public_path() . '/Payment_MIS_COMMERCIAL_HEAD_Tracker_Cash_Rectfication_Entry.csv';
        $file = fopen($filePath, 'w'); # open the filePath - create if not exists

        fputcsv($file, ['Correction Entry']);

        if (!$this->showBankDrop) {
            fputcsv($file, ['Existing MIS Data', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Rectification Entry', '', '', '']);
        }

        fputcsv($file, $headers); # adding headers to the excel

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
                'Content-Disposition' => 'attachment;filename="Payment_MIS_COMMERCIAL_HEAD_Tracker_Cash_Rectfication_Entry.csv"',
            ]
        );
    }










    /**
     * Headers for excel export
     * @return array
     */
    public function headers(string $type = ''): array
    {

        if ($type == 'importable') {
            return [
                "UID",
                "Sales Date",
                "Deposit Date",
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status",
                "Deposit SlipNo",
                "Tender Amount",
                "Deposit Amount",
                "Store Response Entry",
                "Difference [Tender - Deposit - Store Response]",
                '',
                "New Sale Date",
                "New Store ID",
                "New Retek Code",
                "New Tender [ColBank]"
            ];
        }

        if (!$this->showBankDrop) {
            return [
                "Sales Date",
                "Deposit Date",
                "Store ID",
                "Retek Code",
                "Col Bank",
                "Status",
                "Deposit SlipNo",
                "Tender Amount",
                "Deposit Amount",
                "Store Response Entry",
                "Difference [Tender - Deposit - Store Response]"
            ];
        }

        return [
            "Sales Date",
            "Deposit Date",
            "Store ID",
            "Retek Code",
            "Col Bank",
            "Status",
            "Bank Drop ID",
            "BankDrop Amount",
            "Deposit SlipNo",
            "Tender Amount",
            "Deposit Amount",
            "Store Response Entry",
            "Difference [Tender - Deposit - Store Response]"
        ];
    }





    /**
     * Contents for the header of the excel file
     * @param mixed $file
     * @return bool
     */
    public function content($file)
    {
        $_totals = $this->getData('get_totals');

        fputcsv($file, ['Total Count: ', $_totals[0]->TotalCount]);
        fputcsv($file, ['Matched Count: ', $_totals[0]->MatchedCount]);
        fputcsv($file, ['Not Matched Count: ', $_totals[0]->NotMatchedCount]);
        fputcsv($file, ['']);

        // IJKLM
        if ($this->showBankDrop) {
            fputcsv($file, ['', '', '', '', '', '', '', '', 'Total', $_totals[0]->sales_totalF, $_totals[0]->collection_totalF, $_totals[0]->adjustment_totalF, $_totals[0]->difference_totalF]);
        }
        if (!$this->showBankDrop) {
            fputcsv($file, ['', '', '', '', '', '', 'Total', $_totals[0]->sales_totalF, $_totals[0]->collection_totalF, $_totals[0]->adjustment_totalF, $_totals[0]->difference_totalF]);
        }

        return false;
    }









    /**
     * Filters
     * @return void
     */
    public function filters()
    {
        $params = [
            'procType' => 'cash-banks',
            'store' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->status,
            'bank' => $this->bank,
            'timeline' => '',
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_Mpos_Reconciliation2 :procType, :store, :brand, :location, :status,:bank,:timeline, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }









    /**
     * Sync filters
     * @param string $type
     * @return Collection|array
     */
    public function filtersSyncDataset(string $type): Collection|array
    {
        $params = [
            "procType" => $type,
            "store" => $this->_store,
            "brand" => $this->_brand,
            "location" => $this->_location
        ];

        return DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_Mpos_Reconciliation2_Filters :procType, :store, :brand, :location',
            $params
        );
    }

    public function searchBrands($search)
    {
        $params = [
            "procType" => '_brands',
            "store" => $this->_store,
            "brand" => $this->_brand,
            "location" => $this->_location,
            "search" => $search
        ];
        $brands = DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_Mpos_Reconciliation2_Filters :procType, :store, :brand, :location, :search',
            $params
        );
        return response()->json($brands);
    }

    public function searchStores($search)
    {
        $params = [
            "procType" => '_stores',
            "store" => $this->_store,
            "brand" => $this->_brand,
            "location" => $this->_location,
            "search" => $search
        ];
        $stores = DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_Mpos_Reconciliation2_Filters :procType, :store, :brand, :location, :search',
            $params
        );
        return response()->json($stores);
    }

    public function searchLocations($search)
    {
        $params = [
            "procType" => '_locations',
            "store" => $this->_store,
            "brand" => $this->_brand,
            "location" => $this->_location,
            "search" => $search
        ];
        $locations = DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_Mpos_Reconciliation2_Filters :procType, :store, :brand, :location, :search',
            $params
        );
        return response()->json($locations);
    }


    /**
     * Download dataset for excel
     * @param string $value
     * @return Collection|boolean
     */
    public function download(string $value = ''): Collection|bool
    {

        $params = [
            'procType' => $this->showBankDrop
                ? 'withBankdrop-export'
                : 'withoutBankdrop-export',
            'store' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->matchStatus,
            'bank' => $this->bank,
            'timeline' => $value,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_Mpos_Reconciliation2 :procType, :store, :brand , :location, :status,:bank, :timeline, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }







    /**
     * Data source
     * @return mixed
     */
    public function getData(string $type)
    {

        $params = [
            'procType' => $type,
            'store' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->matchStatus,
            'bank' => $this->bank,
            'timeline' => '',
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];


        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_Mpos_Reconciliation2 :procType, :store, :brand, :location, :status,:bank, :timeline, :from, :to',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }









    /**
     * Render the view
     * @return View
     */
    public function render(): View
    {
        return view('livewire.commercial-head.tracker.mpos-reconciliation', [
            'cashRecons' => $this->getData('main'),
            '_totals' => $this->getData('get_totals'),
            'selectionHas' => $this->getData('main')->pluck('CashTenderBkDrpUID'),
        ]);
    }
}
