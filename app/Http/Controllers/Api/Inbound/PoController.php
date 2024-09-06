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
        $late = $this->data->where('DEADLINE', '>', 0);
        return new lateGrpoResource(true, 'List Data grpo', $late);
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
        $total_all= $late + $ontime;

        $totalQTYLate = $this->data->where('LATE', '>', 0)->sum('OPEN_QTY');
        $totalQTYOntime = $this->data->where('LATE', '=', 0)->sum('OPEN_QTY');

        $totalDoclate = $this->data
        ->where('LATE', '>', 0)  
        ->groupBy('RECEIPT_ID')      
        ->count();                  

        $totalDocOntime = $this->data
        ->where('LATE', '=', 0)  
        ->groupBy('RECEIPT_ID')     
        ->count(); 
        
        $total = $totalDoclate + $totalDocOntime;
    
    // dd($totalDoclate);

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data PO',
            'data' => [
                'LATE' => $late,
                'ONTIME' => $ontime,
                'TOTAL' => $total,
                'TOTAL_QTY_LATE' => $totalQTYLate,
                'TOTAL_QTY_ONTIME' => $totalQTYOntime,
                'TOTAL_DOC_LATE' => $totalDoclate,
                'TOTAL_DOC_ONTIME' => $totalDocOntime,
            ],
        ]);
    }
}
