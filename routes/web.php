<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test-mssql', function () {
    try {
        // Coba melakukan koneksi ke database
      //  DB::connection('DB_WMS')->getPdo();
        //DB::connection('DB_EMAIL_SAP')->getPdo();
       DB::connection('DB_RKM_LIVE_2')->getPdo();
        //DB::connection('DB_ILS')->getPdo();
        

        
        //DB::connection('mysql')->getPdo();

        return "Koneksi ke database berhasil!";
    } catch (\Exception $e) {
        return "Gagal melakukan koneksi ke database: " . $e->getMessage();
    }
});
//Route::get('/integration' [])
//Route::get('/integration',[App\Http\Controllers\IntegrationController::class, 'index']);
