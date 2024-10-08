<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;
use App\Http\Controllers\Api\Admin\LoginController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\IlsController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Models\admin\User;

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
    Route::get('/getuser', [UserController::class, 'index']);
    Route::post('/createuser',[UserController::class, 'create']);
    Route::put('/updateuser/{id}',[UserController::class, 'update']);
    Route::delete('/deleteuser/{id}',[UserController::class, 'destroy']);
    Route::get('/getcurrentuser', [UserController::class, 'getCurrentUser']);
    Route::get('/userbranch', [UserController::class, 'userBranch']);
    //Route::put('/updateuser', [UserController::class, 'update']);

             Route::get('/v2po' ,[\App\Http\Controllers\Api\Inbound\PoController::class, 'index']);
             Route::get('/v2itrin', [\App\Http\Controllers\Api\Inbound\ItrInController::class, 'index']);
             Route::get('/v2return', [\App\Http\Controllers\Api\Inbound\ReceiptReturnController::class, 'index']);
             Route::get('/v2crossdock', [\App\Http\Controllers\Api\Inbound\CrossdockController::class, 'index']);
             Route::get('/v2cashpicking', [\App\Http\Controllers\Api\Storage\CashPickingController::class, 'index']);  
             Route::get('/v2deliverypicking', [\App\Http\Controllers\Api\Storage\DeliveryPickingContoller::class, 'index']); 
             Route::get('/v2putaway', [\App\Http\Controllers\Api\Storage\PutawayContoller::class, 'index']);
             Route::get('/v2replenishment', [\App\Http\Controllers\Api\Storage\ReplenishmentContoller::class, 'index']);
             Route::get('/v2listpicking', [\App\Http\Controllers\Api\Storage\ListPickingController::class,'index']);
             Route::get('/v2arreserve', [\App\Http\Controllers\Api\Outbound\ArReserveController::class, 'index']);
             Route::get('/v2itrout', [\App\Http\Controllers\Api\Outbound\ItrOutController::class, 'index']);
             Route::get('/v2salesorder', [\App\Http\Controllers\Api\Outbound\SalesOrderController::class, 'index']);
             Route::get('/v2outboundnotintgrated', [\App\Http\Controllers\Api\Outbound\NotIntegratedController::class, 'index']);


             Route::get('/kendaraan', [App\Http\Controllers\Api\Logistic\KendaraanController::class, 'index']);
             Route::get('/kendaraan/{id_kendaraan}', [App\Http\Controllers\Api\Logistic\KendaraanController::class, 'show']);
             Route::post('/kendaraan', [App\Http\Controllers\Api\Logistic\KendaraanController::class, 'store']);
             Route::put('/kendaraan/{id_kendaraan}', [App\Http\Controllers\Api\Logistic\KendaraanController::class, 'update']);
             Route::delete('/kendaraan/{id_kendaraan}', [App\Http\Controllers\Api\Logistic\KendaraanController::class, 'destroy']);
           //  Route::get('/logdoc', [App\Http\Controllers\Api\Logistic\LogisticDocUploadController::class, 'index']);
           // Route::resource('/kendaraan', App\Http\Controllers\Api\Logistic\KendaraanController::class, ['except' => ['create', 'show', 'edit', 'update'], 'as' => 'admin']);

           Route::get('/masterhour', [\App\Http\Controllers\Api\Logistic\MasterHourController::class, 'index']);
           Route::get('/masterhour/{id}', [\App\Http\Controllers\Api\Logistic\MasterHourController::class, 'show']);
           Route::post('/masterhour', [\App\Http\Controllers\Api\Logistic\MasterHourController::class, 'store']);
           Route::put('/masterhour/{id}', [\App\Http\Controllers\Api\Logistic\MasterHourController::class, 'update']);
           Route::delete('/masterhour/{id}', [\App\Http\Controllers\Api\Logistic\MasterHourController::class, 'destroy']);

            Route::get('/schedule', [\App\Http\Controllers\Api\Logistic\ScheduleController::class, 'index']);
            Route::get('/transaksireq', [\App\Http\Controllers\Api\Logistic\TransaksiRequestController::class, 'index']);
            Route::get('/transaksireq_jadwal/{id_jadwal}', [\App\Http\Controllers\Api\Logistic\TransaksiRequestController::class, 'showsechedule']);
            Route::get('/transaksireq/{id_req}', [\App\Http\Controllers\Api\Logistic\TransaksiRequestController::class, 'show']);
            Route::put('/transaksireq/{id_req}', [\App\Http\Controllers\Api\Logistic\TransaksiRequestController::class, 'update']);
            Route::put('/transaksireq_qr_inbound/{id_req}' ,[\App\Http\Controllers\Api\Logistic\TransaksiRequestController::class, 'updatescanqrCodeInbound']);
            Route::put('/transaksireq_qr_all/{id_req}' ,[\App\Http\Controllers\Api\Logistic\TransaksiRequestController::class, 'updateStatusScan']);
            Route::get('/logdoc',[\App\Http\Controllers\Api\Logistic\TransaksiRequestController::class, 'logdoc']);
            Route::get('/transaksilogdoc/{id_req}',[\App\Http\Controllers\Api\Logistic\TransaksiRequestController::class, 'sechedulelogdoc']);

            Route::get('/hour', [\App\Http\Controllers\Api\Logistic\MasterHourController::class, 'hour']);
            Route::post('/generate-schedule', [App\Http\Controllers\Api\Logistic\ScheduleController::class, 'generateSchedule']);
            Route::get('/branch', [\App\Http\Controllers\Api\Logistic\UserBranchControlller::class, 'index']);
    
});
Route::get('/transaksireq_qr', [\App\Http\Controllers\Api\Logistic\TransaksiRequestController::class, 'index']);
Route::put('/transaksireq_qr/{id_req}' ,[\App\Http\Controllers\Api\Logistic\TransaksiRequestController::class, 'updatescanqrCode']);
Route::get('/dashinbound', [\App\Http\Controllers\Api\DashInboundController::class, 'index']);
Route::get('/dashboardstore', [\App\Http\Controllers\Api\DashboardStoreController::class, 'index']);

