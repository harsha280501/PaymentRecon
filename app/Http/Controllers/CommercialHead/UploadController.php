<?php

namespace App\Http\Controllers\CommercialHead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UploadController extends Controller
{
    private $activeTab;
    private $importFile;

    public function __construct(Request $request)
    {
        
        $this->activeTab = $request->tid; 
        $this->importFile = $request->file;     
    }

    public function headers()
    {
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
            "Closure Date"
        ];
    }

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
            "Closure Date" => "nullable"
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'File: Validation Error: ' . $validator->errors()->first() . ' on row number - ' . $rowNum);
            return false;
        }

        return true;
    }

    public function uploadExcelValidatedArray(array $dataset, string $filename)
    {
        $data = [
            "storeID" => $dataset["Store Id"],
            "openingDt" => !$dataset["Opening Date"] ? null : Carbon::parse($dataset["Opening Date"])->format('Y-m-d'),
            "newRetekCode" => $dataset["New Retek Code"],
            "oldRetekCode" => $dataset["Old Retek Code"],
            "Status" => $dataset["Status"],
            "conversionDt" => !$dataset["Conversion Date"] ? null : Carbon::parse($dataset["Conversion Date"])->format('Y-m-d'),
            "closureDate" => !$dataset["Closure Date"] ? null : Carbon::parse($dataset["Closure Date"])->format('Y-m-d'),
            'filename' => $filename
        ];

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

        DB::beginTransaction();

        try {
            $col = $this->activeTab == 'hdfctid' ? 'TID' : 'MID';

            if (!$dataset['Unique Id']) {
                if ($this->activeQuery()
                    ->where($col, $dataset["TID"])
                    ->where('storeID', $dataset["Store Id"])
                    ->where('conversionDt', null)
                    ->exists()
                ) {
                    session()->flash('error', 'Cannot Create a new TID when the same exists!, Trust me, You Dont want to do it :)');
                    return redirect()->back();
                }

                $res = $this->activeQuery()->insert([...$data]);
            } else {
                logger(json_encode($dataset));
                $_main = $this->activeQuery()->find($dataset['Unique Id']);
                $res = $_main->update([...$data]);
            }

            logger(json_encode($dataset));
            if (!$res) {
                session()->flash('error', 'Something went wrong');
                return redirect()->back();
            }

            DB::commit();
            session()->flash('success', 'File uploaded and processed successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'An error occurred: ' . $th->getMessage());
            return redirect()->back();
        }
    }

    public function createTID(array $dataset)
    {
        try {
            $_query = $this->activeQuery();

            $data = [
                'storeID' => $dataset["storeID"],
                'openingDt' => null,
                'oldRetekCode' => $dataset["oldRetekCode"],
                'newRetekCode' => $dataset["newRetekCode"],
                'Status' => $dataset["Status"],
                'closureDate' => $dataset["closureDate"] ?: NULL,
                'conversionDt' => $dataset["conversionDt"] ?: NULL,
            ];

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
            $res = $_query->insert([...$data]);

            if (!$res) {
                session()->flash('error', 'Something went wrong!');
                return redirect()->back();
            }

            DB::commit();
            session()->flash('success', "TID Created");
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function uploadFile()
    {
        if (!$this->importFile) {
            session()->flash('error', 'No file selected.');
            return redirect()->back();
        }

        $filename = $this->importFile->store('tid-mid-master');
        $file_path = storage_path('app/public/' . $filename);

        $sheet = $this->reader($file_path);
        $this->headers = $sheet[1];
        unset($sheet[1]);

        $index = 1;
        foreach ($sheet as $item) {
            $data = $this->withHeaders($this->headers, $item);

            if (!$this->validateArray(data: $data, rowNum: $index)) {
                return redirect()->back();
            }

            $status = $this->uploadExcelValidatedArray($data, $filename);
            if (!$status) {
                session()->flash('error', "File: Upload failed on row #$index");
                return redirect()->back();
            }

            $index++;
        }

        session()->flash('success', 'File uploaded and processed successfully');
        return redirect()->back();
    }

    public function getFiles(Request $request)
    {
        // Your code here
        dd($request->toArray());
    }
}
