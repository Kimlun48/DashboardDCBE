<?php

namespace App\Http\Controllers\Api\Inbound;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inbound\Crossdock;
use App\Http\Resources\Inbound\IndexCrossdockResource;
use App\Http\Resources\Inbound\lateCrossdockResource;

class CrossdockController extends Controller
{
    protected $data;

    public function __construct()
    {
        $this->data = Crossdock::getCrossdock();
    }

    public function index()
    {
         return new IndexCrossdockResource(true, 'List Data Crossdock', $this->data);
    }

    public function late()
    {
        $late = $this->data->where('LATE', '>', 0);
        return new lateCrossdockResource(true, 'List Data Crossdock', $late);
        
        
    }

    public function onTime()
    {
        // $ontime = $this->data->where('Deadline', '=', 0);
        // return new OntimeItrInResource(true, 'List Data ITRIN', $ontime);
    }

    public function getStatistic()
    {
        $late = $this->data->where('LATE', '>', 0)->count();
        $ontime = $this->data->where('LATE', '=', 0)->count();
        $total_all = $late + $ontime;

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
            'message' => 'Statistik Data CROSSDOCK',
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
