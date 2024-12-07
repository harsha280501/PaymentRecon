<?php

namespace App\Http\Livewire\CommercialHead\Settings;

use App\Models\MAmexMID;
use App\Traits\HasTabs;
use Exception;
use Livewire\Component;
use App\Traits\HasInfinityScroll;
use App\Traits\ParseMonths;
use App\Traits\ReadsExcel;
use App\Traits\UseDefaults;
use App\Traits\UseLocation;
use App\Traits\UseOrderBy;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Livewire\WithFileUploads;

class TidMidMaster extends Component
{

    use HasInfinityScroll, HasTabs, UseOrderBy, ParseMonths, UseLocation, UseDefaults, WithFileUploads, ReadsExcel;




    /**
     * Current Tab
     * @var string
     */
    public $activeTab = 'amexmid';






    /**
     * Show the active tab on the url
     * @var array
     */
    protected $queryString = [
        'activeTab' => ['as' => 't']
    ];











    /**
     * Filename for Excel Export
     * @var string
     */
    public $export_file_name = 'Payment_MIS_COMMERCIAL_HEAD_Settings_TID_MID_Master_';













    /**
     * Brand when updating
     * @var string
     */
    public $Brand = '';















    /**
     * Brand when updating
     * @var string
     */
    public $tids = [];












    /**
     * Brand when updating
     * @var string
     */
    public $tid = '';









    /**
     * Brand when updating
     * @var string
     */
    public $bank = '';











    /**
     * Brand when updating
     * @var string
     */
    public $storeFrom = null;










    /**
     * Brand when updating
     * @var string
     */
    public $storeTo = null;










    /**
     * List of Stores
     * @var array
     */
    public $stores = [];






    /**
     * List of Brands
     * @var array
     */
    public $brands = [];








    /**
     * List of Brands
     * @var array
     */
    public $banks = [];








    /**
     * List of Brands
     * @var array
     */
    public $headers = [];








    /**
     * List of Brands
     * @var array
     */
    public $message = '';







    /**
     * File to import
     * @var File
     */
    public $importFile = null;







    /**
     * Initializing file
     * @return void
     */
    public function mount()
    {
        $this->brands = $this->getBrands();
        $this->stores = $this->getStores();
        $this->_months = $this->_months()->toArray();
        $this->banks = $this->getBank();
    }





    /**
     * Reload the filters
     * @return void
     */
    public function back()
    {
        $this->emit('resetAll');
        $this->resetExcept(['activeTab']);
    }




    public function activeQuery()
    {


        if ($this->activeTab == 'unallocated') {
            return null;
        }

        $query = [
            "amexmid" => \App\Models\MAmexMID::query(),
            "icicimid" => \App\Models\MICICIMID::query(),
            "sbimis" => \App\Models\MSBIMID::query(),
            "hdfctid" => \App\Models\MHDFCTID::query()
        ];

        return $query[$this->activeTab];
    }




    public function updatingStoreFrom($value)
    {
        if (!$this->storeTo) {
            $this->storeTo = $value;
        }
    }




    public function updatedStoreTo($value)
    {
        if (!$this->storeFrom) {
            $this->storeFrom = $value;
        }
    }


    /**
     * Headers for export
     * @return array
     */
    public function headers()
    {

        if ($this->activeTab == 'unallocated') {
            return [
                'TID',
                'Collection Bank'
            ];
        }

        return [
            "Unique Id",
            "TID",
            "Store Id",
            "Opening Date",
            "New Retek Code",
            "Old Retek Code",
            "Brand Name",
            "Status",
            "Conversion Date",
            "Closure Date",
            "Bank"
        ];
    }

    /**
     * Export as CSV
     * @return void
     */
    public function export()
    {
        $data = $this->download();
        $headers = $this->headers();

        if (count($data) < 1) {
            $this->emit('no-data');
            return false;
        }

        $filePath = public_path() . '/' . $this->export_file_name . '.csv';
        $file = fopen($filePath, 'w'); // Create or open file
        fputcsv($file, $headers); // Add headers to the CSV

        foreach ($data as $row) {
            $row = (array) $row; // Convert object to array for manipulation


            if ($this->activeTab == 'amexmid') {
                $row['Bank'] = "AMEX";
            } elseif ($this->activeTab == 'icicimid') {
                $row['Bank'] = "ICICI";
            } elseif ($this->activeTab == 'hdfctid') {
                $row['Bank'] = "HDFC";
            } elseif ($this->activeTab == 'sbimis') {
                $row['Bank'] = "SBI";
            } else {
                $row['Bank'] = "Unknown";
            }

            if (in_array($row, ["POS", "relevance", "EDCServiceProvider"])) {
                continue;
            } else {
                fputcsv($file, $row);
            }
        }

        fclose($file); // Close the file

        return response()->stream(
            function () use ($filePath) {
                echo file_get_contents($filePath);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment;filename="' . $this->export_file_name . ucfirst($this->activeTab) . '"',
            ]
        );
    }


