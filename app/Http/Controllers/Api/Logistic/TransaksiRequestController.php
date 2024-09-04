<?php

namespace App\Http\Controllers\Api\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logistic\TransaksiRequest;
use Illuminate\Support\Facades\Validator;
//usees
use Carbon\Carbon;

class TransaksiRequestController extends Controller
{
    public function index()
    {
        try {
            $transaksirequests = TransaksiRequest::with('schedule')->orderBy('updated_at', 'desc')->get();
               
    
            return response()->json([
                'success' => true,
                'data' => $transaksirequests,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show ($id_jadwal) 
    {
        //$transaksirequest = TransaksiRequest::find($id_jadwal);
        $transaksirequests = TransaksiRequest::with('schedule')->where('id_jadwal', $id_jadwal)->get();
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

    public function update(Request $request, $id_jadwal)
    {
        
        $validator = Validator::make($request->all(), [
            'surat_jalan' => 'required|string',
            'nama_kendaraan' => 'required|string',
            'nama_vendor' => 'required|string',
            'slot_req' => 'required|int',
            'sopir' => 'required|string',
            'status' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
           
            $transaksirequests = TransaksiRequest::findOrFail($id_jadwal);
            $transaksirequests->update([
                'surat_jalan' => $request->surat_jalan,
                'nama_kendaraan' => $request->nama_kendaraan,
                'nama_vendor' => $request->nama_vendor,
                'slot_req' => $request->slot_req,
                'sopir' => $request->sopir,
                'status' => $request->status,
                'date_arrived' => $request->date_arrived,
                'date_completed' => $request->date_completed,
                'date_loading_goods' => $request->date_loading_goods
            ]);
    
            // Kembalikan respons sukses
            return response()->json([
                'success' => true,
                'message' => 'Update data success',
                'data' => $transaksirequests
            ], 200);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Master hour not found',
                'errors' => $e->getMessage()
            ], 404);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function updatescanqrCodeInbound(Request $request, $id_jadwal) {

        $transaksirequests = TransaksiRequest::where('id_jadwal', $id_jadwal)->first();

    if (!$transaksirequests) {
        return response()->json([
            'success' => false,
            'message' => 'ID Boking not found',
        ], 404);
    } 

    if ($transaksirequests->date_loading_goods) {
        return response()->json([
            'success' => false,
            'message' => 'Date Arrived is already set and cannot be updated',
        ], 400);
    }
 
    $transaksirequests->update([
        'status' => 'ONLOAD',
        'date_loading_goods' => $request->date_loading_goods,
        // 'date_arrived' => now(),
    ]);
 
    return response()->json([
        'success' => true,
        'message' => 'Update data success',
        'data' => $transaksirequests
    ], 200);
    }

    public function updatescanqrCode(Request $request, $id_jadwal) {

        $transaksirequests = TransaksiRequest::where('id_jadwal', $id_jadwal)->first();

    if (!$transaksirequests) {
        return response()->json([
            'success' => false,
            'message' => 'ID Boking not found',
        ], 404);
    } 

    if ($transaksirequests->date_arrived) {
        return response()->json([
            'success' => false,
            'message' => 'Date Arrived is already set and cannot be updated',
        ], 400);
    }
 
    $transaksirequests->update([
        'status' => 'ARRIVED',
        'date_arrived' => $request->date_arrived,
        // 'date_arrived' => now(),
    ]);
 
    return response()->json([
        'success' => true,
        'message' => 'Update data success',
        'data' => $transaksirequests
    ], 200);
    }
        
        // $transaksirequests = TransaksiRequest::where('id_jadwal', $id_jadwal)->first();

        // if (!$transaksirequests) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Transaksi not found',
        //     ], 404);
        // } 
    
        
        // $status = $request->input('status');
    
        
        // if (!in_array($status, ['ARRIVED', 'COMPLETED', 'LOADING'])) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Invalid status',
        //     ], 400);
        // }
    
        
        // $transaksirequests->update([
        //     'status' => $status,
        //     'date_arrived' => $status === 'ARRIVED' ? now() : $transaksirequests->date_arrived,
        //     'date_completed' => $status === 'COMPLETED' ? now() : $transaksirequests->date_completed,
        //     'date_loading_goods' => $status === 'LOADING' ? now() : $transaksirequests->date_loading_goods,
        // ]);
    
        
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Update data success',
        //     'data' => $transaksirequests
        // ], 200);

        // $validator = Validator::make($request->all(), [
        //     'id_jadwal' => 'required',
           
        // ]);
    
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
    



}
