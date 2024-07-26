<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;
use App\Http\Controllers\Api\Admin\LoginController;
use App\Http\Controllers\Api\IlsController;
use App\Http\Controllers\Api\Admin\AuthController;

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

// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/register', [LoginController::class, 'register']);


// // Rute dengan middleware auth:sanctum
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [LoginController::class, 'logout']);
//     Route::post('/refresh', [LoginController::class, 'refresh']);
//     // Route::get('/ils', [IlsController::class, 'index']);
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });
// });


//Rute tanpa middleware
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);

// Rute dengan middleware auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
   // Route::get('/user', [LoginController::class, 'user']);
   // Route::get('/ils', [IlsController::class, 'index']);
    Route::post('/refresh', [LoginController::class, 'refresh']);
    Route::get('/user', function (Request $request) {
                 return $request->user();
             });
    

    
});





// //posts


//ils
Route::get('/ils', [\App\Http\Controllers\Api\IlsController::class, 'index']);
Route::get('/ilssp', [\App\Http\Controllers\Api\IlsController::class, 'getIlsPs']);
Route::get('/chart', [\App\Http\Controllers\Api\IlsController::class, 'getStatistics']);
Route::get('/late', [\App\Http\Controllers\Api\IlsController::class, 'getLate']);
Route::get('/unlate', [\App\Http\Controllers\Api\IlsController::class, 'getUnLate']);
//alertcash
Route::get('/alertcash', [\App\Http\Controllers\Api\AlertCashController::class, 'index']);
//receipt inbound
Route::get('/putaway', [\App\Http\Controllers\Api\PutAwayController::class, 'index']);
Route::get('/chartpa', [App\Http\Controllers\Api\PutAwayController::class, 'getStatistic']);
Route::get('/palate', [\App\Http\Controllers\Api\PutAwayController::class, 'getLate']);
Route::get('/paunlate', [\App\Http\Controllers\Api\PutAwayController::class, 'getUnLate']);
//delivstock
Route::get('/indelivestock', [\App\Http\Controllers\Api\IndelivstockController::class, 'index']);
Route::get('/indelivestocklate', [\App\Http\Controllers\Api\IndelivstockController::class, 'getlate']);
Route::get('/indelivestockunlate', [\App\Http\Controllers\Api\IndelivstockController::class, 'getunlate']);
Route::get('/chartds', [\App\Http\Controllers\Api\IndelivstockController::class, 'getStatistic']);

Route::get('/cashputstorage', [\App\Http\Controllers\Api\CashPutStorageController::class, 'index']);
Route::get('/cpslate', [\App\Http\Controllers\Api\CashPutStorageController::class, 'GetLate']);
Route::get('/cpsunlate', [\App\Http\Controllers\Api\CashPutStorageController::class, 'GetUnLate']);
Route::get('/chartcps', [\App\Http\Controllers\Api\CashPutStorageController::class, 'getStatistics']);

Route::get('/cpsv1', [App\Http\Controllers\Api\Cpsv2Controller::class, 'index']);

Route::get('/alertcasstorage', [\App\Http\Controllers\Api\AlertCashStorageController::class, 'index']);
Route::get('/alertcasstoragelate', [\App\Http\Controllers\Api\AlertCashStorageController::class, 'getLate']);
Route::get('/alertcasstorageunlate', [\App\Http\Controllers\Api\AlertCashStorageController::class, 'getUnLate']);
Route::get('/chartacs', [\App\Http\Controllers\Api\AlertCashStorageController::class, 'getStatistics']);

Route::get('/replenishment', [\App\Http\Controllers\Api\ReplanishmentController::class, 'index']);
Route::get('/replenishmentlate', [\App\Http\Controllers\Api\ReplanishmentController::class, 'getLate']);
Route::get('/replenishmentunlate', [\App\Http\Controllers\Api\ReplanishmentController::class, 'getUnlate']);
Route::get('/chartreplenishment', [\App\Http\Controllers\Api\ReplanishmentController::class, 'GetStatistic']);

Route::get('/dashinbound', [\App\Http\Controllers\Api\DashInboundController::class, 'index']);

Route::get('/dashboardstore', [\App\Http\Controllers\Api\DashboardStoreController::class, 'index']);

