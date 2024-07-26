<?php

namespace App\Http\Controllers\Api\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Storage\CashPicking;
use App\Http\Resources\Storage\CashPickingResource;
use App\Http\Resources\Storage\lateCashPicResource;

class CashPickingController extends Controller
{
    protected $data;

    public function __construct()
    {
        $this->data = CashPicking::getCashPicking();
    }

    public function index()
    {
        return new CashPickingResource(true, 'List Data Cash Picking', $this->data);
    }

    public function late()
    {
        $late = $this->data->where('Late', '>', 0);
        return new lateCashPicResource(true, 'List Data CashPicking', $late);
    }

    public function onTime()
    {
        
    }

    public function getStatistic()
    {
        $late = $this->data->where('Late', '>', 0)->count();
        $ontime = $this->data->where('Late', '=', 0)->count();
        $total_all = $late + $ontime;

        $totalQTYLate = $this->data->where('Late', '>', 0)->sum('Total_QTY');
        $totalQTYOntime = $this->data->where('Late', '=', 0)->sum('Total_QTY');

        $totalItemlate = $this->data
        ->where('Late', '>', 0)  // Filter data dengan Deadline > 0
        ->groupBy('ITEM_DESC')      // Kelompokkan berdasarkan receipt_id
        ->count();                   // Hitung jumlah distinct receipt_id

        $totalItemOntime = $this->data
        ->where('Late', '=', 0)  // Filter data dengan Deadline > 0
        ->groupBy('ITEM_DESC')      // Kelompokkan berdasarkan receipt_id
        ->count();   
        
        $total = $totalItemlate + $totalItemOntime;
    
    // dd($totalDoclate);

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data Cash Picking',
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

