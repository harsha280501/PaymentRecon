<?php

namespace App\Http\Livewire\CommercialHead\Reports\UnAllocatedTransactions;

use Carbon\Carbon;
use App\Traits\HasTabs;
use Livewire\Component;
use Illuminate\Http\File;
use App\Traits\ReadsExcel;
use App\Traits\UseOrderBy;
use App\Traits\ParseMonths;
use App\Traits\UseDefaults;
use App\Traits\UseMisModels;
use Livewire\WithFileUploads;
use App\Traits\WithExportDate;
use App\Traits\HasInfinityScroll;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\MFLInwardStoreIDMissingTransactions;
use App\Models\Store;
use App\Traits\UseHelpers;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class MismatchStoreRecon extends Component {

    use HasInfinityScroll, HasTabs, UseOrderBy, ParseMonths, WithExportDate, UseDefaults, UseHelpers, WithFileUploads;





    public $activeTab = 'unallocated';






    /**
     * Display the active tab on the browser
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 'tab']
    ];






    /**
     * Filename for export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Reports_Un_Allocated_Transaction_Mismatch_Store_Recon';









    /**
     * Bank names for the filters
     * @var array
     */
    public $banks = [];






    /**
     * Bank names for the filters
     * @var array
     */
    public $stores = [];











    /**
     * Bank name for the filter
     * @var string
     */
    public $bank = '';










    /**
     * Display error messages in the upload modal
     * @var string
     */
    public $message = '';








    // Log::channel(' mismatch-store-recon')->info('Data Recieved: ', ['Data' => $request->all()]);



    /**
     * File to import
     */
    public $importFile = null;










    /**
     * Resets all the properties
     * @return void
     */
    public function mount() {
        $this->_months = $this->_months()->toArray();
        $this->banks = $this->dataset('banks');
        $this->stores = $this->dataset('stores');
    }




    /**
     * Reload the filters
     * @return void
     */
    public function back() {
        $this->emit('resetAll');
        $this->resetExcept(['activeTab']);
    }




    public function query(string $bank) {

        if (in_array($bank, ['HDFC', 'IDFC', 'ICICI Cash', 'SBICASHMIS', 'SBICASHMumbai', 'SBI Cash', 'AXIS Cash'])) {
            return DB::table('MFL_Inward_AllBankCashMIS');
        }

        if (in_array($bank, ['HDFC Card', 'ICICI Card', 'AMEX Card', 'SBI Card', 'HDFC UPI'])) {
            return DB::table('MFL_Inward_AllBankCardMIS');
        }

        if (in_array($bank, ['WALLET PAYTM', 'WALLET PHONEPAY'])) {
            return DB::table('MFL_Inward_AllWalletMIS');
        }
    }






    /**
     * Headers for excel export
     * @return array
     */
    public function headers(): array {
        return [

            "UID", "Deposit Date", "Store ID", "Retek Code",
            "Collection Bank", "Store Update Remarks",
            "Deposit Amount", "Store Response Entry",
            "New Store ID", "New Reteck Code", "New Tender"

        ];
    }







    /**
     * Download data for excel
     * @param string $value
     * @return Collection|array|boolean
     */
    public function download(string $value = ''): Collection|array|bool {
        return $this->dataset('export');
    }









    /**
     * Content to generate excel export
     * @param mixed $file
     * @return bool
     */
    public function content($file): bool {
        return false;
    }




    public function withHeaders(array $headers, array $data) {
        $combinedData = [];

        // Ensure both arrays have the same number of elements for proper mapping
        if (count($headers) !== count($data)) {
            throw new InvalidArgumentException('Heading and data arrays must have the same number of elements.');
        }

        // for ($i = 1; $i < count($headers); $i++) {

        foreach ($headers as $key => $value) {
            $combinedData[$value] = $data[$key];
        }

        return $combinedData;
    }



    /**
     * Perform an action when the file is uploadeds
     * @return bool
     */
    public function updatedImportFile() {

        // message to display when the file is uploaded
        $this->message = 'File : Loading ...';
        Log::channel(' mismatch-store-recon')->info('Bulk Upload');
        Log::channel(' mismatch-store-recon')->info('- initiated ');
        // save the file and validate
        $filename = $this->importFile->store('un-allocated');
        $file_path = storage_path() . '/app/public/' . $filename;

        $sheet = $this->reader($file_path);
        $this->headers = $sheet[1];
        unset($sheet[1]); // removing the header from the array
        Log::channel(' mismatch-store-recon')->info('- File Read ', ['data' => json_encode($sheet)]);

        $this->message = 'File: Validating ...';
        $index = 2;

        try {

            DB::beginTransaction();

            foreach ($sheet as $item) {

                Log::channel(' mismatch-store-recon')->info('- Processing Line ', ['data' => json_encode($item)]);

                $data = $this->withHeaders($this->headers, $item);

                if (!$this->validateArray($data, $index)) {
                    Log::channel(' mismatch-store-recon')->info('- Validation Error ', ['data' => json_encode($item)]);
                    return false;
                }


                $status = $this->uploadExcelValidatedArray($data);

                if (!$status) {
                    return false;
                }

                Log::channel(' mismatch-store-recon')->info('- Record uploaded to DB ', ['data' => json_encode($item)]);
                $index++;
            }

            DB::commit();
            $this->emit('unallocated:success');
            return true;
        } catch (\Throwable $th) {
            DB::rollback();

            Log::channel(' mismatch-store-recon')->info('- Error Occured ', ['data' => json_encode($th)]);
            $this->message = 'File: Server error ... ' . $th->getMessage() . '- The Data updated by using this file will be reverted back to its original state :)';
            return false;
        }
    }



    /**
     * Save the data to a file
     * @param array $dataset
     * @return bool
     */
    public function uploadExcelValidatedArray(array $dataset) {

        Log::channel('mismatch-store-recon')->debug('Starting uploadExcelValidatedArray method', ['dataset' => $dataset]);

        if (!$dataset['New Tender']) {
            Log::channel('mismatch-store-recon')->info('Bank Name Mismatch - New Tender is empty', ['data' => $dataset]);
            return true;
        }

        if (!in_array($dataset['New Tender'], [
            "AXIS Cash", "ICICI Cash", "HDFC", "SBICASHMumbai", "SBICASHMIS",
            "IDFC", "HDFC Card", "ICICI Card", "SBI Card", "AMEX Card",
            "HDFC UPI", "WALLET PAYTM", "WALLET PHONEPAY"
        ])) {
            Log::channel('mismatch-store-recon')->warning('Invalid Collection Bank - Bank Name Mismatch', ['data' => $dataset]);
            $this->emit('unallocated:failed', 'Invalid Collection Bank');
            return false;
        }

        Log::channel('mismatch-store-recon')->debug('Searching for record in MFLInwardStoreIDMissingTransactions', ['UID' => $dataset['UID']]);
        $_main = MFLInwardStoreIDMissingTransactions::find($dataset['UID']);

        if (!$_main) {
            Log::channel('mismatch-store-recon')->warning('Record not found in MFLInwardStoreIDMissingTransactions', ['UID' => $dataset['UID']]);
            return false;
        }

        Log::channel('mismatch-store-recon')->debug('Executing query based on New Tender', ['New Tender' => $dataset['New Tender']]);
        $query = $this->query($dataset['New Tender']);

        if (!$query) {
            Log::channel('mismatch-store-recon')->warning('Query result is empty for New Tender', ['New Tender' => $dataset['New Tender']]);
            return true;
        }

        Log::channel('mismatch-store-recon')->debug('Fetching Store record', ['storeID' => $dataset['New Store ID']]);
        $_store = Store::where('Store ID', $dataset['New Store ID'])->first();

        if (!$_store) {
            Log::channel('mismatch-store-recon')->warning('Store not found', ['storeID' => $dataset['New Store ID']]);
            return false;
        }

        Log::channel('mismatch-store-recon')->info('Updating StoreID missing transaction record', [
            'isInserted' => 1,
            'updatedStoreID' => $dataset['New Store ID'],
            'updatedRetekCode' => $dataset['New Reteck Code'],
            'updatedTender' => $dataset['New Tender']
        ]);

        $_main->update([
            'isInserted' => 1,
            "updatedStoreID" => $dataset['New Store ID'],
            "updatedRetekCode" => $dataset['New Reteck Code'],
            "updatedTender" => $dataset['New Tender']
        ]);

        Log::channel('mismatch-store-recon')->debug('Inserting new record into query', [
            'storeID' => $dataset['New Store ID'],
            'retekCode' => $dataset['New Reteck Code'],
            'colBank' => $dataset['New Tender'],
            'brand' => $_store->{'Brand Desc'},
            'depositDate' => $_main->depositDate,
            'depositAmount' => $_main->depositAmount,
            'remarks' => 'Unallocated Insert'
        ]);

        $query->insert([
            'storeID' => $dataset['New Store ID'],
            'retekCode' => $dataset['New Reteck Code'],
            'colBank' => $dataset['New Tender'],
            'brand' => $_store->{'Brand Desc'},
            'depositDt' => $_main->depositDate,
            'depositAmount' => $_main->depositAmount,
            'remarks' => 'Unallocated Insert'
        ]);

        Log::channel('mismatch-store-recon')->info('Update Successful', ['data' => $dataset]);
        return true;
    }


    public function validateArray(array $data, int $rowNum) {

        // read the file as array
        $validator = Validator::make($data, [
            "UID" => "required",
            "Deposit Date" => "nullable",
            "Store ID" => "nullable",
            "Retek Code" => "nullable",
            "Collection Bank" => "nullable",
            "Store Update Remarks" => "nullable",
            "Deposit Amount" => "nullable",
            "Store Response Entry" => "nullable",
            "New Store ID" => "nullable|regex:/^[0-9]{4}$/",
            "New Retek Code" => "nullable|regex:/^[0-9]{5}$/",
            "New Tender" => "nullable",
        ]);


        if ($validator->fails()) {
            $this->message = 'File: Validation Error: ' . $validator->errors()->first() . ' on row number - ' . $rowNum;
            return false;
        }

        return true;
    }



    public function recon(array $dataset) {

        Log::channel('mismatch-store-recon')->debug('Starting recon method', ['dataset' => $dataset]);

        if (!in_array(trim($dataset['colBank']), [
            "AXIS Cash", "ICICI Cash", "HDFC", "SBICASHMumbai", "SBICASHMIS",
            "IDFC", "HDFC Card", "ICICI Card", "SBI Card", "AMEX Card",
            "HDFC UPI", "WALLET PAYTM", "WALLET PHONEPAY"
        ])) {
            Log::channel('mismatch-store-recon')->info('Bank Name Mismatch', ['data' => $dataset]);
            $this->emit('unallocated:failed', 'Invalid Collection Bank');
            return false;
        }

        try {
            Log::channel('mismatch-store-recon')->debug('Initiating transaction');

            DB::beginTransaction();
            $query = $this->query($dataset['colBank']);

            Log::channel('mismatch-store-recon')->info('Recon - Single item update started');
            Log::channel('mismatch-store-recon')->info('Incoming dataset', ['data' => $dataset]);

            if (!$query) {
                Log::channel('mismatch-store-recon')->warning('Invalid Collection Bank during query execution', ['data' => $dataset]);
                $this->emit('unallocated:failed', 'Invalid Collection Bank');
                return true;
            }

            Log::channel('mismatch-store-recon')->debug('Fetching StoreID missing transaction record', ['storeMissingUID' => $dataset['id']]);
            $_data = MFLInwardStoreIDMissingTransactions::where('storeMissingUID', $dataset['id'])->first();
            Log::channel('mismatch-store-recon')->info('Fetched missing store ID data', ['data' => $_data]);

            if (!$_data) {
                Log::channel('mismatch-store-recon')->warning('No data found for the given Store Missing UID', ['data' => $dataset]);
                $this->emit('unallocated:failed', 'Unable to find the data');
                return true;
            }

            Log::channel('mismatch-store-recon')->debug('Fetching Store record', ['storeID' => $dataset['storeID']]);
            $_store = Store::where('Store ID', $dataset['storeID'])->first();
            Log::channel('mismatch-store-recon')->info('Fetched Store data', ['store' => $_store]);

            Log::channel('mismatch-store-recon')->debug('Updating StoreID missing transaction record', [
                'isInserted' => 1,
                'updatedStoreID' => $dataset['storeID'],
                'updatedRetekCode' => $dataset['retekCode'],
                'updatedTender' => $dataset['colBank']
            ]);
            $_data->update([
                'isInserted' => 1,
                "updatedStoreID" => $dataset['storeID'],
                "updatedRetekCode" => $dataset['retekCode'],
                "updatedTender" => $dataset['colBank']
            ]);

            Log::channel('mismatch-store-recon')->debug('Inserting into recon query', [
                'storeID' => $dataset['storeID'],
                'retekCode' => $dataset['retekCode'],
                'colBank' => $dataset['colBank'],
                'brand' => $_store->{'Brand Desc'},
                'depositDate' => $_data->depositDate,
                'depositAmount' => $_data->depositAmount,
                'remarks' => 'Unallocated Insert'
            ]);
            $query->insert([
                'storeID' => $dataset['storeID'],
                'retekCode' => $dataset['retekCode'],
                'colBank' => $dataset['colBank'],
                'brand' => $_store->{'Brand Desc'},
                'depositDt' => $_data->depositDate,
                'depositAmount' => $_data->depositAmount,
                'remarks' => 'Unallocated Insert'
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::channel('mismatch-store-recon')->error('Error occurred during recon process', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'dataset' => $dataset
            ]);
            $this->emit('unallocated:failed', $th->getMessage());
            return false;
        }

        DB::commit();
        Log::channel('mismatch-store-recon')->info('Successfully completed recon process');
        Log::channel('mismatch-store-recon')->info('Recon - Single item update completed');

        $this->emit('unallocated:success');
        return true;
    }




    /**
     * Dataset for the screen
     * @return array
     */
    public function dataset(string $type) {

        $params = [
            'procType' => $type,
            'bank' => $this->bank,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ];

        return DB::withOrderBySelect(
            'PaymentMIS_PROC_SELECT_COMMERCIALHEAD_Reports_Unallocated_Collection_Mismatch_Store_Recon :procType, :bank, :from, :to',
            $params,
            $this->perPage,
            $this->orderBy
        );
    }






    /**
     * Render main content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {

        $dataset = $this->dataset('main');

        return view('livewire.commercial-head.reports.un-allocated-transactions.mismatch-store-recon', [
            'dataset' => $dataset
        ]);
    }
}
