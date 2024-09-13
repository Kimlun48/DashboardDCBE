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
}
