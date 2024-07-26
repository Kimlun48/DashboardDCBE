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
        $late = $this->data->where('late', '>', 0);
        return new latePutawayResource(true, 'List Data Putaway', $late);
    }

    public function onTime()
    {

    }

    public function getStatistic()
    {
        $late = $this->data->where('late', '>', 0)->count();
        $ontime = $this->data->where('late', '=', 0)->count();
        $total_late = $late + $ontime;

        $totalQTYLate = $this->data->where('late', '>', 0)->sum('QTY');
        $totalQTYOntime = $this->data->where('late', '=', 0)->sum('QTY');

        $totalItemlate = $this->data
        ->where('late', '>', 0)  // Filter data dengan Deadline > 0
        ->groupBy('ITEM_DESC')      // Kelompokkan berdasarkan receipt_id
        ->count();                   // Hitung jumlah distinct receipt_id

        $totalItemOntime = $this->data
        ->where('late', '=', 0)  // Filter data dengan Deadline > 0
        ->groupBy('ITEM_DESC')      // Kelompokkan berdasarkan receipt_id
        ->count();

        $total = $totalItemlate + $totalItemOntime;
    
    // dd($totalDoclate);

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data Delivery Picking',
            'data' => [
                'late' => $late,
                'ontime' => $ontime,
                'total' => $total,
                'total_QTY_late' => $totalQTYLate,
                'total_QTY_ontime' => $totalQTYOntime,
                'Total_Item_late' => $totalItemlate,
                'Total_Item_Ontime' => $totalItemOntime,
            ],
        ]);
    }
    

}
