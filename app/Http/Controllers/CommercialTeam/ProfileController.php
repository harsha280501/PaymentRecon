<?php

namespace App\Http\Controllers\CommercialTeam;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\GeneralService;

use Illuminate\Foundation\Http\FormRequest;

class ProfileController extends Controller {



    /**
     * Process
     * @return \Illuminate\View\View
     */
    public function index(): View {
        return view('app.commercial-team.profile.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'brandAndStore' => (new GeneralService)->brandAndStore()
        ]);
    }




    public function changePassword(Request $request) {

        //dd($request->all());

        $validator = Validator::make($request->all(), [
            'oldpassword' => 'required|min:6',
            'password' => 'required|min:6|confirmed',

        ]);

        if ($validator->fails()) {
            return redirect(url()->previous())
                ->withErrors($validator)
                ->withInput();
        } else {

            try {

                DB::beginTransaction(); //auth()->user()->userUID           

                $currentPasswordStatus = Hash::check($request->oldpassword, auth()->user()->password);
                if ($currentPasswordStatus) {

                    $user = User::findOrFail(auth()->user()->userUID);
                    $user->password = Hash::make($request->password);
                    $user->save();

                    DB::commit();

                    return redirect()->back()->with('message', 'Password Updated Successfully');

                } else {

                    return redirect()->back()->with('message', 'Current Password does not match with Old Password');
                }

            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json(['message' => $th->getMessage()], 500);
            }
        }
    }





}