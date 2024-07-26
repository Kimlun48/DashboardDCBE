<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PutAway;
use App\Http\Resources\PutAwayResource;
use App\Http\Resources\PaLateResource;
use App\Http\Resources\PaUnLateResource;

class PutAwayController extends Controller
{
    public function index()
    {
        $data = PutAway::getPutAway();
        return new PutAwayResource(true, 'List Data CashAlert', $data);
    }

    public function getLate(Request $request)
    {
        $data = PutAway::getPutAway();
        $late = $data->where('late', '>', 0);

        return new PaUnLateResource(true, 'List Data Ils Late', $late);
    }

    public function getUnLate()
    {

        $data = PutAway::getPutAway();
        $late = $data->where('late', '=', 0);

        return new PaLateResource(true, 'List Data Ils Late', $late);
    }

    public function GetStatistic()
    {
        $data = PutAway::getPutAway();
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
