<?php

use App\Http\Controllers\Administrator\HomeController;
use App\Http\Controllers\Administrator\ProcessController;
use App\Http\Controllers\Administrator\ReportsController;
use App\Http\Controllers\Administrator\RepositoryController;
use App\Http\Controllers\Administrator\SettingsController;
use App\Http\Controllers\Administrator\TrackerController;
use App\Http\Controllers\Administrator\Upload\AxisController;
use App\Http\Controllers\Administrator\Upload\HDFCController;
use App\Http\Controllers\Administrator\Upload\ICICIController;
use App\Http\Controllers\Administrator\Upload\SBIController;
use App\Http\Controllers\Administrator\UploadsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {

    // Commertial Team Dashboard Routes
    Route::controller(HomeController::class)->group(function () {
        Route::prefix('dashboard')->group(function () {
            Route::get('/', 'index');
        });
        Route::post('logout', 'logout');
    });

    // Commertial Team Dashboard Routes
    Route::prefix('process')->group(function () {
        Route::get('/', [ProcessController::class, 'index']);
    });


    Route::controller(TrackerController::class)->group(function () {
        Route::get('tracker', 'index');
        Route::get('daywisereconciliation', 'daywiseRecon');
        Route::get('cashreconcil', 'cashRecon');
        Route::get('cardreconcil', 'cardRecon');
        Route::get('walletreconcil', 'walletRecon');
        Route::get('mpos-reconcil', 'MposRecon');
    });


    Route::controller(ReportsController::class)->group(function () {

        Route::get('mpos', 'mpos');
        Route::get('sap', 'sap');
        Route::get('bankmis', 'BankMis');

        // reports group
        Route::prefix('reports')->group(function () {
            Route::get('/', 'index');
            Route::get('bank-statement', 'bankStatement');
            Route::get('uploads', 'uploads');
        });
    });





    Route::prefix('upload')->group(function () {
        Route::get('/', [UploadsController::class, 'index']);

        // Post data routes
        Route::post('add-hdfc-upidata', [HDFCController::class, 'importHdfcUPIData']);
        Route::post('add-hdfc-carddata', [HDFCController::class, 'importHdfcCardData']);
        Route::post('add-hdfc-cashdata', [HDFCController::class, 'importHdfcCashData']);
        Route::post('cash/icici', [ICICIController::class, 'ICICIUpload']);
        Route::post('card/icici', [ICICIController::class, 'ICICIcardUpload']);
        Route::post('add-sbi-cash', [SBIController::class, 'importSBICashData']);
        Route::post('add-sbi-card', [SBIController::class, 'importSBICardData']);
        Route::post('add-axis-cash', [AxisController::class, 'importAxisCashData']);

        Route::controller(UploadsController::class)->group(function () {
            Route::get('bankmisrepository', 'bankMISRepository');
        });
    });



    Route::prefix('settings')->group(function () {

        Route::controller(SettingsController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('storemaster', 'storeMaster');
            Route::get('tid-mid-master', 'TidMidMaster');
            Route::post('/addstoremaster', 'Addstoremaster');
            Route::post('amexmid/{id}', 'Amexmid');
            Route::post('icicimid/{id}', 'Icicimid');
            Route::post('sbimid/{id}', 'Sbimid');
            Route::post('hdfctid/{id}', 'Hdfctid');
            Route::post('addamex', 'Addamex');
            Route::post('addicici', 'Addicici');
            Route::post('addsbi', 'Addsbi');
            Route::post('addhdfc', 'Addhdfc');
        });
    });


    // Repository Routes
    Route::prefix('repository')->group(function () {
        Route::controller(RepositoryController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('upload', 'repositoryImport');
        });
    });


    Route::prefix('bank-statement-upload')->group(function () {
        Route::get('/', [UploadsController::class, 'bankStatements']);
    });
    Route::prefix('bankmisrepository')->group(function () {
        Route::get('/', [UploadsController::class, 'bankMISRepository']);
    });
});