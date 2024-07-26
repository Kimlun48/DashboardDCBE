<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Replenishment;
use App\Http\Resources\ReplenishmentResource;
use App\Http\Resources\ReplenishmentLateResource;
use App\Http\Resources\ReplenishmentUnLateResource;

class ReplanishmentController extends Controller
{
    public function index()
    {
        $data = Replenishment::getReplenishment();
        return new ReplenishmentResource(true, 'List Data Replenishment', $data);
    }

    public function getLate()
    {
        $data = Replenishment::getReplenishment();
        $late = $data->where('late', '>', 0);

        return new ReplenishmentLateResource(true, 'List Data Replenishment Late', $late);
    }

    public function getUnLate()
    {
        $data = Replenishment::getReplenishment();
        $late = $data->where('late', '=', 0);

        return new ReplenishmentUnLateResource(true, 'List Data Replenishment UnLate', $late);
    }

    public function GetStatistic()
    {
        // Ambil data dari metode getIlsSP yang sekarang mengembalikan koleksi
        $data = Replenishment::getReplenishment();

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
