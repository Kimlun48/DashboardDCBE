<?php

namespace App\Http\Controllers\Api\Inbound;

use App\Http\Controllers\Controller;
use App\Models\Inbound\ItrIn;
use App\Http\Resources\Inbound\IndexItrInResource;
use App\Http\Resources\Inbound\LateItrInResource;
use App\Http\Resources\Inbound\OntimeItrInResource;
use Illuminate\Http\Request;

class ItrInController extends Controller
{
    protected $data;

    public function __construct()
    {
        $this->data = ItrIn::getItrIn();
    }

    public function index()
    {
        return new IndexItrInResource(true, 'List Data ITRIN', $this->data);
    }

    public function late()
    {
        $late = $this->data->where('Late', '>', 0);
        return new LateItrInResource(true, 'List Data ITRIN', $late);
    }

    public function onTime()
    {
        $ontime = $this->data->where('Deadline', '=', 0);
        return new OntimeItrInResource(true, 'List Data ITRIN', $ontime);
    }

    public function getStatistic()
    {
        $late = $this->data->where('Deadline', '>', 0)->count();
        $ontime = $this->data->where('Deadline', '=', 0)->count();
        $total_all = $late + $ontime;

        $totalQTYLate = $this->data->where('Deadline', '>', 0)->sum('open_qty');
        $totalQTYOntime = $this->data->where('Deadline', '=', 0)->sum('open_qty');

        $totalDoclate = $this->data
        ->where('Deadline', '>', 0)  // Filter data dengan Deadline > 0
        ->groupBy('receipt_id')      // Kelompokkan berdasarkan receipt_id
        ->count();                   // Hitung jumlah distinct receipt_id

        $totalDocOntime = $this->data
        ->where('Deadline', '=', 0)  // Filter data dengan Deadline > 0
        ->groupBy('receipt_id')      // Kelompokkan berdasarkan receipt_id
        ->count();  
         
        $total = $totalDoclate + $totalDocOntime;
    
    // dd($totalDoclate);

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data ITRIN',
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
