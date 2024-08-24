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

    public function show ($id_jadwal) 
    {
        //$transaksirequest = TransaksiRequest::find($id_jadwal);
        $transaksirequests = TransaksiRequest::where('id_jadwal', $id_jadwal)->get();
        if ($transaksirequests){
            return response()->json([
                'success' => true,
                'data' => $transaksirequests,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'data not found',
        ], 404);
    }
}
