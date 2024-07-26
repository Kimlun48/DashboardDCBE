<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashPutStorage;

use App\Http\Resources\CpsResource;
use App\Http\Resources\CpsLateResource;
use App\Http\Resources\CpsUnLateResource;

class CashPutStorageController extends Controller
{
    public function index()
    {
        $data = CashPutStorage::getCashPutStorage();
        return new CpsResource(true, 'List Data Cash Put Storage', $data);
    }

    public function getLate()
    {
        $data = CashPutStorage::getCashPutStorage();
        $late = $data->where('late', '>', 0);
        return new CpsLateResource(true, 'List Data Ils Late', $late);
    }

    public function getUnLate()
    {
        $data = CashPutStorage::getCashPutStorage();
        $late = $data->where('late', '=', 0);
        return new CpsUnLateResource(true, 'List Data Ils Late', $late);
    }

    public function getStatistics()
    {
        // Ambil data dari metode getIlsSP yang sekarang mengembalikan koleksi
        $data = CashPutStorage::getCashPutStorage();

        // Hitung jumlah item dengan nilai 'late' > 0 dan 'late' = 0
        $late = $data->where('late', '>', 0)->count();
        $unlate = $data->where('late', '=', 0)->count();
        $all = $late + $unlate;

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data',
            'data' => [
                'late' => $late,
                'unlate' => $unlate,
                'all' => $all,
            ],
        ]);
    }
}