##inbound
##itrin
Route::get('/v2itrin', [\App\Http\Controllers\Api\Inbound\ItrInController::class, 'index']);
Route::get('/v2lateitrin', [\App\Http\Controllers\Api\Inbound\ItrInController::class, 'late']);
Route::get('/v2ontimeitrin', [\App\Http\Controllers\Api\Inbound\ItrInController::class, 'onTime']);
Route::get('/v2statisticitrin', [\App\Http\Controllers\Api\Inbound\ItrInController::class, 'getStatistic']);
##crossdock
Route::get('/v2crossdock', [\App\Http\Controllers\Api\Inbound\CrossdockController::class, 'index']);
Route::get('/v2latecrossdock', [\App\Http\Controllers\Api\Inbound\CrossdockController::class, 'late']);
Route::get('/v2statisticcrossdock', [\App\Http\Controllers\Api\Inbound\CrossdockController::class, 'getStatistic']);
##Po
Route::get('/v2po' ,[\App\Http\Controllers\Api\Inbound\PoController::class, 'index']);
Route::get('/v2latepo' ,[\App\Http\Controllers\Api\Inbound\PoController::class, 'late']);
Route::get('/v2statisticpo' ,[\App\Http\Controllers\Api\Inbound\PoController::class, 'getStatistic']);
##return
Route::get('/v2return', [\App\Http\Controllers\Api\Inbound\ReceiptReturnController::class, 'index']);
Route::get('/v2latereturn', [\App\Http\Controllers\Api\Inbound\ReceiptReturnController::class, 'late']);
Route::get('/v2statisticreturn', [\App\Http\Controllers\Api\Inbound\ReceiptReturnController::class, 'getStatistic']);

##storage
##cashpicking
Route::get('/v2cashpicking', [\App\Http\Controllers\Api\Storage\CashPickingController::class, 'index']);    
Route::get('/v2latecashpicking', [\App\Http\Controllers\Api\Storage\CashPickingController::class, 'late']);
Route::get('/v2statisticcashpicking', [\App\Http\Controllers\Api\Storage\CashPickingController::class, 'getStatistic']);
##deliverypicking
Route::get('/v2deliverypicking', [\App\Http\Controllers\Api\Storage\DeliveryPickingContoller::class, 'index']);
Route::get('/v2latedeliverypicking', [\App\Http\Controllers\Api\Storage\DeliveryPickingContoller::class, 'late']);
Route::get('/v2statisticdeliverypicking', [\App\Http\Controllers\Api\Storage\DeliveryPickingContoller::class, 'getStatistic']);
##putaway
Route::get('/v2putaway', [\App\Http\Controllers\Api\Storage\PutawayContoller::class, 'index']);
Route::get('/v2lateputaway', [\App\Http\Controllers\Api\Storage\PutawayContoller::class, 'late']);
Route::get('/v2statisticputaway', [\App\Http\Controllers\Api\Storage\PutawayContoller::class, 'getStatistic']);
##replenishment
Route::get('/v2replenishment', [\App\Http\Controllers\Api\Storage\ReplenishmentContoller::class, 'index']);
Route::get('/v2latereplenishment', [\App\Http\Controllers\Api\Storage\ReplenishmentContoller::class, 'late']);
Route::get('/v2statisticreplenishment', [\App\Http\Controllers\Api\Storage\ReplenishmentContoller::class, 'getStatistic']);

##outbound
#arreserve
Route::get('/v2arreserve', [\App\Http\Controllers\Api\Outbound\ArReserveController::class, 'index']);
Route::get('/v2latearreserve', [\App\Http\Controllers\Api\Outbound\ArReserveController::class, 'late']);
Route::get('/v2statisticarreserve', [\App\Http\Controllers\Api\Outbound\ArReserveController::class, 'getStatistic']);
##itrout
Route::get('/v2itrout', [\App\Http\Controllers\Api\Outbound\ItrOutController::class, 'index']);
Route::get('/v2lateitrout', [\App\Http\Controllers\Api\Outbound\ItrOutController::class, 'late']);
Route::get('/v2statisticitrout', [\App\Http\Controllers\Api\Outbound\ItrOutController::class, 'getStatistic']);
##salesorder
Route::get('/v2salesorder', [\App\Http\Controllers\Api\Outbound\SalesOrderController::class, 'index']);
Route::get('/v2latesalesorder', [\App\Http\Controllers\Api\Outbound\SalesOrderController::class, 'late']);
Route::get('/v2statisticsalesorder', [\App\Http\Controllers\Api\Outbound\SalesOrderController::class, 'getStatistic']);