    /**
     * Validation for array items
     *
     * @param array $data
     * @param integer $rowNum
     * @return bool
     */
    public function validateArray(array $data, int $rowNum)
    {

        // read the file as array
        $validator = Validator::make($data, [
            "Unique Id" => "nullable",
            "TID" => "required",
            "Store Id" => "required|regex:/^[0-9]{4}$/",
            "Opening Date" => "nullable",
            "New Retek Code" => "required",
            "Old Retek Code" => "nullable",
            "Brand Name" => "required",
            "Status" => "nullable",
            "Conversion Date" => "nullable|date",
            // "POS" => "nullable",
            // "Relevance" => "nullable",
            // "EDC Service Provider" => "nullable",
            "Closure Date" => "nullable"
        ]);


        if ($validator->fails()) {
            $this->message = 'File: Validation Error: ' . $validator->errors()->first() . ' on row number - ' . $rowNum;
            return false;
        }

        return true;
    }

    /**
     * Perform an action when the file is uploadeds
     * @return bool
     */


    public function handleSubmit()
    {
        // message to display when the file is uploaded
        $this->message = 'File : Loading ...';

        // save the file and validate
        $filename = $this->importFile->store('tid-mid-master');

        // $filename1 = $this->importFile->storeAs('tid-mid-master');
        $file_path = storage_path() . '/app/public/' . $filename;

        $sheet = $this->reader($file_path);
        $this->headers = $sheet[1];
        unset($sheet[1]); // removing the header from the array
        $this->message = 'File: Validating ...';
        $index = 1;

        // try {

        foreach ($sheet as $item) {
            $data = $this->withHeaders($this->headers, $item);

            if (!$this->validateArray(data: $data, rowNum: $index)) {
                return false;
            }

            $status = $this->uploadExcelValidatedArray($data, $filename);
            if (!$status) {
                $this->message = "File: Upload failed on row #$index";
                return false;
            }


            $index++;
        }

        $this->message = "File: Uploaded";
        $this->emit('uploadSuccess', 'File uploaded successfully!');
        return true;
    }







    /**
     * Save the data to a file
     * @param array $dataset
     * @return bool
     */
    public function uploadExcelValidatedArray(array $dataset, string $filename)
    {
        $data = [
            "storeID" => $dataset["Store Id"],
            // "openingDt" => !$dataset["Opening Date"] ? null : Carbon::parse($dataset["Opening Date"])->format('Y-m-d'),
            "openingDt" => !$dataset["Opening Date"]
                ? null
                : (is_numeric($dataset["Opening Date"])
                    ? Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dataset["Opening Date"])->format('Y-m-d'))
                    : Carbon::parse($dataset["Opening Date"])->format('Y-m-d')),


            "newRetekCode" => $dataset["New Retek Code"],
            "oldRetekCode" => $dataset["Old Retek Code"],
            "Status" => $dataset["Status"],
            // "conversionDt" => !$dataset["Conversion Date"] ? null : Carbon::parse($dataset["Conversion Date"])->format('Y-m-d'),

