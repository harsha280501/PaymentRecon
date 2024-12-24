<?php

namespace App\Http\Controllers\CommercialHead;

use Exception;
use App\Models\MSBIMID;
use App\Models\MAmexMID;
use App\Models\MHDFCTID;
use App\Models\MICICIMID;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TidMidController extends Controller {



    public function amexSave(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);


        try {

            $file = $request->file('file');

            $destinationPath = storage_path('app/public/Upload/TIDMIDMaster/AMEX/');
            $getorinilfilename = $file->getClientOriginalName();
            $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);

            return response()->json(['message' => 'Success'], 200);
        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }




    public function hdfcSave(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);


        try {

            $file = $request->file('file');

            $destinationPath = storage_path('app/public/Upload/TIDMIDMaster/HDFC/');
            $getorinilfilename = $file->getClientOriginalName();
            $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);

            return response()->json(['message' => 'Success'], 200);
        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }



    public function iciciSave(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);


        try {

            $file = $request->file('file');

            $destinationPath = storage_path('app/public/Upload/TIDMIDMaster/ICICI/');
            $getorinilfilename = $file->getClientOriginalName();
            $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);

            return response()->json(['message' => 'Success'], 200);
        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }




    public function sbiSave(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        try {

            $file = $request->file('file');

            $destinationPath = storage_path('app/public/Upload/TIDMIDMaster/SBI/');
            $getorinilfilename = $file->getClientOriginalName();
            $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);

            return response()->json(['message' => 'Success'], 200);
        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }


    public function amexImport(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        try {
           
            $file = $request->file('file');

            $destinationPath = storage_path('app/public/commercial/setting/amex/');
            $getorinilfilename = $file->getClientOriginalName();
            $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/commercial/setting/amex/') . $file_1_name;
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet
            DB::statement('InsertDataIntoDynamicTable :proctype', [
                "proctype" => 'AmexMID'
            ]);
            for ($i = 2; $i <= $arrayCount; $i++) {

                $input_file_name = $request->file('file')->getClientOriginalName();
                $fileName = pathinfo($input_file_name, PATHINFO_FILENAME);
                $namearr = explode("_", $fileName);
                if (count($namearr) > 1) {
                    $acct_no = $namearr[0];
                }
                if (count($namearr) == 1) {
                    $namearr = explode("_", $fileName);
                    $acct_no = $namearr[0];
                }

                $mid = trim(str_replace("'", '', $worksheet[$i]["A"]));
                $sapcode = trim(str_replace("'", '', $worksheet[$i]["B"]));
                $storecode = trim(str_replace("'", '', $worksheet[$i]["C"]));
                $newretekcode = trim(str_replace("'", '', $worksheet[$i]["D"]));
                $oldretekcode = trim(str_replace("'", '', $worksheet[$i]["E"]));
                $brandname = trim(str_replace("'", '', $worksheet[$i]["F"]));
                $openingDate = $worksheet[$i]['G'] ? Carbon::parse(trim($worksheet[$i]['G']))->format('Y-m-d') : null;
                $closuredate = $worksheet[$i]['H'] ? Carbon::parse(trim($worksheet[$i]['H']))->format('Y-m-d') : null;
                $conversionDt = $worksheet[$i]['I'] ? Carbon::parse(trim($worksheet[$i]['I']))->format('Y-m-d') : null;
                $status = trim(str_replace("'", '', $worksheet[$i]["J"]));
                $pos = trim(str_replace("'", '', isset($worksheet[$i]["K"]) ? $worksheet[$i]["K"] : null));
                $edc_service_provider = trim(str_replace("'", '', isset($worksheet[$i]["L"]) ? $worksheet[$i]["L"] : null));
                $revelance = trim(str_replace("'", '', isset($worksheet[$i]["M"]) ? $worksheet[$i]["M"] : null));

                $userId = Auth::id();
                
                $data = array(
                    "MID" => $mid,
                    "storeID" => $sapcode,
                    "newretekCode" => $newretekcode,
                    "oldretekCode" => $oldretekcode,
                    "brandName" => $brandname,
                    "Status" => $status,
                    "conversionDt" => $conversionDt,
                    "closureDate" => $closuredate,
                    "relevance" => $revelance,
                    "openingDt" => $openingDate,
                    "POS" => $pos,
                    "Store Code" => $storecode,
                    "EDCServiceProvider" => $edc_service_provider,
                    "filename" => $file_1_name,
                    "createdBy" => $userId,
                    "isActive" => 1
                );

                $attributes = [
                    "MID" => $mid,
                    "storeID" => $sapcode,
                    "newretekCode" => $newretekcode,
                    "Store Code" => $storecode,
                ];
                
                
                
                MAmexMID::updateOrInsert($attributes, $data);
            }


            return response()->json(['message' => 'Success'], 200);
        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }



    public function sbiImport(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        try {


            $file = $request->file('file');

            // Load the Excel file using PhpSpreadsheet
            $destinationPath = storage_path('app/public/commercial/setting/sbi/');
            $getorinilfilename = $file->getClientOriginalName();
            $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/commercial/setting/sbi/') . $file_1_name;
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet
            DB::statement('InsertDataIntoDynamicTable :proctype', [
                "proctype" => 'SbiMID'
            ]);
            for ($i = 2; $i <= $arrayCount; $i++) {

                $input_file_name = $request->file('file')->getClientOriginalName();
                $fileName = pathinfo($input_file_name, PATHINFO_FILENAME);
                $namearr = explode("_", $fileName);
                if (count($namearr) > 1) {
                    $acct_no = $namearr[0];
                }

                if (count($namearr) == 1) {
                    $namearr = explode("_", $fileName);
                    $acct_no = $namearr[0];
                }


                $mid = trim(str_replace("'", '', $worksheet[$i]["A"]));
                $sapcode = trim(str_replace("'", '', $worksheet[$i]["B"]));

                $storecode = null;
                if (is_null($worksheet[$i]["C"])) {
                    $storecode = trim(str_replace("'", '', $worksheet[$i]["C"]));
                }

                // New Retek code
                if (trim($worksheet[$i]["D"] == "NA") || empty(trim($worksheet[$i]["D"]))) {
                    $newretekcode = '0';
                } else {
                    $newretekcode = trim(str_replace("'", '', $worksheet[$i]["D"])); // NEW RETEK CODE
                }


                if (trim($worksheet[$i]["E"] == "NA") || empty(trim($worksheet[$i]["E"]))) {
                    $oldretekcode = '0';
                } else {
                    $oldretekcode = trim(str_replace("'", '', $worksheet[$i]["E"])); // OLD RETEK CODE
                }

                if (trim($worksheet[$i]["F"] == "NA") || empty(trim($worksheet[$i]["F"]))) {
                    $brandname = '0';
                } else {
                    $brandname = trim(str_replace("'", '', $worksheet[$i]["F"])); // BREAND NAME
                }

                $openingDate = $worksheet[$i]['G'] ? Carbon::parse(trim($worksheet[$i]['G']))->format('Y-m-d') : null;
                $closuredate = $worksheet[$i]['H'] ? Carbon::parse(trim($worksheet[$i]['H']))->format('Y-m-d') : null;
                $conversionDt = $worksheet[$i]['I'] ? Carbon::parse(trim($worksheet[$i]['I']))->format('Y-m-d') : null;
                $status = trim(str_replace("'", '', $worksheet[$i]["J"]));
                $pos = trim(str_replace("'", '', isset($worksheet[$i]["K"]) ? $worksheet[$i]["K"] : null));
                $edc_service_provider = trim(str_replace("'", '', isset($worksheet[$i]["L"]) ? $worksheet[$i]["L"] : null));
                $revelance = trim(str_replace("'", '', isset($worksheet[$i]["M"]) ? $worksheet[$i]["M"] : null));

                $userId = Auth::id();

                $data = array(
                    "MID" => $mid,
                    "storeID" => $sapcode,
                    "newretekCode" => $newretekcode,
                    "oldretekCode" => $oldretekcode,
                    "openingDt" => $openingDate,
                    "brandName" => $brandname,
                    "Status" => $status,
                    "conversionDt" => $conversionDt, //date of conversion
                    "closureDate" => $closuredate,
                    "relevance" => $revelance,
                    "POS" => $pos,
                    "Store Code" => $storecode,
                    "EDCServiceProvider" => $edc_service_provider,
                    "filename" => $file_1_name,
                    "createdBy" => $userId,
                    "isActive" => 1
                );

                $attributes = [
                    "MID" => $mid,
                    "storeID" => $sapcode,
                    "newretekCode" => $newretekcode,
                    "Store Code" => $storecode
                ];

                

                MSBIMID::updateOrInsert($attributes, $data);
            }

            return response()->json(['message' => 'Success'], 200);
        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function iciciImport(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        try {

            $file = $request->file('file');

            $destinationPath = storage_path('app/public/commercial/setting/icici/');
            $getorinilfilename = $file->getClientOriginalName();
            $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/commercial/setting/icici/') . $file_1_name;
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet
            DB::statement('InsertDataIntoDynamicTable :proctype', [
                "proctype" => 'IciciMID'
            ]);
            for ($i = 2; $i <= $arrayCount; $i++) {


                //  $col_bank =config('constants.AMEX.cardBankName'); // bankName

                $input_file_name = $request->file('file')->getClientOriginalName();
                $fileName = pathinfo($input_file_name, PATHINFO_FILENAME);
                $namearr = explode("_", $fileName);
                if (count($namearr) > 1) {
                    $acct_no = $namearr[0];
                }
                if (count($namearr) == 1) {
                    $namearr = explode("_", $fileName);
                    $acct_no = $namearr[0];
                }


                $mid = trim(str_replace("'", '', $worksheet[$i]["A"]));
                $sapcode = trim(str_replace("'", '', $worksheet[$i]["B"]));

                $storecode = 0;
                $newretekcode = 0;
                $oldretekcode = 0;

                if (is_numeric(trim($worksheet[$i]["C"]))) {
                    $storecode = trim(str_replace("'", '', $worksheet[$i]["C"]));
                }


                if (is_numeric(trim($worksheet[$i]["D"]))) {
                    $newretekcode = trim(str_replace("'", '', $worksheet[$i]["D"]));
                }


                if (is_numeric(trim($worksheet[$i]["E"]))) {
                    $oldretekcode = trim(str_replace("'", '', $worksheet[$i]["E"]));
                }

                $brandcode = trim(str_replace("'", '', $worksheet[$i]["F"]));
                $openingDate = $worksheet[$i]['G'] ? Carbon::parse(trim($worksheet[$i]['G']))->format('Y-m-d') : null;
                $closuredate = $worksheet[$i]['H'] ? Carbon::parse(trim($worksheet[$i]['H']))->format('Y-m-d') : null;
                $conversionDt = $worksheet[$i]['I'] ? Carbon::parse(trim($worksheet[$i]['I']))->format('Y-m-d') : null;
                $status = trim(str_replace("'", '', $worksheet[$i]["J"]));
                $pos = trim(str_replace("'", '', isset($worksheet[$i]["K"]) ? $worksheet[$i]["K"] : null));
                $edc_service_provider = trim(str_replace("'", '', isset($worksheet[$i]["L"]) ? $worksheet[$i]["L"] : null));
                $revelance = trim(str_replace("'", '', isset($worksheet[$i]["M"]) ? $worksheet[$i]["M"] : null));




                $userId = Auth::id();

                $data = array(
                    "MID" => $mid,
                    "storeID" => $sapcode,
                    "newretekCode" => $newretekcode,
                    "oldretekCode" => $oldretekcode,
                    "brandCode" => $brandcode,
                    "Status" => $status,
                    "openingDt" => $openingDate,
                    "conversionDt" => $conversionDt, //date of conversion
                    "closureDate" => $closuredate,
                    "relevance" => $revelance,
                    "POS" => $pos,
                    "Store Code" => $storecode,
                    "EDCServiceProvider" => $edc_service_provider,
                    "filename" => $file_1_name,
                    "createdBy" => $userId,
                    "isActive" => 1
                );

                $attributes = [
                    "MID" => $mid,
                    "storeID" => $sapcode,
                    "newretekCode" => $newretekcode,
                    "Store Code" => $storecode,
                ];

               

                MICICIMID::updateOrInsert($attributes, $data);
            }


            return response()->json(['message' => 'Success'], 200);
        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function hdfcImport(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx,XLS,txt|max:9048'
        ]);

        try {

            $file = $request->file('file');

            $destinationPath = storage_path('app/public/commercial/setting/hdfc/');
            $getorinilfilename = $file->getClientOriginalName();
            $file_1_name = $getorinilfilename . "_" . Carbon::now()->format('d-m-Y') . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);
            $targetPath = storage_path('app/public/commercial/setting/hdfc/') . $file_1_name;
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $arrayCount = count($worksheet); // Here get total count of row in that Excel sheet

            DB::statement('InsertDataIntoDynamicTable :proctype', [
                "proctype" => 'HdfcTID'
            ]);
            for ($i = 2; $i <= $arrayCount; $i++) {

                $input_file_name = $request->file('file')->getClientOriginalName();
                $fileName = pathinfo($input_file_name, PATHINFO_FILENAME);
                $namearr = explode("_", $fileName);

                if (count($namearr) > 1) {
                    $acct_no = $namearr[0];
                }
                if (count($namearr) == 1) {
                    $namearr = explode("_", $fileName);
                    $acct_no = $namearr[0];
                }

                $tid = trim(str_replace("'", '', $worksheet[$i]["A"]));
                $sapcode = null;
                if (is_numeric($worksheet[$i]["B"])) {
                    $sapcode = trim(str_replace("'", '', $worksheet[$i]["B"]));
                }


                if (trim($worksheet[$i]["C"] == "NA") || empty(trim($worksheet[$i]["C"])) || !is_numeric(trim($worksheet[$i]["C"] == "NA"))) {
                    $storecode = '0';
                } else {
                    $storecode = trim(str_replace("'", '', $worksheet[$i]["C"])); // BREAND NAME
                }


                if (trim($worksheet[$i]["D"] == "NA") || empty(trim($worksheet[$i]["D"]))) {
                    $newretekcode = '0';
                } else {
                    $newretekcode = trim(str_replace("'", '', $worksheet[$i]["D"])); // new RETEK CODE
                }


                if (trim($worksheet[$i]["E"] == "NA") || empty(trim($worksheet[$i]["E"]))) {
                    $oldretekcode = '0';
                } else {
                    $oldretekcode = trim(str_replace("'", '', $worksheet[$i]["E"])); // old RETEK CODE
                }


                if (trim($worksheet[$i]["F"] == "NA") || empty(trim($worksheet[$i]["F"]))) {
                    $brandname = '0';
                } else {
                    $brandname = trim(str_replace("'", '', $worksheet[$i]["F"])); // BREAND NAME
                }


                // dd(trim($worksheet[$i]["G"]), trim($worksheet[$i]["H"]), trim($worksheet[$i]["I"]));
                // $openingDate = $worksheet[$i]['G'] ? Carbon::parse(trim($worksheet[$i]['G']))->format('Y-m-d') : null;

                $openingDate = null;

                if (!empty(trim($worksheet[$i]["G"]))) {
                    // $openingDate = preg_replace('/[_\/\.\s]+/', '-', $worksheet[$i]["G"]);
                    // $openingDate = strtotime($openingDate);
                    // $openingDate = date('Y-m-d', $openingDate);
                    $openingDate = Carbon::parse(trim($worksheet[$i]['G']))->format('Y-m-d');
                }


                $closuredate = null;

                if (!empty(trim($worksheet[$i]["H"]))) {
                    // $closuredate = preg_replace('/[_\/\.\s]+/', '-', $worksheet[$i]["H"]);
                    // $closuredate = strtotime($closuredate);
                    // $closuredate = date('Y-m-d', $closuredate);
                    $closuredate = Carbon::parse(trim($worksheet[$i]['H']))->format('Y-m-d');
                }


                $conversionDt = null;

                if (!empty(trim($worksheet[$i]["I"]))) {
                    // $conversionDt = preg_replace('/[_\/\.\s]+/', '-', $worksheet[$i]["I"]);
                    // $conversionDt = strtotime($conversionDt);
                    // $conversionDt = date('Y-m-d', $conversionDt);
                    $conversionDt = Carbon::parse(trim($worksheet[$i]['I']))->format('Y-m-d');
                }

                $status = trim(str_replace("'", '', $worksheet[$i]["J"]));
                $pos = trim(str_replace("'", '', isset($worksheet[$i]["K"]) ? $worksheet[$i]["K"] : null));
                $edc_service_provider = trim(str_replace("'", '', isset($worksheet[$i]["L"]) ? $worksheet[$i]["L"] : null));
                $revelance = trim(str_replace("'", '', isset($worksheet[$i]["M"]) ? $worksheet[$i]["M"] : null));

                $edc_service_provider = trim(str_replace("'", '', $worksheet[$i]["K"])); // Edc Service provider

                $userId = Auth::id();

                $data = array(
                    "TID" => $tid,
                    "storeID" => $sapcode,
                    "newretekCode" => $newretekcode,
                    "oldretekCode" => $oldretekcode,
                    "brandName" => $brandname,
                    "Status" => $status,
                    "conversionDt" => $conversionDt, //date of conversion
                    "closureDate" => $closuredate,
                    "openingDt" => $openingDate,
                    "relevance" => $revelance,
                    "POS" => $pos,
                    "Store Code" => $storecode,
                    "EDCServiceProvider" => $edc_service_provider,
                    "filename" => $file_1_name,
                    "createdBy" => $userId,
                    "isActive" => 1
                );

                $attributes = [
                    "TID" => $tid,
                    "storeID" => $sapcode,
                    "newretekCode" => $newretekcode,
                    "Store Code" => $storecode,
                ];
                MHDFCTID::updateOrInsert($attributes, $data);
            }

            return response()->json(['message' => 'Success'], 200);
        } catch (\Throwable $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
