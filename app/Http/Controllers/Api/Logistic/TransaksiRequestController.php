<?php

namespace App\Http\Controllers\Api\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logistic\TransaksiRequest;
//usees

class TransaksiRequestController extends Controller
{
    public function index()
    {
        try {
            $transaksirequest = TransaksiRequest::all();
            return response()->json([
                'success' => true ,
                'data' => $transaksirequest,
            ], 200);
        } catch (\Exception $e) {
            return response() -> json([
                'success' => false,
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