##inbound
##itrin

Route::get('/v2lateitrin', [\App\Http\Controllers\Api\Inbound\ItrInController::class, 'late']);
Route::get('/v2ontimeitrin', [\App\Http\Controllers\Api\Inbound\ItrInController::class, 'onTime']);
Route::get('/v2statisticitrin', [\App\Http\Controllers\Api\Inbound\ItrInController::class, 'getStatistic']);
##crossdock

Route::get('/v2latecrossdock', [\App\Http\Controllers\Api\Inbound\CrossdockController::class, 'late']);
Route::get('/v2statisticcrossdock', [\App\Http\Controllers\Api\Inbound\CrossdockController::class, 'getStatistic']);
##Po

Route::get('/v2latepo' ,[\App\Http\Controllers\Api\Inbound\PoController::class, 'late']);
Route::get('/v2statisticpo' ,[\App\Http\Controllers\Api\Inbound\PoController::class, 'getStatistic']);
Route::get('/v2grpo', [\App\Http\Controllers\Api\Inbound\GoodReceiptPOController::class, 'index']);
Route::get('/v2grpotoplate', [\App\Http\Controllers\Api\Inbound\GoodReceiptPOController::class, 'toplate']);
Route::get('/v2grpothreelate', [\App\Http\Controllers\Api\Inbound\GoodReceiptPOController::class, 'threemounthLate']);
Route::get('/v2grpothreeontime', [\App\Http\Controllers\Api\Inbound\GoodReceiptPOController::class, 'threemounthOntime']);
Route::get('/v2grpochart', [\App\Http\Controllers\Api\Inbound\GoodReceiptPOController::class, 'getStatistics']);

##return

Route::get('/v2latereturn', [\App\Http\Controllers\Api\Inbound\ReceiptReturnController::class, 'late']);
Route::get('/v2statisticreturn', [\App\Http\Controllers\Api\Inbound\ReceiptReturnController::class, 'getStatistic']);

##storage
##cashpicking
 
Route::get('/v2latecashpicking', [\App\Http\Controllers\Api\Storage\CashPickingController::class, 'late']);
Route::get('/v2statisticcashpicking', [\App\Http\Controllers\Api\Storage\CashPickingController::class, 'getStatistic']);
##deliverypicking

Route::get('/v2latedeliverypicking', [\App\Http\Controllers\Api\Storage\DeliveryPickingContoller::class, 'late']);
Route::get('/v2statisticdeliverypicking', [\App\Http\Controllers\Api\Storage\DeliveryPickingContoller::class, 'getStatistic']);
##putaway

Route::get('/v2lateputaway', [\App\Http\Controllers\Api\Storage\PutawayContoller::class, 'late']);
Route::get('/v2statisticputaway', [\App\Http\Controllers\Api\Storage\PutawayContoller::class, 'getStatistic']);
##replenishment

Route::get('/v2latereplenishment', [\App\Http\Controllers\Api\Storage\ReplenishmentContoller::class, 'late']);
Route::get('/v2statisticreplenishment', [\App\Http\Controllers\Api\Storage\ReplenishmentContoller::class, 'getStatistic']);
#listpicking


