<?php

namespace App\Http\Controllers\Api\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Storage\Putaway;
use App\Http\Resources\Storage\PutawayResource;
use App\Http\Resources\Storage\latePutawayResource;

class PutawayContoller extends Controller
{
    protected $data;

    public function __construct()
    {
        $this->data = Putaway::getPutaway();
    }

    public function index ()
    {
        return new PutawayResource(true, 'List Data Putaway', $this->data);
    }

    public function late()
    {
        $late = $this->data->where('LATE', '>', 0);
        return new latePutawayResource(true, 'List Data Putaway', $late);
    }

    public function onTime()
    {

    }

    public function getStatistic()
    {
        $late = $this->data->where('LATE', '>', 0)->count();
        $ontime = $this->data->where('LATE', '=', 0)->count();
        $total_late = $late + $ontime;

        $totalQTYLate = $this->data->where('LATE', '>', 0)->sum('QTY');
        $totalQTYOntime = $this->data->where('LATE', '=', 0)->sum('QTY');

        $totalItemlate = $this->data
        ->where('LATE', '>', 0)  // Filter data dengan Deadline > 0
        ->groupBy('ITEM_DESC')      // Kelompokkan berdasarkan receipt_id
        ->count();                   // Hitung jumlah distinct receipt_id

        $totalItemOntime = $this->data
        ->where('LATE', '=', 0)  // Filter data dengan Deadline > 0
        ->groupBy('ITEM_DESC')      // Kelompokkan berdasarkan receipt_id
        ->count();

        $total = $totalItemlate + $totalItemOntime;
    
    // dd($totalDoclate);

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data Delivery Picking',
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
