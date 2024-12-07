<?php

namespace App\Http\Livewire\CommercialHead\ApprovalProcess;

use App\Interface\Excel\UseExcelDataset;
use App\Interface\Excel\WithFormatting;
use App\Interface\Excel\WithHeaders;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\StreamExcelDownload;
use App\Traits\UseOrderBy;
use App\Traits\UseRemarks;
use App\Traits\WithExportDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;


class DirectDeposit extends Component implements UseExcelDataset, WithHeaders, WithFormatting {


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



    public $stores = [];



    public $store = '';




    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_Approved_Process_Direct_Cash_Deposit';




    public function mount() {
        $this->stores = $this->stores();
        $this->_months = $this->_months()->toArray();
    }




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
     * Get the Main data
     * @return array
     */
    public function stores() {
        return DB::withOrderBySelect('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Approved_Process_Direct_Deposit :procType, :storeId, :from, :to', [
            'procType' => 'stores',
            'storeId' => '',
            'from' => '',
            'to' => '',
        ], $this->perPage);
    }




    /**
     * Return to main
     * @return void
     */
    public function back() {
        $this->reset();
        $this->emit('resetAll');
    }




    /**
     * Render the main function
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        return view('livewire.commercial-head.approval-process.direct-deposit', [
            'dataset' => $this->dataset()
        ]);
    }







    public function headers(): array {
        return [
            "Store ID",
            "Retek Code",
            "Date",
            "Status",
            "Deposit SlipNo",
            "Amount",
            "Bank",
        ];
    }

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

    public function download($value = ''): Collection|bool {
        return DB::withOrderBySelect('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Approved_Process_Direct_Deposit :procType, :storeId, :from, :to', [
            'procType' => 'export',
            'storeId' => $this->store,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ], $this->perPage, $this->orderBy);
    }


    /**
     * Formatter
     * @param \App\Interface\Excel\SpreadSheet $spreadSheet
     * @param mixed $dataset
     * @return void
     */
    public function formatter(\App\Interface\Excel\SpreadSheet $spreadSheet, $dataset): void {
        $spreadSheet->setStartFrom(4);
        $spreadSheet->setFilename($this->_useToday($this->export_file_name, now()->format('d-m-Y')));
        $spreadSheet->spreadsheet->getActiveSheet()->setCellValue('A' . 1, "Report Title: Direct Cash Deposit Approved Process");
    }






    public function update(string $id, string $status, string $remarks) {
        $record = \App\Models\Masters\DirectDeposit::where('directDepositUID', $id)->first()->update([
            'status' => $status,
            'approvalRemarks' => $remarks
        ]);

        $this->emit('success');
        return $record;
    }




    /**
     * Get the Main data
     * @return array
     */
    public function dataset() {
        return DB::withOrderBySelect('PaymentMIS_PROC_COMMERCIALHEAD_SELECT_Approved_Process_Direct_Deposit :procType, :storeId, :from, :to', [
            'procType' => 'dataset',
            'storeId' => $this->store,
            'from' => $this->startdate,
            'to' => $this->enddate,
        ], $this->perPage, $this->orderBy);
    }

}