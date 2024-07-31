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
        $late = $this->data->where('LATE', '>', 0);
        return new lateCashPicResource(true, 'List Data CashPicking', $late);
    }

    public function onTime()
    {
        
    }

    public function getStatistic()
    {
        $late = $this->data->where('LATE', '>', 0)->count();
        $ontime = $this->data->where('LATE', '=', 0)->count();
        $total_all = $late + $ontime;

        $totalQTYLate = $this->data->where('LATE', '>', 0)->sum('TOTAL_QTY');
        $totalQTYOntime = $this->data->where('LATE', '=', 0)->sum('TOTAL_QTY');

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
            'message' => 'Statistik Data Cash Picking',
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

