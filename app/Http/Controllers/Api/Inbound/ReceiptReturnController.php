<?php

namespace App\Http\Controllers\Api\Inbound;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inbound\ReturnInbound;
use App\Http\Resources\Inbound\ReturnResource;
use App\Http\Resources\Inbound\lateReturnResource;

class ReceiptReturnController extends Controller
{
    protected $data;

    public function __construct()
    {
        $this->data = ReturnInbound::getReturnInbound();
    }

    public function index()
    {
         return new ReturnResource(true, 'List Data Return', $this->data);
    }

    public function late()
    {
        $late = $this->data->where('DEADLINE', '>', 0);
        return new lateReturnResource(true, 'List Data Return', $late);
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

        $totalQTYLate = $this->data->where('LATE', '>', 0)->sum('OPEN_QTY');
        $totalQTYOntime = $this->data->where('LATE', '=', 0)->sum('OPEN_QTY');

        $totalDoclate = $this->data
        ->where('LATE', '>', 0)  // Filter data dengan Deadline > 0
        ->groupBy('RECEIPT_ID')      // Kelompokkan berdasarkan receipt_id
        ->count();                   // Hitung jumlah distinct receipt_id

        $totalDocOntime = $this->data
        ->where('LATE', '=', 0)  // Filter data dengan Deadline > 0
        ->groupBy('RECEIPT_ID')      // Kelompokkan berdasarkan receipt_id
        ->count();
        
        $total = $totalDoclate + $totalDocOntime;
    
    // dd($totalDoclate);

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data RETURN',
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
