<?php

namespace App\Http\Controllers\Api\Kaliurang\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\kaliurang\warehouse\WarehouseKaliurang;
use App\Http\Resources\kaliurang\warehouse\WarehouseKaliurangResource;

class WarehouseKaliurangController extends Controller
{
    protected $warehouse;
    protected $type;

    public function __construct()
    {
        
         $this -> warehouse = '01021002';
         //$this -> warehouse = '01007001';
    }

    public function getCashCarryPnd()
    {
        try {
            $type = 1;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            if (empty($warehouse)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new WarehouseKaliurangResource(true, 'Data Cash&Carry', $warehouse);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred' . $e->getMessage(),
            ],500);
        }
    }

    public function getDeliveryCustomer()
    {
        try {
            $type = 2;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            if (empty($warehouse)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new WarehouseKaliurangResource(true, 'Data Delivery Customer', $warehouse);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred' . $e->getMessage(),
            ],500);
        }
    }

    public function getItrIn()
    {
        try {
            $type = 3;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            if (empty($warehouse)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new WarehouseKaliurangResource(true, 'Data ITR In', $warehouse);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred' . $e->getMessage(),
            ],500);
        }
    }

    public function getItrOut()
    {
        try {
            $type = 4;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            if (empty($warehouse)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new WarehouseKaliurangResource(true, 'Data ITR Out', $warehouse);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred' . $e->getMessage(),
            ],500);
        }
    }

    public function getCashCarryLate()
    {
        try {
            $type = 11;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            if (empty($warehouse)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new WarehouseKaliurangResource(true, 'Data cash carry late', $warehouse);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred' . $e->getMessage(),
            ],500);
        }
    }

    public function getDeliveryCustomerLate()
    {
        try {
            $type = 21;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            if (empty($warehouse)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new WarehouseKaliurangResource(true, 'Data Delivery customer late', $warehouse);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred' . $e->getMessage(),
            ],500);
        }
    }

    public function getItrInLate()
    {
        try {
            $type = 31;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            if (empty($warehouse)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new WarehouseKaliurangResource(true, 'Data ITR in late', $warehouse);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred' . $e->getMessage(),
            ],500);
        }
    }

    public function getItrOutLate()
    {
        try {
            $type = 41;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            if (empty($warehouse)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new WarehouseKaliurangResource(true, 'Data ITR Out late', $warehouse);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred' . $e->getMessage(),
            ],500);
        }
    }

    public function getCashCarryLateDetail()
    {
        try {
            $type = 111;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item->STATUS === 'LATE'; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data Cash & Carry late detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);

            return new WarehouseKaliurangResource(true, 'Data Cash & Carry late detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getCashCarryOnScheduleDetail()
    {
        try {
            $type = 111;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item->STATUS === 'ON SCHEDULED'; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data Cash & Carry On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data Cash & Carry On Schedule detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function getCashCarryOrderReceived()
    {
        try {
            $type = 111;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item-> OPEN > 0; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data Cash & Carry Order Received detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getCashCarryBeingProcess()
    {
        try {
            $type = 111;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item-> RELEASED > 0; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data Cash & Carry Being Process detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getCashCarryReadyPickup()
    {
        try {
            $type = 111;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item-> PICKED > 0; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data Cash & Carry ready pickup detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getDeliveryCustomerLateDetail()
    {
        try {
            $type = 211;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item->STATUS === 'LATE'; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data Delivery Customer late detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data Delivery Customer late detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getDeliveryCustomerOnScheduleDetail()
    {
        try {
            $type = 211;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item->STATUS === 'ON SCHEDULED'; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data Delivery Customer on schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data Delivery Customer on schedule detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getDeliveryCustomerOrderReceived()
    {
        try {
            $type = 211;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item-> OPEN > 0; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data Delivery Customer Order Received detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getDeliveryCustomerBeingProcess()
    {
        try {
            $type = 211;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item-> RELEASED > 0; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data Delivery Customer Being Process detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getDeliveryCustomerReadyPickup()
    {
        try {
            $type = 211;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item-> PICKED > 0; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data Delivery Customer ready pickup detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function getItrInLateDetail()
    {
        try {
            $type = 311;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item->STATUS === 'LATE'; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In late detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);

            return new WarehouseKaliurangResource(true, 'Data ITR In late detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getItrInOnScheduleDetail()
    {
        try {
            $type = 311;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item->STATUS === 'ON SCHEDULED'; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data ITR In On Schedule detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getItrInOrderReceived()
    {
        try {
            $type = 311;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item-> OPEN > 0; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data ITR In Order Received detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getItrInBeingProcess()
    {
        try {
            $type = 311;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item-> RELEASED > 0; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data ITR In Being Process detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getItrInReadyPickup()
    {
        try {
            $type = 311;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item-> PICKED > 0; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data ITR In ready pickup detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getItrOutLateDetail()
    {
        try {
            $type = 411;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item->STATUS === 'LATE'; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR Out Late detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data ITR Out Late detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getItrOutOnScheduleDetail()
    {
        try {
            $type = 411;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item->STATUS === 'ON SCHEDULED'; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR Out On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data ITR Out On Schedule detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getItrOutOrderReceived()
    {
        try {
            $type = 411;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item-> OPEN > 0; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data ITR Out Order Received detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getItrOutBeingProcess()
    {
        try {
            $type = 411;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item-> RELEASED > 0; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data ITR Out Being Process detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getItrOutReadyPickup()
    {
        try {
            $type = 411;
            $warehouse = WarehouseKaliurang::getWarehouseKaliurang($this->warehouse, $type);
            
            $filteredWarehouse = collect($warehouse)->filter(function ($item) {
                return $item-> PICKED > 0; 
            });
    
            if ($filteredWarehouse->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredWarehouse->values()->all() 
            // ]);
            return new WarehouseKaliurangResource(true, 'Data ITR Out ready pickup detail',  $filteredWarehouse->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
