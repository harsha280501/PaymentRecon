<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\UpdateApis\PickupPTController;
use App\Http\Controllers\API\UpdateApis\UpdateRetekCodeController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/allbankmisinsert', [ApiController::class, 'AllBankMisInsert']);
Route::post('/insertsalescashreco', [ApiController::class, 'insertSalesCashReco']);

//27/07/23
Route::post('/allbankmisinsertcard', [ApiController::class, 'AllBankMisInsertCard']);
Route::post('/insertsalescardreco', [ApiController::class, 'insertSalesCardReco']);

//Wallet
Route::post('/allwallertinsert', [ApiController::class, 'allWalletInsert']);
Route::post('/insertsaleswalletreco', [ApiController::class, 'insertSalesWalletReco']);
Route::post('/insertcashbankstementreco', [ApiController::class, 'insertCashBankStementReco']);
Route::post('/insertcardbankstementreco', [ApiController::class, 'insertCardBankStementReco']);

//25-09-2023
Route::post('/mposcashsalesreco', [ApiController::class, 'mposCashSalesReco']);
Route::post('/mposcardsalesreco', [ApiController::class, 'mposCardSalesReco']);
Route::post('/mposwalletsalesreco', [ApiController::class, 'mposSalesWalletReco']);

//26-09-2023
Route::post('truncatesalesrecotables', [ApiController::class, 'TruncateSalesRecoTables']);
Route::post('truncatebankstatementtables', [ApiController::class, 'TruncateBankStatementTables']);
Route::post('truncatempossalestables', [ApiController::class, 'TruncateMposSalesTables']);

Route::post('truncateallbanktables', [ApiController::class, 'TruncateAllBankTables']);
Route::post('truncateapprovaltables', [ApiController::class, 'TruncateApprovalTables']);

//27-09-2023

Route::post('truncateallbanktables', [ApiController::class, 'TruncateAllBankTables']);

Route::post('truncateapprovaltables', [ApiController::class, 'TruncateApprovalTables']);

/**
 * UpdateMain Dataset 12-10-2023
 */
Route::post('/update/pickup-code', PickupPTController::class);

// 13-10-2023
Route::post('/selectcash', [ApiController::class, 'SelectCash']);
Route::post('/selectwallet', [ApiController::class, 'SelectWallet']);
Route::post('/selectcard', [ApiController::class, 'SelectCard']);


Route::post('/mpostendercashsalesreco', [ApiController::class, 'mposTenderCashSalesReco']);
Route::post('/ad70ee390fed7465f65c472f79681293', \App\Http\Controllers\API\UpdateApis\TIDMIDController::class);
Route::post('/YXBpX3VwZGF0ZV9zYmlfYWdlbmN5', \App\Http\Controllers\API\UpdateApis\SBIUpdateController::class);
Route::post('/getfilecount', \App\Http\Controllers\API\SelectMISApi::class);
Route::post('/insert-cash-deposit', \App\Http\Controllers\API\UpdateApis\CashDepositController::class);
Route::post('/mailing-list', \App\Http\Controllers\API\MailingList::class);
Route::post('/store-missing-mailing-list', \App\Http\Controllers\API\StoreIDMissing::class);
Route::post('/storeidtransaction', [UpdateRetekCodeController::class, 'storeIDTransaction']);
Route::post('/salestableRetekcode', [UpdateRetekCodeController::class, 'SalestableRetekcode']);
Route::post('/brandmissingremarks', [UpdateRetekCodeController::class, 'BrandMissingRemarks']);
Route::post('/updateRetekcode ', [UpdateRetekCodeController::class, 'UpdateRetekcode']);
Route::post('/cashandrtgsneftDepositReco ', [UpdateRetekCodeController::class, 'CASHRGTSNEFT']);
Route::post('/truncateTables ', [UpdateRetekCodeController::class, 'TruncateTables']);
Route::post('/walletRecon ', [UpdateRetekCodeController::class, 'WalletRecon']);
Route::post('/cashRecon ', [UpdateRetekCodeController::class, 'CashRecon']);
Route::post('/allTenderRecon ', [UpdateRetekCodeController::class, 'AllTenderRecon']);
Route::post('/allbankcash ', [UpdateRetekCodeController::class, 'AllBankCash']);
Route::post('/allbankcard ', [UpdateRetekCodeController::class, 'AllBankCard']);
Route::post('/allwallet ', [UpdateRetekCodeController::class, 'AllWallet']);
Route::post('/cardRecon ', [UpdateRetekCodeController::class, 'CardRecon']);
Route::post('/insertnewstoreID ', [UpdateRetekCodeController::class, 'InsertnewStoreID']);
Route::post('/directdepositToStage ', [UpdateRetekCodeController::class, 'DirectDepositToStage']);
Route::post('/cashDepositToAllbankCash ', [UpdateRetekCodeController::class, 'CashDepositToAllbankCash']);
Route::post('/reconDate ', [UpdateRetekCodeController::class, 'ReconDate']);



// TODO: create allBankcash MIS insert

// Cash Reconciliation Dataset
Route::post('/f0a56bbc51aa0dd9c98910cc0207548640c1eef4bbf9a5473bbce690c534b32e', \App\Http\Controllers\API\CashReconciliation::class);
Route::post('/c582c31ff2c20f3fa75cb8729d23b66985c2e01ca7acdb82468d5dde093feecc', \App\Http\Controllers\API\AllBankCash::class);

