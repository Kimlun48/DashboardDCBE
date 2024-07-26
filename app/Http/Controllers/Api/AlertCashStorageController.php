<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlertCashStorage;
use  App\Http\Resources\AlertCashStorageResource;
use App\Http\Resources\AlertCashStorageLateResource;
use App\Http\Resources\AlertCashStorageUnLateResource;

class AlertCashStorageController extends Controller
{
    public function index()
    {
        $data = AlertCashStorage::getAlertCashStorage();
        return new AlertCashStorageResource(true, 'List Data Cash Storage', $data);
    }

    public function getLate()
    {
        $data = AlertCashStorage::getAlertCashStorage();
        $late = $data->where('Status2', '=', 'Open');
        return new AlertCashStorageLateResource(true, 'List Data AlertCashStorage Late', $late);
    }

    public function getUnLate()
    {
        $data = AlertCashStorage::getAlertCashStorage();
        $late = $data->where('Status2', '=', 'Closed');
        return new AlertCashStorageUnLateResource(true, 'List Data AlertCashStorage UnLate', $late);
    }

    public function getStatistics()
    {
        // Ambil data dari metode getIlsSP yang sekarang mengembalikan koleksi
        $data = AlertCashStorage::getAlertCashStorage();

        // Hitung jumlah item dengan nilai 'late' > 0 dan 'late' = 0
        $late = $data->where('Status2', '=', 'Open')->count();
        $unlate = $data->where('Status2', '=', 'Closed')->count();
        $all = $late + $unlate;

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data',
            'data' => [
                'late' => $late,
                'unlate' => $unlate,
                'all' => $all
            ],
        ]);
    }
}
