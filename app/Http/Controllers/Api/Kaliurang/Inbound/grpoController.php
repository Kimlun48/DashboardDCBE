<?php

namespace App\Http\Controllers\Api\Kaliurang\Inbound;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\kaliurang\inbound\getgrpoResource;
use App\Models\kaliurang\inbound\grpo;
class grpoController extends Controller
{
   
    protected $warehouse;
    protected $bin;

    public function __construct()
    {
        //$this -> warehouse = '01003001';//a.yani
        $this -> warehouse = '01021001';//kaliurang
    }

    public function getGrpoDataHeader()
    {
        try {
            $type = '1';  
            $bin ='01021001-in-01';
            $Grpo = grpo::getGrpo($this->warehouse, $bin, $type);

            if (empty($Grpo)) {
                return response()->json(['message' => 'No orders found'], 404);
            }
            return response()->json($Grpo);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getGrpoDataHeaderStatistic ()
    {
        try {
            $type = '1';  
            $binIn = '01021001-IN-01';
            $binTransit = '01021001-TRANSIT';        
            $Grpo = grpo::getGrpo($this->warehouse, '', $type);
            if (empty($Grpo)) {
                return response()->json(['message' => 'No orders found'], 404);
            }
            $GrpoIn = collect($Grpo)->filter(function ($item) use ($binIn) {
                return $item->BINLOCATION === strtoupper($binIn);  
            })->values(); 
            $GrpoTransit = collect($Grpo)->filter(function ($item) use ($binTransit) {
                return $item->BINLOCATION === strtoupper($binTransit);  
            })->values(); 
            $onHandIn = $GrpoIn->pluck('ONHAND')->first() ?? 0; 
            $onHandTransit = $GrpoTransit->pluck('ONHAND')->first() ?? 0; 
            return response()->json([
                'ONHANDIN' => $onHandIn,
                'ONHANDTRANSIT' => $onHandTransit,
            ]);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
        
    }
    

    public function getGrpoDataDetail()
    {
        try {
            $type = '2';  
            $binIn ='01021001-in-01';
            $binTransit ='01021001-TRANSIT';
            $GrpoIn = grpo::getGrpo($this->warehouse, $binIn, $type);
            $GrpoTransit = grpo::getGrpo($this->warehouse, $binTransit, $type);

            if (empty($GrpoIn) && empty($GrpoTransit)) {
                return response()->json(['message' => 'No orders found for both locations'], 404);
            }
            $result = [
                'IN' => $GrpoIn,
                'TRANSIT' => $GrpoTransit,
            ];
    
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getGrpoDataDetailIN()
    {
    try {
        $type = '2';  
        $binIn = '01021001-in-01';
        $Grpo = grpo::getGrpo($this->warehouse, $binIn, $type);

        if (empty($Grpo)) {
            return response()->json(['message' => 'No orders Bin IN'], 404);
        }

        return response()->json($Grpo);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
    }

    public function getGrpoDataDetailTransit()
    {
    try {
        $type = '2';  
        $binTransit = '01021001-TRANSIT';
        $Grpo = grpo::getGrpo($this->warehouse, $binTransit, $type);

        if (empty($Grpo)) {
            return response()->json(['message' => 'No orders in Bin Transit'], 404);
        }

        return response()->json($Grpo);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
    }


    
}