##outbound
#arreserve

Route::get('/v2latearreserve', [\App\Http\Controllers\Api\Outbound\ArReserveController::class, 'late']);
Route::get('/v2statisticarreserve', [\App\Http\Controllers\Api\Outbound\ArReserveController::class, 'getStatistic']);
##itrout

Route::get('/v2lateitrout', [\App\Http\Controllers\Api\Outbound\ItrOutController::class, 'late']);
Route::get('/v2statisticitrout', [\App\Http\Controllers\Api\Outbound\ItrOutController::class, 'getStatistic']);
##salesorder

Route::get('/v2latesalesorder', [\App\Http\Controllers\Api\Outbound\SalesOrderController::class, 'late']);
Route::get('/v2statisticsalesorder', [\App\Http\Controllers\Api\Outbound\SalesOrderController::class, 'getStatistic']);




// //posts


// //ils
// Route::get('/ils', [\App\Http\Controllers\Api\IlsController::class, 'index']);
// Route::get('/ilssp', [\App\Http\Controllers\Api\IlsController::class, 'getIlsPs']);
// Route::get('/chart', [\App\Http\Controllers\Api\IlsController::class, 'getStatistics']);
// Route::get('/late', [\App\Http\Controllers\Api\IlsController::class, 'getLate']);
// Route::get('/unlate', [\App\Http\Controllers\Api\IlsController::class, 'getUnLate']);
// //alertcash
// Route::get('/alertcash', [\App\Http\Controllers\Api\AlertCashController::class, 'index']);
// //receipt inbound
// Route::get('/putaway', [\App\Http\Controllers\Api\PutAwayController::class, 'index']);
// Route::get('/chartpa', [App\Http\Controllers\Api\PutAwayController::class, 'getStatistic']);
// Route::get('/palate', [\App\Http\Controllers\Api\PutAwayController::class, 'getLate']);
// Route::get('/paunlate', [\App\Http\Controllers\Api\PutAwayController::class, 'getUnLate']);
// //delivstock
// Route::get('/indelivestock', [\App\Http\Controllers\Api\IndelivstockController::class, 'index']);
// Route::get('/indelivestocklate', [\App\Http\Controllers\Api\IndelivstockController::class, 'getlate']);
// Route::get('/indelivestockunlate', [\App\Http\Controllers\Api\IndelivstockController::class, 'getunlate']);
// Route::get('/chartds', [\App\Http\Controllers\Api\IndelivstockController::class, 'getStatistic']);

// Route::get('/cashputstorage', [\App\Http\Controllers\Api\CashPutStorageController::class, 'index']);
// Route::get('/cpslate', [\App\Http\Controllers\Api\CashPutStorageController::class, 'GetLate']);
// Route::get('/cpsunlate', [\App\Http\Controllers\Api\CashPutStorageController::class, 'GetUnLate']);
// Route::get('/chartcps', [\App\Http\Controllers\Api\CashPutStorageController::class, 'getStatistics']);

// Route::get('/cpsv1', [App\Http\Controllers\Api\Cpsv2Controller::class, 'index']);

// Route::get('/alertcasstorage', [\App\Http\Controllers\Api\AlertCashStorageController::class, 'index']);
// Route::get('/alertcasstoragelate', [\App\Http\Controllers\Api\AlertCashStorageController::class, 'getLate']);
// Route::get('/alertcasstorageunlate', [\App\Http\Controllers\Api\AlertCashStorageController::class, 'getUnLate']);
// Route::get('/chartacs', [\App\Http\Controllers\Api\AlertCashStorageController::class, 'getStatistics']);

// Route::get('/replenishment', [\App\Http\Controllers\Api\ReplanishmentController::class, 'index']);
// Route::get('/replenishmentlate', [\App\Http\Controllers\Api\ReplanishmentController::class, 'getLate']);
// Route::get('/replenishmentunlate', [\App\Http\Controllers\Api\ReplanishmentController::class, 'getUnlate']);
// Route::get('/chartreplenishment', [\App\Http\Controllers\Api\ReplanishmentController::class, 'GetStatistic']);


//Route::resource('/kendaraan', [\App\Http\Controllers\Api\Logistic\KendaraanController::class]);

