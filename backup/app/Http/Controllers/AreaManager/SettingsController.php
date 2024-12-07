<?php

namespace App\Http\Controllers\AreaManager;

use App\Http\Controllers\Controller;
use App\Services\GeneralService;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SettingsController extends Controller {


    /**
     * Settings page for Admin
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('pages.comming-soon-cuser', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }

    /**
     * Settings page for Admin
     * @return \Illuminate\View\View
     */
    public function storeMaster(): View {
        return view('app.area-manager.settings.store-master', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function TidMidMaster(): View {
        return view('app.area-manager.settings.tid-mid-master', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }



    public function Addstoremaster(Request $request) {
        try {
            DB::beginTransaction();


            DB::table('tbl_mStore')
                ->insert([
                    'MGP SAP code' => $request->input('MGPSAPcode'),
                    'Store ID' => $request->input('StoreID'),
                    'RETEK Code' => $request->input('RETEKCode'),
                    'OLD IO No' => $request->input('OLDIONo'),
                    'New IO No' => $request->input('NewIONo'),
                    'Brand Desc' => $request->input('BrandDesc'),
                    'Sub Brand' => $request->input('SubBrand'),
                    'StoreTypeasperBrand' => $request->input('StoreTypeasperBrand'),
                    'Channel' => $request->input('Channel'),
                    'Store Name' => $request->input('StoreName'),
                    'Store opening Date' => $request->input('StoreopeningDate'),
                    'SStatus' => $request->input('SStatus'),
                    'QTR' => $request->input('QTR'),
                    'Location' => $request->input('Location'),
                    'City' => $request->input('City'),
                    'State' => $request->input('State'),
                    'Address' => $request->input('Address'),
                    'Pin code' => $request->input('Pincode'),
                    ' Located ' => $request->input('Located'),
                    ' Store Area (Sq Feet)' => $request->input('StoreArea'),
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
                    'Pickup Bank' => $request->input('PickupBank')
                ]);



            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

        // Return a success response
        return response()->json(['message' => 'Success'], 200);
    }



    public function Amexmid(Request $request, string $id) {

        try {

            DB::beginTransaction();
            // creating a builder
            $builder = DB::table('tbl_mAmex_MID')
                ->where('amexMIDUID', $id);

            // dd($request);

            // updating the status manually
            $builder->update([
                'MID' => $request->MID,
                'POS' => $request->POS,
                'sapCode' => $request->sapCode,
                'retekCode' => $request->retekCode,
                'brandName' => $request->brandName
            ]);

            DB::commit();
            // dd($res);


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
            $builder = DB::table('tbl_mIcici_MID')
                ->where('iciciMIDUID', $id);

            // updating the status manually
            $builder->update([
                'MID' => $request->MID,
                'POS' => $request->POS,
                'sapCode' => $request->sapCode,
                'retekCode' => $request->retekCode,
                'brandCode' => $request->brandCode
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
            $builder = DB::table('tbl_mSBI_MIS')
                ->where('sbiMIDUID', $id);


            // updating the status manually
            $builder->update([
                'MID' => $request->MID,
                'POS' => $request->POS,
                'sapCode' => $request->sapCode,
                'retekCode' => $request->retekCode,
                'brandName' => $request->brandName
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
            $builder = DB::table('tbl_mHdfc_TID')
                ->where('hdfcTIDUID', $id);


            // updating the status manually
            $builder->update([
                'TID' => $request->TID,
                'POS' => $request->POS,
                'sapCode' => $request->sapCode,
                'retekCode' => $request->retekCode,
                'brandName' => $request->brandName
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
            $res = DB::table('tbl_mAmex_MID')
                ->insert([
                    'MID' => $request->MID,
                    'POS' => $request->POS,
                    'sapCode' => $request->sapCode,
                    'retekCode' => $request->retekCode,
                    'brandName' => $request->brandName
                ]);

            DB::commit();
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
            DB::table('tbl_mIcici_MID')
                ->insert([
                    'MID' => $request->MID,
                    'POS' => $request->POS,
                    'sapCode' => $request->sapCode,
                    'retekCode' => $request->retekCode,
                    'brandCode' => $request->brandCode
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
            DB::table('tbl_mSBI_MIS')
                ->insert([
                    'MID' => $request->MID,
                    'POS' => $request->POS,
                    'sapCode' => $request->sapCode,
                    'retekCode' => $request->retekCode,
                    'brandName' => $request->brandName
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

            DB::table('tbl_mHdfc_TID')
                ->insert([
                    'TID' => $request->TID,
                    'POS' => $request->POS,
                    'sapCode' => $request->sapCode,
                    'retekCode' => $request->retekCode,
                    'brandName' => $request->brandName
                ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }

        // Return a success response
        return response()->json(['message' => 'Success'], 200);
    }

}