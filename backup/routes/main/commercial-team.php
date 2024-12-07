<?php

use App\Http\Controllers\CommercialTeam\BankStatementProcessController;
use App\Http\Controllers\CommercialTeam\DirectDepositController;
use App\Http\Controllers\CommercialTeam\HomeController;
use App\Http\Controllers\CommercialTeam\ProcessController;
use App\Http\Controllers\CommercialTeam\ReportsController;
use App\Http\Controllers\CommercialTeam\RepositoryController;
use App\Http\Controllers\CommercialTeam\SettingsController;
use App\Http\Controllers\CommercialTeam\TrackerController;
use App\Http\Controllers\CommercialTeam\Upload\AxisController;
use App\Http\Controllers\CommercialTeam\Upload\HDFCController;
use App\Http\Controllers\CommercialTeam\Upload\ICICIController;
use App\Http\Controllers\CommercialTeam\Upload\SBIController;
use App\Http\Controllers\CommercialTeam\UploadsController;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth', 'commertial-team', 'forceUpdatePassword'])->prefix('cuser')->as('commertial-team.')->group(function () {

    // Commertial Team Dashboard Routes
    Route::controller(HomeController::class)->group(function () {
        Route::prefix('dashboard')->group(function () {
            Route::get('/', 'index');
        });
        Route::get('/welcome', 'welcome');
        Route::post('logout', 'logout');
    });


    Route::controller(ProcessController::class)->prefix('process')->group(function () {
        Route::get('/', 'index');

        // crete a new record
        Route::prefix('cash-recon')->group(function () {
            Route::get('/', 'cashRecon');
            Route::post('create-main-mis/{id}', 'MposMisApproval');
        });

        // creating a new process
        Route::prefix('card-recon')->group(function () {
            Route::get('/', 'cardRecon');
            Route::post('update/{id}', 'CardMisApproval');
        });

        // creating a new process
        Route::prefix('upi-recon')->group(function () {
            Route::get('/', 'upiRecon');
            Route::post('update/{id}', 'UpiMisApproval');
        });

        // wallet process
        Route::prefix('wallet-recon')->group(function () {
            Route::get('/', 'walletRecon');
            Route::post('update/{id}', 'WalletMisApproval');
        });
    });


    
    Route::get('/direct-deposit', [DirectDepositController::class, 'index']);


    // * Updated
    Route::controller(BankStatementProcessController::class)->prefix('process')->group(function () {
        Route::prefix('bank-statement-recon')->group(function () {
            Route::get('/', 'index');
            // ? approval process
            Route::post('cash/create/{id}', 'cashReconUpload');
            Route::post('card/create/{id}', 'cardReconUpload');
            Route::post('wallet/create/{id}', 'walletReconUpload');
            Route::post('upi/create/{id}', 'UPIReconUpload');
        });
    });



    Route::prefix('tracker')->group(function () {
        Route::controller(TrackerController::class)->group(function () {
            // index route
            Route::get('/', 'index');
            Route::get('/cash-recon', 'MposRecon');
            Route::get('/card-recon', 'CardRecon');
            Route::get('/upi-recon', 'UPIRecon');
            Route::get('/wallet-recon', 'WalletRecon');
            Route::get('/all-card-recon', 'AllCardRecon');

            Route::get('/cash-recon-process', 'MposProcess');
            Route::get('/card-recon-process', 'CardProcess');
            Route::get('/wallet-recon-process', 'WalletProcess');
            Route::get('/bank-statement-process', 'BankStatementProcess');
            Route::get('reconciliationsummary', 'reconciliationSummary');
        });
    });

    /**
     * Reports
     */
    Route::prefix('reports')->group(function () {
        Route::controller(ReportsController::class)->group(function () {
            // index route
            Route::get('/', 'index');
            Route::get('mpos', 'mpos');
            Route::get('sap', 'sap');
            Route::get('bankmis', 'bankmis');
            Route::get('bankstatement', 'bankStatement');
            Route::get('/bank-statement-recon', 'bankStatementRecon');
            Route::get('recon-summary', 'reportsSummary');
            Route::get('others', 'others');
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
        Route::get('/', [SettingsController::class, 'index']);
        Route::get('storemaster', [SettingsController::class, 'storeMaster']);
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


});


Route::group(['middleware' => ['auth', 'commertial-team'], 'prefix' => 'cuser', 'namespace' => 'App\Http\Controllers\CommercialTeam'], function () {
    Route::get('/changepwd', 'ProfileController@index')->name('changepwd');
    Route::post('/changepwd', 'ProfileController@changePassword')->name('changepwd');
});