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

        if (in_array($bank, ['HDFC', 'IDFC', 'ICICI Cash', 'SBICASHMIS', 'SBICASHMumbai', 'SBI Cash', 'Axis Cash'])) {
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

        // save the file and validate
        $filename = $this->importFile->store('un-allocated');
        $file_path = storage_path() . '/app/public/' . $filename;

        $sheet = $this->reader($file_path);
        $this->headers = $sheet[1];
        unset($sheet[1]); // removing the header from the array

        $this->message = 'File: Validating ...';
        $index = 2;

        try {

            DB::beginTransaction();

            foreach ($sheet as $item) {

                $data = $this->withHeaders($this->headers, $item);

                if (!$this->validateArray($data, $index)) {
                    return false;
                }


                $status = $this->uploadExcelValidatedArray($data);

                if (!$status) {
                    return false;
                }

                $index++;
            }

            DB::commit();
            $this->emit('unallocated:success');
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
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

        if (!$dataset['New Tender']) {
            return true;
        }



        if (!in_array($dataset['New Tender'], ["AXIS Cash", "ICICI Cash", "HDFC", "SBICASHMumbai", "SBICASHMIS", "IDFC", "HDFC Card", "ICICI Card", "SBI Card", "Amex Card", "HDFC UPI", "WALLET PAYTM", "WALLET PHONEPAY"])) {
            $this->emit('unallocated:failed', 'Invalid Collection Bank');
            return false;
        }


        // find the record
        $_main = MFLInwardStoreIDMissingTransactions::find($dataset['UID']);

        if (!$_main) {
            return false;
        }

        $query = $this->query($dataset['New Tender']);

        if (!$query) {
            return true;
        }


        
        $_store = Store::where('Store ID', $dataset['New Store ID'])->first();
        
        $_main->update([
            'isInserted' => 1,
            "updatedStoreID" => $dataset['storeID'],
            "updatedRetekCode" => $dataset['retekCode'],
            "updatedTender" => $dataset['colBank']
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


        if (!in_array($dataset['colBank'], ["AXIS Cash", "ICICI Cash", "HDFC", "SBICASHMumbai", "SBICASHMIS", "IDFC", "HDFC Card", "ICICI Card", "SBI Card", "Amex Card", "HDFC UPI", "WALLET PAYTM", "WALLET PHONEPAY"])) {
            $this->emit('unallocated:failed', 'Invalid Collection Bank');
            return false;
        }

        

        try {

            DB::beginTransaction();

            $query = $this->query($dataset['colBank']);


            if (!$query) {
                $this->emit('unallocated:failed', 'Invalid Collection Bank');
                return true;
            }

            $_data = MFLInwardStoreIDMissingTransactions::where('storeMissingUID', $dataset['id'])->first();

            if (!$query) {
                $this->emit('unallocated:failed', 'Unable to find the data');
                return true;
            }

            $_store = Store::where('Store ID', $dataset['storeID'])->first();

            $_data->update([
                'isInserted' => 1,
                "updatedStoreID" => $dataset['storeID'],
                "updatedRetekCode" => $dataset['retekCode'],
                "updatedTender" => $dataset['colBank']
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
            $this->emit('unallocated:failed', $th->getMessage());
            return false;
        }

        DB::commit();
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
