<?php

namespace App\Http\Controllers\Api\Kaliurang\Inbound;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\kaliurang\inbound\getgrpoResource;
use App\Models\kaliurang\inbound\grpo;
class grpoController extends Controller
{
   


    public function getGrpoDataHeader()
    {
        try {
            
            $WAREHOUSE = '01021001';
            $BIN = '01021001-in-01';
            $TYPE = '1';   
            $Grpo = grpo::getGrpo($WAREHOUSE, $BIN, $TYPE);
            if (empty($Grpo)) {
                return response()->json(['message' => 'No orders found'], 404);
            }
            return response()->json($Grpo);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
        
    }

    public function getGrpoDataDetail()
    {
        try {
            
            $WAREHOUSE = '01021001';
            $BIN = '01021001-in-01';
            $TYPE = '2';   
            $Grpo = grpo::getGrpo($WAREHOUSE, $BIN, $TYPE);
            if (empty($Grpo)) {
                return response()->json(['message' => 'No orders found'], 404);
            }
            return response()->json($Grpo);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
        
    }

    
}