             "conversionDt" => !$dataset["Conversion Date"]
                ? null
                : (is_numeric($dataset["Conversion Date"])
                    ? Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dataset["Conversion Date"])->format('Y-m-d'))
                    : Carbon::parse($dataset["Conversion Date"])->format('Y-m-d')),
            // "POS" => $dataset["POS"],
            // "relevance" => $dataset["Relevance"],
            // "EDCServiceProvider" => $dataset["EDC Service Provider"],
            "closureDate" => !$dataset["Closure Date"] ? null : Carbon::parse($dataset["Closure Date"])->format('Y-m-d'),
            'filename' => $filename
        ];



        // appending TID MID
        if ($this->activeTab == 'icicimid') {
            $data = [
                ...$data,
                "brandCode" => $dataset["Brand Name"]
            ];
        } else {
            $data = [
                ...$data,
                "brandName" => $dataset["Brand Name"]
            ];
        }

        // appending TID MID
        if ($this->activeTab == 'hdfctid') {
            $data = [
                ...$data,
                "TID" => $dataset["TID"]
            ];
        } else {
            $data = [
                ...$data,
                "MID" => $dataset["TID"]
            ];
        }

        // DB::beginTransaction();

        // try {


        $col = $this->activeTab == 'hdfctid' ? 'TID' : 'MID';
        if (!$dataset['Unique Id']) {
            // commented on 18-11-24 //harsha
            // if ($this->activeQuery()
            //     ->where($col, $dataset["TID"])
            //     ->where('storeID', $dataset["Store Id"])
            //     // ->where('conversionDt', null)
            //     ->exists()
            // ) {
            //     logger('here');
            //     $this->message = 'Cannot Create a new TID when the same exists!, Trust me, You Dont wannt to do it :)';
            //     return false;
            // }

            $res = $this->activeQuery()->insert([...$data]);
        } else {

            // find the data
            $_main = $this->activeQuery()->find($dataset['Unique Id']);
            // update the data with new data
            $res = $_main->update([...$data]);
        }

        if (!$res) {
            $this->message = 'Something went wrong';
            return false;
        }

        // DB::commit();
        return true;
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     return false;
        // }
    }







    public function createTID(array $dataset)
    {

        try {

            $_query = $this->activeQuery();

            $data = [
                // 'POS' => $dataset["POS"],
                'storeID' => $dataset["storeID"],
                'openingDt' => null,
                'oldRetekCode' => $dataset["oldRetekCode"],
                'newRetekCode' => $dataset["newRetekCode"],
                'Status' => $dataset["Status"],

                'closureDate' => $dataset["closureDate"] ?: NUll,
                'conversionDt' => $dataset["conversionDt"] ?: NUll,
                // 'relevance' => $dataset["relevance"],
                // 'EDCServiceProvider' => $dataset["EDCServiceProvider"]
            ];

            // appending TID MID
            if ($this->activeTab == 'icicimid') {
                $data = [
                    ...$data,
                    "brandCode" => $dataset["brandName"]
                ];
            } else {
                $data = [
                    ...$data,
                    "brandName" => $dataset["brandName"]
                ];
            }

            // appending TID MID
            if ($this->activeTab == 'hdfctid') {
                $data = [
                    ...$data,
                    "TID" => $dataset["MID"]
                ];
            } else {
                $data = [
                    ...$data,
                    "MID" => $dataset["MID"]
                ];
            }


            DB::beginTransaction();
            // Use the 'update' method to update the record
            $res = $_query->insert([...$data]);

            if (!$res) {
                $this->emit('tid:failed', ["message" => 'Something went wrong!']);
                return false;
            }

            DB::commit();
            $this->emit('tid:success', ["message" => "TID Created"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('tid:failed', ["message" => $th->getMessage()]);
            return false;
        }
    }




    /**
     * Brand filter, get brands list
     * @return \Illuminate\Support\Collection
     */
    public function getBrands(): \Illuminate\Support\Collection
    {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_TidMidMaster :tab, :brand, :storeFrom, :storeTo, :tid, :from, :to, :bank', [
            'tab' => $this->activeTab . '-brands',
            'brand' => $this->Brand,
            'storeFrom' => $this->storeFrom,
            'storeTo' => $this->storeTo,
            'tid' => $this->tid,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'bank' => $this->bank
        ], $this->perPage, $this->orderBy);
    }





    /**
     * Brand filter, get brands list
     * @return \Illuminate\Support\Collection
     */
    public function getBank(): \Illuminate\Support\Collection
    {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_TidMidMaster :tab, :brand, :storeFrom, :storeTo, :tid, :from, :to, :bank', [
            'tab' => 'unallocated-banks',
            'brand' => $this->Brand,
            'storeFrom' => $this->storeFrom,
            'storeTo' => $this->storeTo,
            'tid' => $this->tid,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'bank' => $this->bank
        ], $this->perPage, $this->orderBy);
    }

    /**
     * Brand filter, get brands list
     * @return \Illuminate\Support\Collection
     */
    public function getStores(): \Illuminate\Support\Collection|array
    {
        if (!$this->activeQuery()) {
            return [];
        }

        return $this->activeQuery()->distinct()->pluck('storeID')->toArray();
    }

    /**
     * Brand filter, get brands list
     * @return \Illuminate\Support\Collection
     */
    public function tidMid(): \Illuminate\Support\Collection
    {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_TidMidMaster :tab, :brand, :storeFrom, :storeTo, :tid, :from, :to, :bank', [
            'tab' => $this->activeTab . '-tids',
            'brand' => $this->Brand,
            'storeFrom' => $this->storeFrom,
            'storeTo' => $this->storeTo,
            'tid' => $this->tid,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'bank' => $this->bank
        ], $this->perPage, $this->orderBy);
    }

    /**
     * Get the main Dataset
     * @param string $value
     * @return Collection|array
     */
    public function download($value = ""): Collection|array
    {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_TidMidMaster :tab, :brand, :storeFrom, :storeTo, :tid, :from, :to, :bank', [
            'tab' => $this->activeTab . '-export',
            'brand' => $this->Brand,
            'storeFrom' => $this->storeFrom,
            'storeTo' => $this->storeTo,
            'tid' => $this->tid,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'bank' => $this->bank
        ], $this->perPage, $this->orderBy);
    }


    /**
     * Get the main Dataset
     * @return void
     */
    public function getData()
    {
        return DB::withOrderBySelect('PaymentMIS_PROC_SELECT_COMMERCIALHEAD_TidMidMaster :tab, :brand, :storeFrom, :storeTo, :tid, :from, :to, :bank', [
            'tab' => $this->activeTab,
            'brand' => $this->Brand,
            'storeFrom' => $this->storeFrom,
            'storeTo' => $this->storeTo,
            'tid' => $this->tid,
            'from' => $this->startDate,
            'to' => $this->endDate,
            'bank' => $this->bank
        ], $this->perPage, $this->orderBy);
    }

    /**
     * Render - Main 
     * @return View
     */
    public function render(): View
    {
        $this->tids = $this->tidMid();

        return view('livewire.commercial-head.settings.tid-mid-master', [
            'dataset' => $this->getData()
        ]);
    }
}
