<?php

use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\CommercialHead\Tracker\OutstandingSummary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CommertialHead\CommertialHeadController;
use App\Http\Controllers\CommertialHead\Upload\HDFCController;
use App\Http\Controllers\CommertialHead\Process\ProcessViewController;
use App\Http\Livewire\Auth\ForceResetPassword;
use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\CommercialHead\Tracker\MposReconciliation;
use App\Http\Livewire\CommercialHead\Process\CardProcess;
use App\Http\Livewire\CommercialHead\Reports\BankMIS;




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

/**
 * Login
 */
Route::get('/', Login::class)
    ->name('login');


Route::get('forgot-password', ForgotPassword::class);
Route::post('forgot-password', ForgotPassword::class)->name('sendResetLink');
Route::get('reset-password/{token}', ResetPassword::class);
Route::post('reset-password', ResetPassword::class)->name('resetpassword');
Route::get('change-password/{token}', ForceResetPassword::class)->name('password.change')->middleware(['auth']);

/**
 * Logout
 */
Route::post('/logout', function () {

    Auth::logout();
    Cache::forget('menus');
    session()->regenerate();
    session()->regenerateToken();
    return redirect()->route('login');
})->middleware(['auth']);



require __DIR__ . '/main/admin.php';
require __DIR__ . '/main/area-manager.php';
require __DIR__ . '/main/commercial-head.php';
require __DIR__ . '/main/commercial-team.php';
require __DIR__ . '/main/store-user.php';


Route::post('/admin/adddata', [AdminController::class, 'AddData'])->name('/adddata');
//Route::post('/comertialHead/addaxisdata', [CommertialHeadController::class, 'AddAxisData'])->name('/addaxisdata');
//Route::post('/comertialHead/addicicidata', [CommertialHeadController::class, 'AddIciciData'])->name('/addicicidata');
//Route::post('/chead/add-hdfc-carddata', [HDFCController::class, 'importHdfcCardData'])->name('/addhdfccarddata');
//Route::post('/chead/add-hdfc-upidata', [HDFCController::class, 'importHdfcUPIData'])->name('/addhdfcupidata');

Route::get('/chead/processview/{id}', [ProcessViewController::class, 'processview']);

Route::get('/registration', [ProcessViewController::class, 'processview']);

Route::get('/search-brands', function () {
    $component = app(MposReconciliation::class);
    return response()->json($component->searchBrands(request('search')));
})->name('searchBrands');
Route::get('/search-stores', function () {
    $component = app(MposReconciliation::class);
    return response()->json($component->searchStores(request('search')));
})->name('searchStores');
Route::get('/search-locations', function () {
    $component = app(MposReconciliation::class);
    return response()->json($component->searchLocations(request('search')));
})->name('searchLocations');

Route::get('/recon-search/{type}', function ($type) {
    $component = app(CardProcess::class);
    $method = "search" . ucfirst($type);
    if (method_exists($component, $method)) {
        return response()->json($component->$method(request('search')));
    }
    abort(404, "Search type '{$type}' not found.");
})->name('reconSearch');

Route::get('/search-tid', [BankMIS::class, 'searchTid'])->name('tidSearch');
Route::get('/bankMIS-store-search', [BankMIS::class, 'searchStore'])->name('reports.bankMIS.searchStore');
Route::get('/OutstandingSummary-store-search', [OutstandingSummary::class, 'searchStore'])->name('tracker.outstanding-summary.searchStore');
