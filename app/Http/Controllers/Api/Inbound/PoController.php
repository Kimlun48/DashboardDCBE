<?php

namespace App\Http\Controllers\Api\Inbound;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inbound\Po;
use App\Http\Resources\Inbound\PoResource;
use App\Http\Resources\Inbound\lateGrpoResource;

class PoController extends Controller
{
    protected $data;

    public function __construct()
    {
        $this->data = Po::getPo();
    }

    public function index()
    {
         return new PoResource(true, 'List Data PO', $this->data);
    }

    public function late()
    {
        $late = $this->data->where('Deadline', '>', 0);
        return new lateGrpoResource(true, 'List Data grpo', $late);
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
        $total_all= $late + $ontime;

        $totalQTYLate = $this->data->where('late', '>', 0)->sum('open_qty');
        $totalQTYOntime = $this->data->where('late', '=', 0)->sum('open_qty');

        $totalDoclate = $this->data
        ->where('late', '>', 0)  // Filter data dengan Deadline > 0
        ->groupBy('receipt_id')      // Kelompokkan berdasarkan receipt_id
        ->count();                   // Hitung jumlah distinct receipt_id

        $totalDocOntime = $this->data
        ->where('late', '=', 0)  // Filter data dengan Deadline > 0
        ->groupBy('receipt_id')      // Kelompokkan berdasarkan receipt_id
        ->count(); 
        
        $total = $totalDoclate + $totalDocOntime;
    
    // dd($totalDoclate);

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data PO',
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
