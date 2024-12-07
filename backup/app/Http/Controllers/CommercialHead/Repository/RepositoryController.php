<?php

namespace App\Http\Controllers\CommercialHead\Repository;

use App\Http\Controllers\Controller;

// Request

use Illuminate\Http\Request;
use App\Http\Requests\CommercialHead\RepositoryImportRequest;


// Response

use Illuminate\Http\RedirectResponse;

// Model

use App\Models\MRepository;

// Exception

use Exception;

// Services

use App\Services\GeneralService;

// Others

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Log;




class RepositoryController extends Controller {


    /**
     * Index
     */
    public function index(): View {
        $repositorylist = MRepository::where('isActive', 1)->distinct('importDate')->get();

        return view('app.commercial-head.repository.index', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
            'repositorylist' => $repositorylist,
            'brandAndStore' => (new GeneralService)->brandAndStore(),
        ]);
    }


    /**
     * Reposttory
     * @return \Illuminate\View\View
     */
    public function repository(): View {
        return view('pages.comming-soon-chead', [
            'menus' => (new GeneralService)->menus(),
            'tabs' => (new GeneralService)->tabs(),
        ]);
    }



    public function repositoryImport(Request $request) {
        try {
            // Retrieve the uploaded file
            //$file = $request->file('repositoryFileUpload');
            $request->validate([
                'repositoryFileUpload' => 'required|mimes:csv,xls,xlsx,doc,docx,PDF,pdf|max:9048',
                'dateImport' => 'required|date_format:Y-m-d'
            ]);

            $file = $request->file('repositoryFileUpload');

            $destinationPath = storage_path('app/public/commercial/repository');
            $getorinilfilename = $file->getClientOriginalName();
            $file_1_name = $getorinilfilename . "_" . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);

            $userId = Auth::id();

            $MRepository = new MRepository;

            $MRepository->importDate = $request->dateImport;
            $MRepository->fileName = $file_1_name;
            $MRepository->isActive = 1;
            $MRepository->createdBy = $userId;
            $MRepository->save();

            return response()->json(['message' => 'Success'], 200);


        } catch (\Throwable $exception) {
            return response()->json(["message" => $exception->getMessage()]);
        }
    }




}
