<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\indelivstock;
use App\Http\Resources\IndelivstockResource;
use App\Http\Resources\IndelivstockLateResource;
use App\Http\Resources\IndelivstockUnlateResource;

class IndelivstockController extends Controller
{
    public function index()
    {
        $data = indelivstock::getDelivStock();
        return new IndelivstockResource(true, 'data deliv stok', $data);
    }

    public function GetLate()
    {
        $data = indelivstock::getDelivStock();
        $late = $data->where('Deadline', '<', 0);
        return new IndelivstockLateResource(true, 'List Data DeliveStock Late', $late);
    }

    public function GetUnlate()
    {
        $data = indelivstock::getDelivStock();
        $unlate = $data->where('Deadline', '>', -1);
        return new IndelivstockUnLateResource(true, 'List Data DeliveStock UnLate', $unlate);
    }

    public function GetStatistic()
    {
        $data = indelivstock::getDelivStock();

        // Hitung jumlah item dengan nilai 'late' > 0 dan 'late' = 0
        $late = $data->where('Deadline', '<', 0)->count();
        $unlate = $data->where('Deadline', '>', -1)->count();
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
