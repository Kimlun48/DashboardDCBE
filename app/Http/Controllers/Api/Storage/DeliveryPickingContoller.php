<?php

namespace App\Http\Controllers\Api\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Storage\DeliveryPicking;
use App\Http\Resources\Storage\DeliveryPickingResource;
use App\Http\Resources\Storage\lateDeliveryPicResource;


class DeliveryPickingContoller extends Controller
{
    protected $data;
    public function __construct()
    {
        $this->data = DeliveryPicking::getDeliveryPicking();
    }

    public function index()
    {
        return new DeliveryPickingResource(true, 'List Data Delivery Picking', $this->data);
    }

    public function late()
    {
        $late = $this->data->where('Late', '>', 0);
        return new lateDeliveryPicResource(true, 'List Data deliveryPicking', $late);
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

        $totalDoclate = $this->data
        ->where('Late', '<', 0)  // Filter data dengan Deadline > 0
        ->groupBy('DocNum')      // Kelompokkan berdasarkan receipt_id
        ->count();                   // Hitung jumlah distinct receipt_id

        $totalDocOntime = $this->data
        ->where('Late', '=', 0)  // Filter data dengan Deadline > 0
        ->groupBy('DocNum')      // Kelompokkan berdasarkan receipt_id
        ->count();  
        
        $total = $totalDoclate + $totalDocOntime;
    
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
                'Total_Doc_late' => $totalDoclate,
                'Total_Doc_Ontime' => $totalDocOntime,
            ],
        ]);
    }
    
}
