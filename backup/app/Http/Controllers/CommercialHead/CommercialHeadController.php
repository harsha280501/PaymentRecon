<?php

namespace App\Http\Controllers\CommercialHead;

use App\Exports\MPOSExport;
use App\Exports\SAPExport;
use App\Exports\StoreUser\BankMisExport;
use App\Http\Controllers\Controller;
use App\Services\GeneralService;
use Carbon\Carbon;
use Exception;
use App\Models\MSBIMID;
use App\Models\MAmexMID;
use App\Models\MHDFCTID;
use App\Models\MICICIMID;
use App\Models\UserLog;
use Illuminate\View\View;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;


class CommercialHeadController extends Controller {
    /**
     * Index
     */
    public function index(): View {

        return view('app.commercial-head.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * Index
     */
    public function welcome(): View {

        return view('app.commercial-head.welcome', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    /**
     * Reports
     * @return \Illuminate\View\View
     */
    public function reports(): View {
        return view('app.commercial-head.reports.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    /**
     * MPOS
     * @return \Illuminate\View\View
     */
    public function mpos(): View {
        return view('app.commercial-head.reports.mpos', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    /**
     * SAP
     * @return \Illuminate\View\View
     */
    public function sap(): View {
        return view('app.commercial-head.reports.sap', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * BankMiss
     * @return \Illuminate\View\View
     */
    public function bankmis(): View {
        return view('app.commercial-head.reports.bank-mis', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    /**
     * Trackers
     * @return \Illuminate\View\View
     */
    public function tracker(): View {
        return view('app.commercial-head.tracker.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    /**
     * Upload
     * @return \Illuminate\View\View
     */
    public function upload(): View {
        return view('app.commercial-head.uploads', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }
    public function BankMisRepository(): View {
        return view('app.commercial-head.bankmis-repository.bank-mis-repository', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    public function BankStatementUpload() {

        return view('app.commercial-head.bank-statements-upload.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function MposRecon() {

        return view('app.commercial-head.tracker.mpos-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    public function SAPRecon() {

        return view('app.commercial-head.tracker.sap-reconciliation', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * Settings page for Admin
     * @return \Illuminate\View\View
     */
    public function settings(): View {
        return view('app.commercial-head.settings.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function StoreMaster(): View {
        return view('app.commercial-head.settings.store-master', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    public function TidMidMaster(): View {
        return view('app.commercial-head.settings.tid-mid-master', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    public function Amexmid(Request $request, string $id) {

        try {

            DB::beginTransaction();
            // creating a builder
            $builder = MAmexMID::where('amexMIDUID', $id);



            // updating the status manually
            $res = $builder->update([
                'MID' => $request->MID,
                'POS' => $request->POS,
                'storeID' => $request->storeID,
                'openingDt' => $request->openingDt,
                'newRetekCode' => $request->newRetekCode,
                'oldRetekCode' => $request->oldRetekCode,
                'conversionDt' => $request->conversionDt,
                'brandName' => $request->brandName,
                'Status' => $request->Status,
                'closureDate' => $request->closureDate,
                'relevance' => $request->relevance,
                'EDCServiceProvider' => $request->EDCServiceProvider
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
        // main return
        return response()->json(['message' => 'Success'], 200);
    }

    public function Icicimid(Request $request, string $id) {

        try {

            DB::beginTransaction();
            // creating a builder
            $builder = MICICIMID::where('iciciMIDUID', $id);


            // updating the status manually
            $builder->update([
                'MID' => $request->MID,
                'POS' => $request->POS,
                'storeID' => $request->storeID,
                'openingDt' => $request->openingDt,
                'newRetekCode' => $request->newRetekCode,
                'oldRetekCode' => $request->oldRetekCode,
                'conversionDt' => $request->conversionDt,
                'brandCode' => $request->brandCode,
                'status' => $request->status,
                'closureDate' => $request->closureDate,
                'relevance' => $request->relevance,
                'EDCServiceProvider' => $request->EDCServiceProvider
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
        // main return
        return response()->json(['message' => 'Success'], 200);
    }
    public function Sbimid(Request $request, string $id) {

        try {

            DB::beginTransaction();
            // creating a builder
            $builder = MSBIMID::where('sbiMIDUID', $id);



            // updating the status manually
            $builder->update([
                'MID' => $request->MID,
                'POS' => $request->POS,
                'storeID' => $request->storeID,
                'openingDt' => $request->openingDt,
                'newRetekCode' => $request->newRetekCode,
                'oldRetekCode' => $request->oldRetekCode,
                'conversionDt' => $request->conversionDt,
                'brandName' => $request->brandName,
                'status' => $request->status,
                'closureDate' => $request->closureDate,
                'relevance' => $request->relevance,
                'EDCServiceProvider' => $request->EDCServiceProvider
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
        // main return
        return response()->json(['message' => 'Success'], 200);
    }
    public function Hdfctid(Request $request, string $id) {

        try {

            DB::beginTransaction();
            // creating a builder
            $builder = MHDFCTID::where('hdfcTIDUID', $id);



            // updating the status manually
            $builder->update([
                'TID' => $request->TID,
                'POS' => $request->POS,
                'storeID' => $request->storeID,
                'openingDt' => $request->openingDt,
                'newRetekCode' => $request->newRetekCode,
                'oldRetekCode' => $request->oldRetekCode,
                'conversionDt' => $request->conversionDt,
                'brandName' => $request->brandName,
                'status' => $request->status,
                'closureDate' => $request->closureDate,
                'relevance' => $request->relevance,
                'EDCServiceProvider' => $request->EDCServiceProvider
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
        // main return
        return response()->json(['message' => 'Success'], 200);
    }

    public function Addamex(Request $request) {
        try {



            DB::beginTransaction();
            // Use the 'update' method to update the record
            $res = MAmexMID::insert([
                'MID' => $request->MID,
                'POS' => $request->POS,
                'storeID' => $request->storeID,
                'openingDt' => $request->openingDt,
                'oldRetekCode' => $request->oldRetekCode,
                'newRetekCode' => $request->newRetekCode,
                'brandName' => $request->brandName,
                'Status' => $request->Status,
                'closureDate' => $request->closureDate,
                'conversionDt' => $request->conversionDt,
                'relevance' => $request->relevance,
                'EDCServiceProvider' => $request->EDCServiceProvider
            ]);

            DB::commit();
            // dd($res);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

        // Return a success response
        return response()->json(['message' => 'Success'], 200);
    }

    public function Addicici(Request $request) {
        try {
            DB::beginTransaction();
            // Use the 'update' method to update the record
            $res = MICICIMID::insert([
                'MID' => $request->MID,
                'POS' => $request->POS,
                'storeID' => $request->storeID,
                'openingDt' => $request->openingDt,
                'oldRetekCode' => $request->oldRetekCode,
                'newRetekCode' => $request->newRetekCode,
                'brandCode' => $request->brandCode,
                'status' => $request->status,
                'closureDate' => $request->closureDate,
                'conversionDt' => $request->conversionDt,
                'relevance' => $request->relevance,
                'EDCServiceProvider' => $request->EDCServiceProvider
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

        // Return a success response
        return response()->json(['message' => 'Success'], 200);
    }
    public function Addsbi(Request $request) {
        try {
            DB::beginTransaction();


            // Assuming you have an 'amexMIDUID' field in the request
            $id = $request->input('sbiMIDUID');

            // Use the 'update' method to update the record
            MSBIMID::insert([
                'MID' => $request->MID,
                'POS' => $request->POS,
                'storeID' => $request->storeID,
                'openingDt' => $request->openingDt,
                'oldRetekCode' => $request->oldRetekCode,
                'newRetekCode' => $request->newRetekCode,
                'brandName' => $request->brandName,
                'status' => $request->status,
                'closureDate' => $request->closureDate,
                'conversionDt' => $request->conversionDt,
                'relevance' => $request->relevance,
                'EDCServiceProvider' => $request->EDCServiceProvider
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

        // Return a success response
        return response()->json(['message' => 'Success'], 200);
    }
    public function Addhdfc(Request $request) {
        try {
            DB::beginTransaction();

            $res = MHDFCTID::insert([
                'TID' => $request->TID,
                'POS' => $request->POS,
                'storeID' => $request->storeID,
                'openingDt' => $request->openingDt,
                'oldRetekCode' => $request->oldRetekCode,
                'newRetekCode' => $request->newRetekCode,
                'brandName' => $request->brandName,
                'status' => $request->status,
                'closureDate' => $request->closureDate,
                'conversionDt' => $request->conversionDt,
                'relevance' => $request->relevance,
                'EDCServiceProvider' => $request->EDCServiceProvider
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

        // Return a success response
        return response()->json(['message' => 'Success'], 200);
    }




    public function UploadStoreMaster(Request $request) {
        dd(1);
    }


    public function Addstoremaster(Request $request) {
        try {
            DB::beginTransaction();

            DB::table('tbl_mStore')
                ->updateOrInsert([
                    'MGP SAP code' => $request->input('MGPSAPcode'),
                    'Store ID' => $request->input('StoreID'),
                    'RETEK Code' => $request->input('RETEKCode'),
                    // 'OLD IO No' => $request->input('OLDIONo'),
                    // 'New IO No' => $request->input('NewIONo'),
                    'Brand Desc' => $request->input('BrandDesc'),
                    // 'Sub Brand' => $request->input('SubBrand'),
                    'StoreTypeasperBrand' => $request->input('StoreTypeasperBrand'),
                    'Channel' => $request->input('Channel'),
                    'Store Name' => $request->input('StoreName'),
                    'Store opening Date' => $request->input('StoreopeningDate'),
                    'SStatus' => $request->input('SStatus'),
                    // 'QTR' => $request->input('QTR'),
                    'Location' => $request->input('Location'),
                    'City' => $request->input('City'),
                    'State' => $request->input('State'),
                    'Address' => $request->input('Address'),
                    'Pin code' => $request->input('Pincode'),
                    // ' Located ' => $request->input('Located'),
                    // ' Store Area (Sq Feet)' => $request->input('StoreArea'),
                    'Region' => $request->input('Region'),
                    'Store Manager Name' => $request->input('StoreManagerName'),
                    'Contact no' => $request->input('Contactno'),
                    'Basement occupied (Y/No)' => $request->input('Basementoccupied'),
                    'ARM email id' => $request->input('ARMemailid'),
                    'RM email id' => $request->input('RMemailid'),
                    'NROM email id' => $request->input('NROMemailid'),
                    'RCM mail' => $request->input('RCMmail'),
                    'Correct store email id' => $request->input('Correctstoreemailid'),
                    'HO contact' => $request->input('HOcontact'),
                    'RD email id' => $request->input('RDemailid'),
                    // 'Pickup Bank' => $request->input('PickupBank')
                ]);



            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

        // Return a success response
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Bank Statement
     * @return \Illuminate\View\View
     */
    public function bankStatement(): View {

        return view('app.commercial-head.reports.bank-statement', [

            'menus' => (new GeneralService)->menus(),

            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);

    }


    /**
     * Logout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse {

        $user = auth()->user();

        UserLog::create([
            "userUID" => $user->userUID,
            'type' => 'LOGOUT',
            "logTime" => now(),
            "loginDuration" => null,
            "ipAddress" => $request->ip(),
            "isActive" => 1,
            "createdDate" => now(),
            "modifiedDate" => null,
            "createdBy" => '1',
        ]);


        // Logging the user out
        Auth::logout();
        // Clearing the menus
        Cache::forget('menus');
        // regenarate the session
        session()->regenerate();
        session()->regenerateToken();

        return redirect()->route('login');
    }
}
