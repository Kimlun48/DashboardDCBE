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
        $late = $this->data->where('LATE', '>', 0);
        return new LateItrInResource(true, 'List Data ITRIN', $late);
    }

    public function onTime()
    {
        $ontime = $this->data->where('DEADLINE', '=', 0);
        return new OntimeItrInResource(true, 'List Data ITRIN', $ontime);
    }

    public function getStatistic()
    {
        $late = $this->data->where('DEADLINE', '>', 0)->count();
        $ontime = $this->data->where('DEADLINE', '=', 0)->count();
        $total_all = $late + $ontime;

        $totalQTYLate = $this->data->where('DEADLINE', '>', 0)->sum('OPEN_QTY');
        $totalQTYOntime = $this->data->where('DEADLINE', '=', 0)->sum('OPEN_QTY');

        $totalDoclate = $this->data
        ->where('DEADLINE', '>', 0)  // Filter data dengan Deadline > 0
        ->groupBy('RECEIPT_ID')      // Kelompokkan berdasarkan receipt_id
        ->count();                   // Hitung jumlah distinct receipt_id

        $totalDocOntime = $this->data
        ->where('DEADLINE', '=', 0)  // Filter data dengan Deadline > 0
        ->groupBy('RECEIPT_ID')      // Kelompokkan berdasarkan receipt_id
        ->count();  
         
        $total = $totalDoclate + $totalDocOntime;
    
    // dd($totalDoclate);

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data ITRIN',
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
