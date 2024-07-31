<?php

namespace App\Http\Controllers\Api\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Storage\Replenishment;
use App\Http\Resources\Storage\ReplenishmentResource;
use App\Http\Resources\Storage\lateReplenishmentResource;

class ReplenishmentContoller extends Controller
{
    protected $data;
    public function __construct()
    {
        $this->data = Replenishment::getReplenishment();
    }

    public function index()
    {
        return new ReplenishmentResource(true, 'List data Replenishment', $this->data);
    }

    public function late()
    {
        $late = $this->data->where('LATE', '>', 0);
        return new lateReplenishmentResource(true, 'List Data Replenishment', $late);
    }

    public function onTime()
    {

    }

    public function getStatistic ()
    {
        $late = $this->data->where('LATE', '>', 0)->count();
        $ontime = $this->data->where('LATE', '=', 0)->count();
        $total_all = $late + $ontime;

        $totalQTYLate = $this->data->where('LATE', '>', 0)->sum('QTY');
        $totalQTYOntime = $this->data->where('LATE', '=', 0)->sum('QTY');

        $totalItemlate = $this->data
        ->where('LATE', '>', 0)  // Filter data dengan Deadline > 0
        ->groupBy('ITEM')      // Kelompokkan berdasarkan receipt_id
        ->count();                   // Hitung jumlah distinct receipt_id

        $totalItemOntime = $this->data
        ->where('LATE', '=', 0)  // Filter data dengan Deadline > 0
        ->groupBy('ITEM')      // Kelompokkan berdasarkan receipt_id
        ->count();     

        $total = $totalItemlate + $totalItemOntime;
    
    // dd($totalDoclate);

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data Replenishment',
            'data' => [
                'LATE' => $late,
                'ONTIME' => $ontime,
                'TOTAL' => $total,
                'TOTAL_QTY_LATE' => $totalQTYLate,
                'TOTAL_QTY_ONTIME' => $totalQTYOntime,
                'TOTAL_ITEM_LATE' => $totalItemlate,
                'TOTAL_ITEM_ONTIME' => $totalItemOntime,
            ],
        ]);
    }
    
    
}