Route::get('/grpokaliurangdetail', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoDataDetail']);
Route::get('/grpokaliurangdetailin', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoDataDetailIN']);
Route::get('/grpokaliurangdetailout', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoDataDetailOut']);
Route::get('/grpokaliurangdetailtransit', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoDataDetailTransit']);
Route::get('/grpokaliurangheader', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoDataHeader']);
Route::get('/grpokaliurangheaderstatistic', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoDataHeaderStatistic']);
Route::get('/grpokaliurangheaderstatisticstore', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoDataHeaderStatisticStore']);
Route::get('/grpokaliurangheaderstatisticstorebinlate', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoDataHeaderStatisticStoreBinLate']);
Route::get('/grpokaliurangstatisticbininlatedetail', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoStatisticStoreDetailBinInLate']);
Route::get('/grpokaliurangstatisticbinoutlatedetail', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoStatisticStoreDetailBinOutLate']);
Route::get('/grpokaliurangstatisticbintransitlatedetail', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoStatisticStoreDetailBinTransitLate']);
Route::get('/grpokaliurangdetailinstore', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoDataDetailINStore']);
Route::get('/grpokaliurangdetailoutstore', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoDataDetailOutStore']);
Route::get('/grpokaliurangdetailtransitstore', [\App\Http\Controllers\Api\Kaliurang\Inbound\grpoController::class, 'getGrpoDataDetailTransitStore']);

//Route::get('/kaliurangcashpicking', [\App\Http\Controllers\Api\Kaliurang\Inbound\cashPickingContoller::class, 'getCashPicking']);
Route::get('/kaliurangcashpicking', [\App\Http\Controllers\Api\Kaliurang\Inbound\cashPickingController::class, 'getCashPicking']);
Route::get('/kaliurangcashpndstore', [\App\Http\Controllers\Api\Kaliurang\Inbound\CashStoreController::class, 'getCashStore']);

Route::get('/kaliurangcashcarrystorestatistic', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getCashCarryPnd']);
Route::get('/kaliurangcashcarrystorestatisticlatedetail', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getCashCarryLateDetail']);
Route::get('/kaliurangcashcarrystorestatisticonscheduledetail', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getCashCarryOnScheduleDetail']);
Route::get('/kaliurangcashcarryorderreceived', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getCashCarryOrderReceived']);
Route::get('/kaliurangcashcarrybeingprocess', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getCashCarryBeingProcess']);
Route::get('/kaliurangcashcarryreadypickup', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getCashCarryReadyPickup']);


Route::get('/kaliurangdelivcusstorestatistic', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getDeliveryCustomer']);
Route::get('/kaliurangdelivcusstorestatisticlatedetail', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getDeliveryCustomerLateDetail']);
Route::get('/kaliurangdelivcusstorestatisticonscheduledetail', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getDeliveryCustomerOnScheduleDetail']);
Route::get('/kaliurangdelivcusstoreorderreceived', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getDeliveryCustomerOrderReceived']);
Route::get('/kaliurangdelivcusstorebeingprocess', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getDeliveryCustomerBeingProcess']);
Route::get('/kaliurangdelivcusstorereadypickup', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getDeliveryCustomerReadyPickup']);

Route::get('/kaliurangitrinstorestatistic', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrIn']);
Route::get('/kaliurangitrinstorestatisticlatedetail', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrInLateDetail']);
Route::get('/kaliurangitrinstorestatisticonscheduledetail', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrInOnScheduleDetail']);
Route::get('/kaliurangitrinorderreceived', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrInOrderReceived']);
Route::get('/kaliurangitrinbeingprocess', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrInBeingProcess']);
Route::get('/kaliurangitrinreadypickup', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrInReadyPickup']);
Route::get('/kaliurangitrintransit', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class ,'getItrInDataDetailTransit']);


Route::get('/kaliurangitroutstorestatistic', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrOut']);
Route::get('/kaliurangitroutstorestatisticlatedetail', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrOutLateDetail']);
Route::get('/kaliurangitroutstorestatisticonscheduledetail', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrOutOnScheduleDetail']);
Route::get('/kaliurangitroutorderreceived', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrOutOrderReceived']);
Route::get('/kaliurangitroutbeingprocess', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrOutBeingProcess']);
Route::get('/kaliurangitroutreadypickup', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrOutReadyPickup']);


Route::get('/kaliurangstorestatisticcashcarrylate', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getCashCarryLate']);
Route::get('/kaliurangstorestatisticdeliverycustomerlate', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getDeliveryCustomerLate']);
Route::get('/kaliurangstorestatisticitrinlate', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrInLate']);
Route::get('/kaliurangstorestatisticitroutlate', [\App\Http\Controllers\Api\Kaliurang\Inbound\StoreKaliurangController::class, 'getItrOutLate']);


///warehouse 
Route::get('/grpowarehousekaliurang', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoWarehouse']);
Route::get('/grpowarehousekaliurangheaderstatistic', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoWarehouseStatistic']);
Route::get('/grpowarehousekaliurangdetail', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoDataDetail']);
Route::get('/grpowarehousekaliurangdetailin', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoDataDetailIN']);
Route::get('/grpowarehousekaliurangdetailout', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoDataDetailOut']);
Route::get('/grpowarehousekaliurangdetailtransit', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoDataDetailTransit']);
Route::get('/grpokaliurangheaderstatisticwarehouse', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoDataHeaderStatisticWarehouse']);
Route::get('/grpokaliurangheaderstatisticwarehousebinlate', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoDataHeaderStatisticWarehouseBinLate']);
Route::get('/grpowarehousekaliurangstatisticbininlatedetail', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoStatisticWarehouseDetailBinInLate']);
Route::get('/grpowarehousekaliurangstatisticbinoutlatedetail', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoStatisticWarehouseDetailBinOutLate']);
Route::get('/grpowarehousekaliurangstatisticbintransitlatedetail', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoStatisticWarehouseilBinTransitLate']);
Route::get('/grpowarehousekaliurangdetailinswarehouse', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoDataDetailINWarehouse']);
Route::get('/grpowarehousekaliurangdetailoutwarehouse', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoDataDetailOutWarehouse']);
Route::get('/grpowarehousekaliurangdetailtransitwarehouse', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class, 'getGrpoDataDetailTransitWarehouse']);

Route::get('/kaliurangcashcarrywarehousestatistic', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getCashCarryPnd']);
Route::get('/kaliurangwarehousestatisticcashcarrylate', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getCashCarryLate']);
Route::get('/kaliurangcashcarrywarehousestatisticlatedetail', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getCashCarryLateDetail']);
Route::get('/kaliurangcashcarrywarehousestatisticonscheduledetail', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getCashCarryOnScheduleDetail']);
Route::get('/kaliurangcashcarrywarehouseorderreceived', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getCashCarryOrderReceived']);
Route::get('/kaliurangcashcarrywarehousebeingprocess', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getCashCarryBeingProcess']);
Route::get('/kaliurangcashcarrywarehousereadypickup', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getCashCarryReadyPickup']);

Route::get('/kaliurangdelivcuswarehousestatistic', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getDeliveryCustomer']);
Route::get('/kaliurangwarehousestatisticdeliverycustomerlate', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getDeliveryCustomerLate']);
Route::get('/kaliurangdelivcuwarehousestatisticlatedetail', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getDeliveryCustomerLateDetail']);
Route::get('/kaliurangdelivcuswarehousestatisticonscheduledetail', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getDeliveryCustomerOnScheduleDetail']);
Route::get('/kaliurangdelivcuswarehouseorderreceived', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getDeliveryCustomerOrderReceived']);
Route::get('/kaliurangdelivcuswarehouseebeingprocess', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getDeliveryCustomerBeingProcess']);
Route::get('/kaliurangdelivcuswarehousereadypickup', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getDeliveryCustomerReadyPickup']);

Route::get('/kaliurangitrinwarehousestatistic', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrIn']);
Route::get('/kaliurangwarehousestatisticitrinlate', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrInLate']);
Route::get('/kaliurangitrinwarehousetatisticlatedetail', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrInLateDetail']);
Route::get('/kaliurangitrinwarehousetatisticonscheduledetail', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrInOnScheduleDetail']);
Route::get('/kaliurangitrinorderreceivedwarehouse', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrInOrderReceived']);
Route::get('/kaliurangitrinbeingprocesswarehouse', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrInBeingProcess']);
Route::get('/kaliurangitrinreadypickupwarehouse', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrInReadyPickup']);
Route::get('/kaliurangitrintransitwarehouse', [\App\Http\Controllers\Api\Kaliurang\Warehouse\grpoWarehouseKaliurangController::class ,'getItrInDataDetailTransitWarehouse']);

Route::get('/kaliurangitroutwarehousestatistic', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrOut']);
Route::get('/kaliurangwarehousetatisticitroutlate', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrOutLate']);
Route::get('/kaliurangitroutwarehousestatisticlatedetail', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrOutLateDetail']);
Route::get('/kaliurangitroutwarehousestatisticonscheduledetail', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrOutOnScheduleDetail']);
Route::get('/kaliurangitroutorderreceivedwarehouse', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrOutOrderReceived']);
Route::get('/kaliurangitroutbeingprocesswarehouse', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrOutBeingProcess']);
Route::get('/kaliurangitroutreadypickupwarehouse', [\App\Http\Controllers\Api\Kaliurang\Warehouse\WarehouseKaliurangController::class, 'getItrOutReadyPickup']);


