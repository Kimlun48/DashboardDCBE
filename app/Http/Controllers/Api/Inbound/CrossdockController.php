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
        $late = $this->data->where('late', '>', 0);
        return new lateCrossdockResource(true, 'List Data Crossdock', $late);
        
        
    }

    public function onTime()
    {
        // $ontime = $this->data->where('Deadline', '=', 0);
        // return new OntimeItrInResource(true, 'List Data ITRIN', $ontime);
    }

    public function getStatistic()
    {
        $late = $this->data->where('late', '>', 0)->count();
        $ontime = $this->data->where('late', '=', 0)->count();
        $total_all = $late + $ontime;

        $totalQTYLate = $this->data->where('late', '>', 0)->sum('qty');
        $totalQTYOntime = $this->data->where('late', '=', 0)->sum('qty');

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
            'message' => 'Statistik Data CROSSDOCK',
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
