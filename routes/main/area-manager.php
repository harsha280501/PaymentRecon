<?php

use App\Http\Controllers\AreaManager\ReportsController;
use App\Http\Controllers\AreaManager\Repository\RepositoryController;
use App\Http\Controllers\AreaManager\SettingsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AreaManager\TrackerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/** @var
 * Configuration
 */
$areaManagerRoutesConfiguration = [
    'namespace' => 'App\Http\Controllers\AreaManager',
    'middleware' => ['auth', 'area-manager'],
    'prefix' => 'amanager/',
    'controller' => "AreaManagerController",
    "as" => 'area-manager.',
];


Route::group($areaManagerRoutesConfiguration, function () {
    Route::get('/dashboard', 'index');
    Route::get('/process', 'process');
    Route::post('/repository/upload', [RepositoryController::class, 'repositoryImport']);
    Route::get('/repository', 'repository');
    Route::get('/settings', 'settings');
    // logout routes
    Route::post('/logout', 'logout');
});


Route::middleware(['auth', 'area-manager'])->prefix('amanager')->as('area-manager.')->group(function () {

    Route::controller(TrackerController::class)->prefix('tracker')->group(function () {
        Route::get('/', 'index');
        Route::get('daywisereconciliation', 'daywiseRecon');
        Route::get('cashreconcil', 'cashRecon');
        Route::get('cardreconcil', 'cardRecon');
        Route::get('walletreconcil', 'walletRecon');
        Route::get('mpos-reconcil', 'MposRecon');
    });

    Route::controller(ReportsController::class)->group(function () {
        Route::get('/reports', 'index');
        Route::get('/mpos', 'mpos');
        Route::get('/sap', 'sap');
        Route::get('/bank-mis', 'bankmis');
        Route::get('/bank-statement', 'bankStatement');
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
});