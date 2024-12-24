<?php

namespace App\Http\Livewire\CommercialHead\Tracker;


use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithHeaders;
use App\Models\MFLInwardStoreIDMissingTransactions;
use App\Models\Process\SAP\CardReconApproval;
use App\Traits\HasTabs;
use App\Traits\UseSyncFilters;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\UseDefaults;
use App\Traits\UseHelpers;
use App\Traits\UseOrderBy;
use App\Traits\WithExportDate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;


class UpiReconciliation extends Component implements UseExcelDataset, WithHeaders {


    use HasInfinityScroll, HasTabs, WithExportDate, ParseMonths, UseOrderBy, UseSyncFilters, UseDefaults, WithFileUploads, UseHelpers;



    /**
     * Bank filter
     * @var string
     */
    public $bank = '';







    /**
     * Status filter
     * @var string
     */
    public $status = '';








    /**
     * Display error message
     * @var string
     */
    public $message = '';







    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Tracker_UPI_Reconciliation';







    /**
     * Filters for Wallet
     * @var array
     */
    public $banks = [];






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
        "Status" => "required",
        "UPI Sales" => "nullable",
        "Deposit Amount" => "nullable",
        "Store Response Entry" => "nullable",
        "Difference [Sales - Deposit - Store Response]" => "nullable",
        "New Sale Date" => "nullable",
        "New Store ID" => "nullable",
        "New Retek Code" => "nullable",
        "New Tender[ColBank]" => "nullable",
    ];








    /**
     * Initializ the component
     * @return void
     */
    public function mount() {
        $this->reset();
        $this->_months = $this->_months()->toArray();
        $this->banks = $this->getData('card-banks');
        $this->storeIDs = $this->filtersSyncDataset('stores_retekCode');
    }






    public function getSalesAmount(array $dataset) {

        $_reco = DB::table('MFL_Outward_CardSalesReco')
            ->where('storeID', '=', $dataset['storeID'])
            ->where('transactionDate', '=', Carbon::parse($dataset['salesDate'])->format('Y-m-d'))
            ->where(function ($query) use ($dataset) {
                $query->where('collectionBank', '=', $dataset['colBank'])
                    ->orWhere('salesBank', '=', $dataset['colBank']);
            })->first(['brand', DB::raw('cast(cardSale AS nvarchar(max)) as cardSale')]);

        return json_encode($_reco);
    }



    /**
     * Move item to unallocated
     * @param array $dataset
     * @return bool
     */
    public function moveToUnallocated(array $dataset) {
        // dd($dataset);

        try {
            DB::beginTransaction();

            foreach ($dataset as $data) {

                # get the item
                $_reco = \App\Models\Process\SAP\CardRecon::where('cardSalesRecoUID', '=', $data)->first();


                if ($_reco->adjAmount != null) {
                    $this->emit('unallocated:failed', ['message' => 'Cannot move item to Unallocated - Adjustment Amount is not empty']);
                    return false;

                }

                # insert into unallocated
                MFLInwardStoreIDMissingTransactions::insert([
                    "UID" => $_reco->UID,
                    "storeID" => $_reco->storeID,
                    "retekCode" => $_reco->retekCode,
                    "colBank" => $_reco->collectionBank,
                    "depositDate" => $_reco->depositDt,
                    "depositAmount" => $_reco->depositAmount,
                    "storeUpdateRemarks" => 'Moved to Unallocated by Commercial head',
                    "type" => 'mismatch-upi',
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
    public function updatedImportFile() {

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
                    "UPI Sales" => $item['I'],
                    "Deposit Amount" => $item['J'],
                    "Store Response Entry" => $item['K'],
                    "Difference [Sales - Deposit - Store Response]" => $item['L'],
                    "New Sale Date" => $item['N'],
                    "New Store ID" => $item['O'],
                    "New Retek Code" => $item['P'],
                    "New Tender[ColBank]" => $item['Q'],
                ];


                if ($index <= 2) {
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
                    $this->message = "File: Server error ... Something went Wrong- The Data updated by using this file will be reverted back to its original state :)";
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



    public function uploadExcelData(array $dataset) {
        try {
            // Log the start of the process
            Log::channel('upi-recon')->debug('Starting Excel upload recon for reconItem: ' . $dataset['reconItem'], $dataset);

            $_reco = \App\Models\Process\SAP\CardRecon::where('cardSalesRecoUID', '=', $dataset['reconItem'])->first();

            // Log if no record or deposit amount found
            if (!$_reco || !$_reco->depositAmount) {
                Log::channel('upi-recon')->warning('No reconciliation item found or depositAmount is missing.', ['reconItem' => $dataset['reconItem']]);
                return true;
            }

            $calc = ($_reco->cardSale - ($_reco->depositAmount - $_reco->adjAmount));

            // Log the calculated value
            Log::channel('upi-recon')->debug('Calculated difference (cardSale - (depositAmount - adjAmount)): ' . $calc);

            # get the approval process records
            $records = CardReconApproval::where('cardSalesRecoUID', '=', $dataset['reconItem'])
                ->where('approveStatus', 'Pending');

            // Log if no approval records are found
            if ($records->count() == 0) {
                Log::channel('upi-recon')->warning('No pending approval records found for reconItem: ' . $dataset['reconItem']);
            } else {
                Log::channel('upi-recon')->debug('Found ' . $records->count() . ' pending approval records for reconItem: ' . $dataset['reconItem']);
            }

            $records->update([
                'approveStatus' => 'Rejected',
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'modifiedDate' => now(),
                'cheadRemarks' => 'Uploaded by Commercial head'
            ]);

            // Log the rejection of approval records
            Log::channel('upi-recon')->debug('Approval records updated to Rejected for reconItem: ' . $dataset['reconItem'], [
                'updatedRecords' => $records->get()->toArray()
            ]);

            # update the item
            $_reco->update([
                'adjAmount' => -1 * $_reco->depositAmount,
                'status' => ($calc <= -100 && $calc >= 100) ? 'Matched' : 'Not Matched',
                'reconStatus' => ($calc <= -100 && $calc >= 100) ? 'Completed' : ($_reco->reconStatus == 'Pending for Approval' ? 'Rejected' : 'Pending'),
                'diffSaleDeposit' => $calc,
                'storeUpdateRemarks' => 'Updated Store ID - ' . $_reco->storeUID . ' to ' . $dataset['storeID'] .
                    ' and Sales Date - ' . $_reco->transactionDate . ' to ' . $dataset['salesDate'] .
                    ' and Collection Bank - ' . $_reco->collectionBank . ' to ' . $dataset['colBank']
            ]);

            // Log the updated reconciliation record
            Log::channel('upi-recon')->debug('Reconciliation item updated.', [
                'reconItem' => $dataset['reconItem'],
                'newData' => $_reco->getChanges()
            ]);

            # insert new item
            $newItem = \App\Models\Process\SAP\CardRecon::create([
                'transactionDate' => Carbon::parse($dataset['salesDate'])->format('Y-m-d'),
                'depositDt' => $_reco->depositDt,
                'collectionBank' => $dataset['colBank'],
                'salesBank' => $dataset['colBank'],
                'adjAmount' => $_reco->depositAmount,
                'storeID' => $dataset['storeID'],
                'retekCode' => $dataset['retekCode'],
                'storeUpdateRemarks' => 'Updated from Store ID - ' . $_reco->storeUID .
                    ' and Sales Date - ' . $_reco->transactionDate . ' to ' . $dataset['salesDate'] .
                    ' and Collection Bank - ' . $_reco->collectionBank . ' to ' . $dataset['colBank']
            ]);

            // Log the insertion of the new item
            Log::channel('upi-recon')->debug('Inserted new reconciliation item for reconItem: ' . $dataset['reconItem'], [
                'insertedItem' => $newItem
            ]);

            # Update the Reconciliation Data
            DB::statement('sp_UpdateCardReconcilation :storeID, :saleDate, :depositDate, :bank, :recoID', [
                'storeID' => $dataset['storeID'],
                'saleDate' => $dataset['salesDate'],
                'depositDate' => $_reco->depositDt,
                'bank' => $dataset['colBank'],
                'recoID' => $dataset['reconItem']
            ]);

            // Log the completion of the update
            Log::channel('upi-recon')->debug('Card reconciliation data updated successfully.', [
                'reconItem' => $dataset['reconItem'],
                'storeID' => $dataset['storeID'],
                'salesDate' => $dataset['salesDate'],
                'depositDate' => $_reco->depositDt,
                'bank' => $dataset['colBank']
            ]);

        } catch (\Throwable $th) {
            // Log the error message with detailed context
            Log::channel('upi-recon')->error('Error during Excel upload recon: ' . $th->getMessage(), [
                'reconItem' => $dataset['reconItem'],
                'exception' => $th
            ]);

            // Dump the error message for immediate debugging if needed
            dd($th->getMessage());
            return false;
        }

        return true;
    }




    /**
     * Update a recon item
     * @param array $dataset
     * @return bool
     */
    public function recon(array $dataset) {
        try {
            DB::beginTransaction();

            // Log the start of the process
            Log::channel('upi-recon')->debug('Starting recon update for reconItem: ' . $dataset['reconItem'], $dataset);

            $_reco = \App\Models\Process\SAP\CardRecon::where('cardSalesRecoUID', '=', $dataset['reconItem'])->first();

            // Log if no record is found
            if (!$_reco) {
                Log::channel('upi-recon')->warning('No reconciliation item found for reconItem: ' . $dataset['reconItem']);
                return false;
            }

            $calc = $_reco->cardSale - ($_reco->depositAmount - $_reco->adjAmount);

            // Log the calculated value
            Log::channel('upi-recon')->debug('Calculated difference (cardSale - (depositAmount - adjAmount)): ' . $calc);

            // Get the approval process records
            $records = CardReconApproval::where('cardSalesRecoUID', '=', $dataset['reconItem'])
                ->where('approveStatus', 'Pending');

            // Log the count of approval records found
            if ($records->count() == 0) {
                Log::channel('upi-recon')->warning('No pending approval records found for reconItem: ' . $dataset['reconItem']);
            } else {
                Log::channel('upi-recon')->debug('Found ' . $records->count() . ' pending approval records for reconItem: ' . $dataset['reconItem']);
            }

            // Update the approval records
            $records->update([
                'approveStatus' => 'Rejected',
                'approvedBy' => auth()->user()->userUID,
                'approvalDate' => now(),
                'modifiedDate' => now(),
                'cheadRemarks' => 'Uploaded by Commercial head'
            ]);

            // Log the rejection of approval records
            Log::channel('upi-recon')->debug('Approval records updated to Rejected for reconItem: ' . $dataset['reconItem'], [
                'updatedRecords' => $records->get()->toArray()
            ]);

            // Update the item
            $_reco->update([
                'adjAmount' => -1 * $_reco->depositAmount,
                'status' => ($calc <= -100 && $calc >= 100) ? 'Matched' : 'Not Matched',
                'reconStatus' => ($calc <= -100 && $calc >= 100) ? 'Completed' : ($_reco->reconStatus == 'Pending for Approval' ? 'Rejected' : 'Pending'),
                'diffSaleDeposit' => $calc,
                'storeUpdateRemarks' => 'Updated Store ID - ' . $_reco->storeUID . ' to ' . $dataset['storeID'] .
                    ' and Sales Date - ' . $_reco->transactionDate . ' to ' . $dataset['salesDate'] .
                    ' and Collection Bank - ' . $_reco->collectionBank . ' to ' . $dataset['colBank']
            ]);

            // Log the updated reconciliation record
            Log::channel('upi-recon')->debug('Reconciliation item updated.', [
                'reconItem' => $dataset['reconItem'],
                'newData' => $_reco->getChanges()
            ]);

            // Insert new item to the recon
            \App\Models\Process\SAP\CardRecon::insert([
                'transactionDate' => Carbon::parse($dataset['salesDate'])->format('Y-m-d'),
                'depositDt' => $_reco->depositDt,
                'collectionBank' => $dataset['colBank'],
                'salesBank' => $dataset['colBank'],
                'adjAmount' => $_reco->depositAmount,
                'storeID' => $dataset['storeID'],
                'retekCode' => $dataset['retekCode'],
                'storeUpdateRemarks' => 'Updated from Store ID - ' . $_reco->storeUID .
                    ' and Sales Date - ' . $_reco->transactionDate . ' to ' . $dataset['salesDate'] .
                    ' and Collection Bank - ' . $_reco->collectionBank . ' to ' . $dataset['colBank']
            ]);

            // Log the insertion of the new item
            Log::channel('upi-recon')->debug('Inserted new reconciliation item for reconItem: ' . $dataset['reconItem'], [
                'dataset' => $dataset
            ]);

            // Update the Reconciliation Data
            DB::statement('sp_UpdateCardReconcilation :storeID, :saleDate, :depositDate, :bank, :recoID', [
                'storeID' => $dataset['storeID'],
                'saleDate' => $dataset['salesDate'],
                'depositDate' => $_reco->depositDt,
                'bank' => $dataset['colBank'],
                'recoID' => $dataset['reconItem']
            ]);

            // Log the completion of the update
            Log::channel('upi-recon')->debug('Card reconciliation data updated successfully for reconItem: ' . $dataset['reconItem'], [
                'storeID' => $dataset['storeID'],
                'salesDate' => $dataset['salesDate'],
                'depositDate' => $_reco->depositDt,
                'bank' => $dataset['colBank']
            ]);

        } catch (\Throwable $th) {
            // Rollback the transaction and log the error
            DB::rollBack();
            Log::channel('upi-recon')->error('Error during recon update: ' . $th->getMessage(), [
                'reconItem' => $dataset['reconItem'],
                'exception' => $th
            ]);

            $this->emit('recon:failed', ['message' => $th->getMessage()]);
            return false;
        }

        DB::commit();
        $this->emit('recon:updated');
        return true;
    }






    public function importExcelExport() {

        $headers = $this->headers('importable');
        $data = $this->getData('importable-upi-export');

        $filePath = public_path() . '/Payment_MIS_COMMERCIAL_HEAD_Tracker_Card_Rectfication_Entry.csv';
        $file = fopen($filePath, 'w'); # open the filePath - create if not exists

        fputcsv($file, ['Correction Entry']);
        fputcsv($file, ['Existing MIS Data', '', '', '', '', '', '', '', '', '', '', '', '', 'Rectification Entry', '', '', '']);

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
                'Content-Disposition' => 'attachment;filename="Payment_MIS_COMMERCIAL_HEAD_Tracker_UPI_Rectfication_Entry.csv"',
            ]
        );
    }








    /**
     * Return excel export headers
     * @return array
     */
    public function headers(string $type = ''): array {

        if ($type == 'importable') {
            return [
                "Unique Id", "Sales Date", "Deposit Date", "Store ID",
                "Retek Code", "Brand", "ColBank",
                "Status", "UPI Sales", "Deposit Amount",
                "Store Response Entry", "Difference [Sales - Deposit - Store Response]",
                '', "New Sale Date", "New Store ID",
                "New Retek Code", "New Tender [ColBank]"
            ];
        }

        return [
            "Sales Date", "Deposit Date", "Store ID",
            "Retek Code", "Brand", "ColBank",
            "Status", "UPI Sales", "Deposit Amount",
            "Store Response Entry", "Difference [Sales - Deposit - Store Response]"
        ];
    }






    /**
     * Contents for the header of the excel file
     * @param mixed $file
     * @return bool
     */
    public function content($file) {
        $_totals = $this->getData('get_totals');

        fputcsv($file, ['Total Count: ', $_totals[0]->TotalCount]);
        fputcsv($file, ['Matched Count: ', $_totals[0]->MatchedCount]);
        fputcsv($file, ['Not Matched Count: ', $_totals[0]->NotMatchedCount]);
        fputcsv($file, ['']);
        fputcsv($file, ['', '', '', '', '', '', 'Total', $_totals[0]->sales_totalF, $_totals[0]->collection_totalF, $_totals[0]->adjustment_totalF, $_totals[0]->difference_totalF]);

        return false;
    }







    /**
     * filters 
     * @param string $type
     * @return array
     */
    public function filtersSyncDataset(string $type) {
        return DB::select(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_UPI_Reconciliation_Filters :procType, :store, :brand, :location',
            [
                "procType" => $type,
                "store" => $this->_store,
                "brand" => $this->_brand,
                "location" => $this->_location
            ]
        );
    }






    /**
     * Download item
     * @param string $value
     * @return \Illuminate\Support\Collection|bool
     */
    public function download(string $value = ''): Collection|bool {
        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_UPI_Reconciliation :procType, :storeId, :brand, :location, :status, :bank, :timeline, :startDate, :endDate', [
                'procType' => 'simple-upi-export',
                'storeId' => $this->_store,
                'brand' => $this->_brand,
                'location' => $this->_location,
                'status' => $this->status,
                'bank' => $this->bank,
                'timeline' => $value,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
            ], perPage: $this->perPage, orderBy: $this->orderBy
        );
    }






    /**
     * Data source
     * @return mixed
     */
    public function getData(string $type) {
        // main SP
        $params = [
            'procType' => $type,
            'storeId' => $this->_store,
            'brand' => $this->_brand,
            'location' => $this->_location,
            'status' => $this->status,
            'bank' => $this->bank,
            'timeline' => '',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Tracker_UPI_Reconciliation :procType, :storeId, :brand, :location, :status, :bank, :timeline, :startDate, :endDate',
            $params,
            perPage: $this->perPage,
            orderBy: $this->orderBy
        );
    }






    public function render() {
        return view('livewire.commercial-head.tracker.upi-reconciliation', [
            'cashRecons' => $this->getData('card'),
            '_totals' => $this->getData(type: 'get_totals'),
            'selectionHas' => $this->getData('card')->pluck('cardSalesRecoUID'),
        ]);
    }

}
