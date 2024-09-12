<?php

namespace App\Http\Controllers\Api\Kaliurang\Inbound;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\kaliurang\inbound\CashStoreKaliurang;

class CashStoreController extends Controller
{
    protected $warehouse;
    public function __construct()
    {
         // $this -> warehouse = '01003001';//a.yani
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
            return response() -> json($cashstore);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An Error occured:' . $e->getMessage()], 500);
        }
    }

}
