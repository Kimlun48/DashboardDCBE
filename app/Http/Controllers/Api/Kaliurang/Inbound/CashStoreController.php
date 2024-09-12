<?php

namespace App\Http\Controllers\Api\Kaliurang\Inbound;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\kaliurang\inbound\CashStoreKaliurang;
use App\Http\Resources\kaliurang\inbound\grpostorecashpndResource;

class CashStoreController extends Controller
{
    protected $warehouse;
    public function __construct()
    {
       //   $this -> warehouse = '01003001';//a.yani
     $this -> warehouse = '01021001';//kaliurang
    }

    public function getCashStore()
    {
        try {
            $cashstore = CashStoreKaliurang::getCashStoreKaliurang($this->warehouse);
            if (empty($cashstore)) {
                return response()->json([
                    'message' => 'No order cash store'
                ], 404);
            }
           
            return new grpostorecashpndResource(true, 'DATA DASHBOARD STORE', $cashstore);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An Error occured:' . $e->getMessage()], 500);
        }
    }

}
