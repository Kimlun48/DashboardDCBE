<?php

namespace App\Http\Controllers\Api\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logistic\MasterHour;
class MasterHourController extends Controller
{
    public function index ()
    {
        try {
            $masterhour = MasterHour::all();
            return response()->json([
                'success' => true,
                'data' => $masterhour,
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data',
                'erros'=> $e -> getMessage()
            ],500);
        }
    }

    public function hour () {
        $masterhour = MasterHour::distinct()->get(['jenis_jam']);
        return response()->json([
            'success' => true,
            'data' => $masterhour,
        ],200);
    }
}
