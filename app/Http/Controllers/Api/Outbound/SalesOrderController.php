<?php

namespace App\Http\Controllers\Api\Outbound;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Outbound\SalesOrder;
use App\Http\Resources\Outbound\SalesOrderResource;
use App\Http\Resources\Outbound\lateSalesorderResource;

class SalesOrderController extends Controller
{
    protected $data;
    public function __construct()
    {
        $this->data = SalesOrder::getSalesOrder();
    }

    public function index ()
    {
        return new SalesOrderResource(true, 'List data Sales Order', $this->data);
    }

    public function late()
    {
        $late = $this->data->where('CONDITION', '=', 'Late');
        return new lateSalesorderResource(true, 'List Data Sales Order', $late);
    }

    public function getStatistic()
    {
        $late = $this->data->where('CONDITION', '=', 'Late')->count();
        $today = $this->data->where('CONDITION', '=', 'Today')->count();
        $dDay = $this->data->where('CONDITION', '=', 'H-1')->count();

        //dd($late);
        
        $total_all = $late + $today + $dDay ;

        // $totalQTYLate = $this->data->where('late', '>', 0)->sum('Total_QTY');
        // $totalQTYOntime = $this->data->where('late', '=', 0)->sum('Total_QTY');

        $totalDoclate = $this->data
        ->where('CONDITION', '=', 'Late')  // Filter data dengan Deadline > 0
        ->groupBy('DOCNUM')      // Kelompokkan berdasarkan receipt_id
        ->count();                   // Hitung jumlah distinct receipt_id

        $totalDocToday = $this->data
        ->where('CONDITION', '=', 'Today')  // Filter data dengan Deadline > 0
        ->groupBy('DOCNUM')      // Kelompokkan berdasarkan receipt_id
        ->count();  
        
        $totalDocdDay = $this->data
        ->where('CONDITION', '=', 'H-1')  // Filter data dengan Deadline > 0
        ->groupBy('DOCNUM')      // Kelompokkan berdasarkan receipt_id
        ->count();  

        $total = $totalDoclate+$totalDocToday+$totalDocdDay;
    
    // dd($totalDoclate);

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data ITR Out ',
            'data' => [
                'LATE' => $late,
                'TODAY'=> $today,
                'DDAY' => $dDay,

                'TOTAL' => $total,
                // 'total_QTY_late' => $totalQTYLate,
                // 'total_QTY_ontime' => $totalQTYOntime,
                'TOTAL_DOC_LATE' => $totalDoclate,
                'TOTAL_DOC_TODAY' => $totalDocToday,
                'TOTAL_DOC_DDAY' => $totalDocdDay
            ],
        ]);
    
    }
}
