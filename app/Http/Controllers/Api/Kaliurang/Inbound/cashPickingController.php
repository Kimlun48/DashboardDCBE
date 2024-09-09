<?php

namespace App\Http\Controllers\Api\Kaliurang\Inbound;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\kaliurang\inbound\CashPicking;

class cashPickingController extends Controller
{
    protected $warehouse;
    
    public function __construct()
    {
        //$this -> warehouse = '01003001';//a.yani
       $this -> warehouse = '01021001';//kaliurang
    }

    public function getCashPicking ()
    {
        try {
            $cashpicking = CashPicking::getCashPicking($this->warehouse);
            if (empty($cashpicking)) {
                return response()->json(['message' => 'No orders cash picking'], 404);
            }
            return response()->json($cashpicking);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
