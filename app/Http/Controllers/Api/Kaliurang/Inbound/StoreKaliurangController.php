<?php

namespace App\Http\Controllers\Api\Kaliurang\Inbound;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\kaliurang\inbound\StoreKaliurang;
use App\Http\Resources\kaliurang\inbound\StoreKaliurangResource;

class StoreKaliurangController extends Controller
{
    protected $warehouse;
    protected $type;

    public function __construct()
    {
        $this -> warehouse = '01021001';
    }

    public function getCashCarryPnd()
    {
        try {
            $type = 1;
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            if (empty($store)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new StoreKaliurangResource(true, 'Data Cash&Carry', $store);
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            if (empty($store)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new StoreKaliurangResource(true, 'Data Delivery Customer', $store);
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            if (empty($store)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new StoreKaliurangResource(true, 'Data ITR In', $store);
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            if (empty($store)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new StoreKaliurangResource(true, 'Data ITR Out', $store);
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            if (empty($store)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new StoreKaliurangResource(true, 'Data cash carry late', $store);
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            if (empty($store)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new StoreKaliurangResource(true, 'Data Delivery customer late', $store);
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            if (empty($store)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new StoreKaliurangResource(true, 'Data ITR in late', $store);
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            if (empty($store)){
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
            return new StoreKaliurangResource(true, 'Data ITR Out late', $store);
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            
            $filteredStore = collect($store)->filter(function ($item) {
                return $item->STATUS === 'LATE'; 
            });
    
            if ($filteredStore->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data Cash & Carry late detail',
            //     'data' => $filteredStore->values()->all() 
            // ]);

            return new StoreKaliurangResource(true, 'Data Cash & Carry late detail',  $filteredStore->values()->all() );
            
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            
            $filteredStore = collect($store)->filter(function ($item) {
                return $item->STATUS === 'ON SCHEDULED'; 
            });
    
            if ($filteredStore->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data Cash & Carry On Schedule detail',
            //     'data' => $filteredStore->values()->all() 
            // ]);
            return new StoreKaliurangResource(true, 'Data Cash & Carry On Schedule detail',  $filteredStore->values()->all() );
            
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            
            $filteredStore = collect($store)->filter(function ($item) {
                return $item->STATUS === 'LATE'; 
            });
    
            if ($filteredStore->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data Delivery Customer late detail',
            //     'data' => $filteredStore->values()->all() 
            // ]);
            return new StoreKaliurangResource(true, 'Data Delivery Customer late detail',  $filteredStore->values()->all() );
            
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            
            $filteredStore = collect($store)->filter(function ($item) {
                return $item->STATUS === 'ON SCHEDULED'; 
            });
    
            if ($filteredStore->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data Delivery Customer on schedule detail',
            //     'data' => $filteredStore->values()->all() 
            // ]);
            return new StoreKaliurangResource(true, 'Data Delivery Customer on schedule detail',  $filteredStore->values()->all() );
            
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            
            $filteredStore = collect($store)->filter(function ($item) {
                return $item->STATUS === 'LATE'; 
            });
    
            if ($filteredStore->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In late detail',
            //     'data' => $filteredStore->values()->all() 
            // ]);

            return new StoreKaliurangResource(true, 'Data ITR In late detail',  $filteredStore->values()->all() );
            
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            
            $filteredStore = collect($store)->filter(function ($item) {
                return $item->STATUS === 'ON SCHEDULED'; 
            });
    
            if ($filteredStore->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR In On Schedule detail',
            //     'data' => $filteredStore->values()->all() 
            // ]);
            return new StoreKaliurangResource(true, 'Data ITR In On Schedule detail',  $filteredStore->values()->all() );
            
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            
            $filteredStore = collect($store)->filter(function ($item) {
                return $item->STATUS === 'LATE'; 
            });
    
            if ($filteredStore->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR Out Late detail',
            //     'data' => $filteredStore->values()->all() 
            // ]);
            return new StoreKaliurangResource(true, 'Data ITR Out Late detail',  $filteredStore->values()->all() );
            
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
            $store = StoreKaliurang::getStoreKaliurang($this->warehouse, $type);
            
            $filteredStore = collect($store)->filter(function ($item) {
                return $item->STATUS === 'ON SCHEDULED'; 
            });
    
            if ($filteredStore->isEmpty()) {
                return response()->json([
                    'message' => 'No Order Found',
                ], 404);
            }
    
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Data ITR Out On Schedule detail',
            //     'data' => $filteredStore->values()->all() 
            // ]);
            return new StoreKaliurangResource(true, 'Data ITR Out On Schedule detail',  $filteredStore->values()->all() );
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }



}
