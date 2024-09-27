<?php

namespace App\Http\Controllers\Api\Kaliurang\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\kaliurang\warehouse\getGrpoWarehouseKaliurangResource;
use App\Models\kaliurang\warehouse\grpoWarehouseKaliurang;
use PhpParser\Node\Stmt\TryCatch;

class grpoWarehouseKaliurangController extends Controller
{
    protected $warehouse ;
    protected $bin;

    public function __construct()
    {
         $this -> warehouse = '01021002';
        //$this -> warehouse = '01007001';
    }

    public function getGrpoWarehouse()
    {
        try {
            $type = '1';
            $bin = '01021002-in-01';
            $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $bin, $type);
            if (empty($Grpo))
            {
                return response()->json([
                    'message' => 'No Order found'
                ], 404);
            }
            return response()->json($Grpo);
        } catch (\Exception $e) {
            return response()->json([
                'erore' => 'An error occurred: '.$e->getMessage()
            ], 500);
        }
    }

    public function getGrpoWarehouseStatistic ()
    {
        try {
            $type = '1';  
            $binIn = '01021002-IN-01';
            $binTransit = '01021002-TRANSIT';
            $binOut = '01021002-OUT-01';        
            $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, '', $type);
            if (empty($Grpo)) {
                return response()->json(['message' => 'No orders found'], 404);
            }
            $GrpoIn = collect($Grpo)->filter(function ($item) use ($binIn) {
                return $item->BINLOCATION === strtoupper($binIn);  
            })->values(); 
            $GrpoOut = collect($Grpo)->filter(function ($item) use ($binOut) {
                return $item->BINLOCATION === strtoupper($binOut);  
            })->values(); 
            $GrpoTransit = collect($Grpo)->filter(function ($item) use ($binTransit) {
                return $item->BINLOCATION === strtoupper($binTransit);  
            })->values(); 

            $onHandIn = $GrpoIn->pluck('ONHAND')->first() ?? 0; 
            $onHandOut = $GrpoOut->pluck('ONHAND')->first() ?? 0; 
            $onHandTransit = $GrpoTransit->pluck('ONHAND')->first() ?? 0; 
            return response()->json([
                'ONHANDIN' => $onHandIn,
                'ONHANDOUT' => $onHandOut,
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
            $binIn ='01021002-in-01';
            $binTransit ='01021002-TRANSIT';
            $GrpoIn = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $binIn, $type);
            $GrpoTransit = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $binTransit, $type);

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
        $binIn = '01021002-in-01';
        $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $binIn, $type);

        if (empty($Grpo)) {
            return response()->json(['message' => 'No orders Bin IN'], 404);
        }

        return response()->json($Grpo);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
    }

    public function getGrpoDataDetailOut()
    {
    try {
        $type = '2';  
        $binIn = '01021002-OUT-01';
        $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $binIn, $type);

        if (empty($Grpo)) {
            return response()->json(['message' => 'No orders Bin Out'], 404);
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
        $binTransit = '01021002-TRANSIT';
        $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $binTransit, $type);

        if (empty($Grpo)) {
            return response()->json(['message' => 'No orders in Bin Transit'], 404);
        }

        return response()->json($Grpo);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
    }

    public function getGrpoDataHeaderStatisticWareHouse ()
    {
        try {
            $type = '3';  
            $binInStore = '01021002-STORE-IN';
            $binOutStore = '01021002-STORE-OUT';
            $binTransitStore = '01021002-TRANSIT';        
            $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, '', $type);
            if (empty($Grpo)) {
                return response()->json(['message' => 'No orders found'], 404);
            }
            $GrpoInStore = collect($Grpo)->filter(function ($item) use ($binInStore) {
                return $item->BINLOCATION === strtoupper($binInStore);  
            })->values(); 
            $GrpoOutStore = collect($Grpo)->filter(function ($item) use ($binOutStore) {
                return $item->BINLOCATION === strtoupper($binOutStore);  
            })->values(); 
            $GrpoTransitStore = collect($Grpo)->filter(function ($item) use ($binTransitStore) {
                return $item->BINLOCATION === strtoupper($binTransitStore);  
            })->values(); 

            $onHandInStore = $GrpoInStore->pluck('ONHAND')->first() ?? 0; 
            $onHandOutStore = $GrpoOutStore->pluck('ONHAND')->first() ?? 0; 
            $onHandTransitStore = $GrpoTransitStore->pluck('ONHAND')->first() ?? 0; 
            return response()->json([
                'ONHANDIN' => $onHandInStore,
                'ONHANDOUT' => $onHandOutStore,
                'ONHANDTRANSIT' => $onHandTransitStore,
            ]);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
      
        
    }


    

    public function getGrpoDataDetailINWarehouse()
    {
    try {
        $type = '2';  
        $binIn = '01021002-STORE-IN';
        $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $binIn, $type);

        if (empty($Grpo)) {
            return response()->json(['message' => 'No orders Bin IN'], 404);
        }

        return response()->json($Grpo);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
    }

    public function getGrpoDataDetailOutWarehouse()
    {
    try {
        $type = '2';  
        $binIn = '01021002-STORE-OUT';
        $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $binIn, $type);
        if (empty($Grpo)) {
            return response()->json(['message' => 'No orders Bin Out'], 404);
        }

        return response()->json($Grpo);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
    }

    public function getGrpoDataDetailTransitWarehouse()
    {
    try {
        $type = '2';  
        $binTransit = '01021002-TRANSIT';
        $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $binTransit, $type);

        if (empty($Grpo)) {
            return response()->json(['message' => 'No orders in Bin Transit'], 404);
        }

        return response()->json($Grpo);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
    }

    public function getGrpoDataHeaderStatisticWarehouseBinLate()
    {
        try {
            $type = '4';  
            
            // Ambil data GRPO berdasarkan warehouse dan type
            $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, '', $type);
            
            if (empty($Grpo)) {
                return response()->json(['message' => 'No orders found'], 404);
            }
    
            return response()->json([
                'data' => $Grpo
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getGrpoStatisticWarehouseDetailBinInLate()
    {
        try {
            $type = '5';
            
            $binIn = '01021002-STORE-IN';
          //  $binIn = '01003001-IN-01';
            
           
            $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $binIn, $type);
            
            if (empty($Grpo)) {
                return response()->json(['message' => 'No orders found'], 404);
            }
    
            return new getGrpoWarehouseKaliurangResource(true, 'Data Detail IN Late', $Grpo);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getGrpoStatisticWarehouseDetailBinOutLate()
        {
            try {
                $type = '5';
                
              $binIn = '01021002-STORE-OUT';
               // $binIn = '01003001-OUT-01';
                
               
                $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $binIn, $type);
                
                if (empty($Grpo)) {
                    return response()->json(['message' => 'No orders found'], 404);
                }
        
                return new getGrpoWarehouseKaliurangResource(true, 'Data Detail OUT Late', $Grpo);
        
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
            }
        }


        public function getGrpoStatisticWarehouseilBinTransitLate()
        {
            try {
                $type = '5';
              
             //   $binIn = '01021002-STORE-IN';
                $binIn = '01021002-TRANSIT';
                
               
                $Grpo = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $binIn, $type);
                
                if (empty($Grpo)) {
                    return response()->json(['message' => 'No orders found'], 404);
                }
        
                return new getGrpoWarehouseKaliurangResource(true, 'Data Detail Transit Late', $Grpo);
        
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
            }  
        }

        public function getItrInDataDetailTransit()
         {
                try {
                $type = '6';  
                $binTransit = '01021002-TRANSIT';
                $ItrInTransit = grpoWarehouseKaliurang::getGrpoWarehouseKaliurang($this->warehouse, $binTransit, $type);

                if (empty($ItrInTransit)) {
                return response()->json(['message' => 'No orders in ITR In Transit'], 404);
                }

                return response()->json($ItrInTransit);
                 } catch (\Exception $e) {
                 return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
                }
        }
}