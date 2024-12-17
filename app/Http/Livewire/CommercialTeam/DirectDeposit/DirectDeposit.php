<?php

namespace App\Http\Livewire\CommercialTeam\DirectDeposit;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\UseDefaults;
use App\Traits\UseOrderBy;
use App\Traits\UseRemarks;
use App\Traits\WithExportDate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;


class DirectDeposit extends Component implements UseExcelDataset, WithHeaders {


    use HasInfinityScroll, ParseMonths, UseOrderBy, UseRemarks, WithFileUploads, UseOrderBy, WithExportDate, UseDefaults, WithFileUploads;







    /**
     * Remarks
     * @var array
     */
    public $remarks = [];





    /**
     * File Upload 
     * @var [type]
     */
    public $uploadFile = null;








    /**
     * Store ID filter
     * @var array
     */
    public $stores = [];









    /**
     * Store Var
     * @var string
     */
    public $store = '';









    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Deposit_Direct_Cash_Deposit';








    /**
     * Init function
     * @return void
     */
    public function mount() {
        $this->stores = $this->stores();
        $this->_months = $this->_months()->toArray();
    }









    /**
     * Excel Export Headers
     * @return array
     */
    public function headers(): array {
        return [
            "Store ID",
            "Retek Code",
            "Date",
            "Status",
            "Deposit SlipNo",
            "Amount",
            "Bank"
        ];
    }







    /**
     * Excel Export function 
     * @return void
     */
    public function export() {

        $data = $this->download('');
        $headers = $this->headers();


        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }



        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // open the filePath - create if not exists



        fputcsv($file, $headers); // adding headers to the excel

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
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . '"',
            ]
        );
    }










    /**
     * Get the Stores data
     * @return array
     */
    public function stores() {
        return DB::withOrderBySelect('PaymentMIS_PROC_COMMERCIALTEAM_SELECT_Direct_Deposit :procType, :storeId, :from, :to', [
            'procType' => 'stores',
            'storeId' => '',
            'from' => '',
            'to' => '',
        ], $this->perPage);
    }










    /**
     * Dataset for Excel export
     * Should no be used as main source
     * @param string $value
     * @return Collection|boolean
     */
    public function download($value = ''): Collection|bool {
        return DB::withOrderBySelect('PaymentMIS_PROC_COMMERCIALTEAM_SELECT_Direct_Deposit :procType, :storeId, :from, :to', [
            'procType' => 'export',
            'storeId' => $this->store,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ], $this->perPage, $this->orderBy);
    }





    public function save() {

        $this->validate([
            "uploadFile" => "required|mimes:xls,csv,xlsx"
        ]);

        $fileName = $this->uploadFile->getClientOriginalName() . '_' . now()->format('Y-m-d') . '.' . $this->uploadFile->getClientOriginalExtension();
        $this->uploadFile->storeAs('commercial/direct-deposit/', $fileName);
        $fullPath = storage_path() . "/app/public/commercial/direct-deposit/" . $fileName;
        $excel = $this->reader($fullPath);

        foreach ($excel as $index => $row) {

            // Skip the header row
            if ($index == 1)
                continue;
            try {

                $data = [
                    'bookDate' => $this->format($row['A']),
                    'description' => $row['B'],
                    'ledgerBalance' => $row['C'],
                    'credit' => $row['D'],
                    'amount' => $row['D'],
                    'debit' => $row['E'],
                    'directDepositDate' => $this->format($row['F']),
                    'referenceNo' => $row['G'],
                    'transactionBranch' => $row['H'],
                ];

                // $data = [
                //     'storeID' => $row['A'],
                //     'retekCode' => $row['B'],
                //     'depositSlipNo' => $row['C'],
                //     'amount' => $row['D'],
                //     'directDepositDate' => $this->format($row['E']),
                //     'bank' => $row['F'],
                //     'accountNo' => $row['G'],
                //     'bankBranch' => $row['H'],
                //     'location' => $row['I'],
                //     'city' => $row['J'],
                //     'state' => $row['K'],
                //     'salesDateFrom' => $this->format($row['L']),
                //     'salesDateTo' => $this->format($row['M']),
                //     'cashDepositBy' => $row['N'],
                //     'otherRemarks' => $row['O'],
                //     'reason' => $row['P']
                // ];

                DB::beginTransaction();

                // inserting to the DB
                \App\Models\Masters\DirectDeposit::updateOrInsert([
                    'bookDate' => $this->format($row['A']),
                    'credit' => $row['D'],
                    'referenceNo' => $row['G'],
                    'transactionBranch' => $row['H']
                ], $data);

                DB::commit();

            } catch (\Throwable $th) {
                DB::rollBack();
                $this->emit('direct-deposit:failed', $th->getMessage());
                return false;
            }
        }

        $this->emit('direct-deposit:success');
        return true;
    }





    /**
     * Update the item set commercial head approval
     * @param string $id
     * @param string $status
     * @param string $remarks
     * @return void
     */
    public function update(string $id, string $status, string $remarks) {
        $record = \App\Models\Masters\DirectDeposit::where('directDepositUID', $id)->first()->update([
            'status' => $status,
            'approvalRemarks' => $remarks
        ]);

        $this->emit('success');
        return $record;
    }




    /**
     * Update the item set commercial head approval
     * @param string $id
     * @param string $status
     * @param string $remarks
     * @return void
     */
    public function updateStoreId(string $id, string $storeID, string $saleDate, string $remarks) {

        $record = \App\Models\Masters\DirectDeposit::where('directDepositUID', $id)->first()->update([
            'storeID' => $storeID,
            'salesDate' => $saleDate,
            'otherRemarks' => $remarks
        ]);

        $this->emit('success');
        return $record;
    }




    public function format(string|null $date) {

        if(!$date) {
            return null;
        }

        $_string = preg_replace('/[^\w]/', '-', $date);

        try {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($_string)->format('Y-m-d');
            } catch (\Throwable $th) {
                return Carbon::parse($_string)->format('Y-m-d');
            }
        } catch (\Throwable $th) {
            return Carbon::createFromFormat('m-d-Y', $_string)->format('Y-m-d');
        }
    }




    public function reader(string $path) {
        $inputFileTypeIdentify = \PhpOffice\PhpSpreadsheet\IOFactory::identify($path);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileTypeIdentify);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);

        $spreadsheet = $reader->load($path);
        return $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    }








    /**
     * Get the Main data
     * @return array
     */
    public function dataset() {
        return DB::withOrderBySelect('PaymentMIS_PROC_COMMERCIALTEAM_SELECT_Direct_Deposit :procType, :storeId, :from, :to', [
            'procType' => 'dataset',
            'storeId' => $this->store,
            'from' => $this->startDate,
            'to' => $this->endDate,
        ], $this->perPage, $this->orderBy);
    }









    /**
     * Render the main function
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        return view('livewire.commercial-team.direct-deposit.direct-deposit', [
            'dataset' => $this->dataset()
        ]);
    }
}