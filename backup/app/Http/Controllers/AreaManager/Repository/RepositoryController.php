<?php

namespace App\Http\Controllers\AreaManager\Repository;



// Request

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



// Model
use App\Models\MRepository;

// Exception

use Exception;

// Services

use App\Services\GeneralService;

// Others
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;





class RepositoryController extends Controller
{

    public function repositoryImport(Request $request)
    {
        try {

             $request->validate([
            'repositoryFileUpload' => 'required|mimes:csv,xls,xlsx,doc,docx,PDF,pdf|max:9048',
            'dateImport' => 'required|date_format:Y-m-d'
        ]);

             $file = $request->file('repositoryFileUpload');

            $destinationPath = storage_path('app/public/commercial/repository');
            $getorinilfilename= $file->getClientOriginalName();
            $file_1_name = $getorinilfilename."_".time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_1_name);

           $userId = Auth::id();

           $MRepository = new MRepository;

            $MRepository->importDate = $request->dateImport;
            $MRepository->fileName = $file_1_name;
            $MRepository->isActive = 1;
            $MRepository->createdBy = $userId;
            $MRepository->save();

            return response()->json(['message' => 'Success'], 200);


        } catch (CustomModelNotFoundException $exception) {
            return $exception->render($exception);
        }
    }




}
