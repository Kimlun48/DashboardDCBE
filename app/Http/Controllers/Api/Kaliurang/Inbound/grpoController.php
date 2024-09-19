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
       // $this -> warehouse = '01003001';//a.yani
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
            $binOut = '01021001-OUT-01';        
            $Grpo = grpo::getGrpo($this->warehouse, '', $type);
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

    public function getGrpoDataDetailOut()
    {
    try {
        $type = '2';  
        $binIn = '01021001-OUT-01';
        $Grpo = grpo::getGrpo($this->warehouse, $binIn, $type);

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

    public function getGrpoDataHeaderStatisticStore ()
    {
        try {
            $type = '3';  
            $binInStore = '01021001-STORE-IN';
            $binOutStore = '01021001-STORE-OUT';
            $binTransitStore = '01021001-TRANSIT';        
            $Grpo = grpo::getGrpo($this->warehouse, '', $type);
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
        // try {
        //     $type = '3';  
        //     $binIn = '01021001-STORE-IN';
        //     $Grpo = grpo::getGrpo($this->warehouse, $binIn, $type);
    
        //     if (empty($Grpo)) {
        //         return response()->json(['message' => 'No orders Bin IN'], 404);
        //     }
    
        //     return response()->json($Grpo);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        // }
        
    }

    public function getGrpoDataDetailINStore()
    {
    try {
        $type = '2';  
        $binIn = '01021001-STORE-IN';
        $Grpo = grpo::getGrpo($this->warehouse, $binIn, $type);

        if (empty($Grpo)) {
            return response()->json(['message' => 'No orders Bin IN'], 404);
        }

        return response()->json($Grpo);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
    }

    public function getGrpoDataDetailOutStore()
    {
    try {
        $type = '2';  
        $binIn = '01021001-STORE-OUT';
        $Grpo = grpo::getGrpo($this->warehouse, $binIn, $type);
        if (empty($Grpo)) {
            return response()->json(['message' => 'No orders Bin Out'], 404);
        }

        return response()->json($Grpo);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
    }

    public function getGrpoDataDetailTransitStore()
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

    public function getGrpoDataHeaderStatisticStoreBinLate()
    {
        try {
            $type = '4';  
            
            // Ambil data GRPO berdasarkan warehouse dan type
            $Grpo = grpo::getGrpo($this->warehouse, '', $type);
            
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

    public function getGrpoStatisticStoreDetailBinInLate()
    {
        try {
            $type = '5';
            $warehouse = '01021001';
            $binIn = '01021001-STORE-IN';
          //  $binIn = '01003001-IN-01';
            
           
            $Grpo = grpo::getGrpo($warehouse, $binIn, $type);
            
            if (empty($Grpo)) {
                return response()->json(['message' => 'No orders found'], 404);
            }
    
            return new getgrpoResource(true, 'Data Detail IN Late', $Grpo);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function getGrpoStatisticStoreDetailBinOutLate()
        {
            try {
                $type = '5';
                $warehouse = '01021001';
              $binIn = '01021001-STORE-OUT';
               // $binIn = '01003001-OUT-01';
                
               
                $Grpo = grpo::getGrpo($warehouse, $binIn, $type);
                
                if (empty($Grpo)) {
                    return response()->json(['message' => 'No orders found'], 404);
                }
        
                return new getgrpoResource(true, 'Data Detail OUT Late', $Grpo);
        
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
            }
        }


        public function getGrpoStatisticStoreDetailBinTransitLate()
        {
            try {
                $type = '5';
                $warehouse = '01021001';
             //   $binIn = '01021001-STORE-IN';
                $binIn = '01021001-TRANSIT';
                
               
                $Grpo = grpo::getGrpo($warehouse, $binIn, $type);
                
                if (empty($Grpo)) {
                    return response()->json(['message' => 'No orders found'], 404);
                }
        
                return new getgrpoResource(true, 'Data Detail Transit Late', $Grpo);
        
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
            }  
        }
    


    
}
