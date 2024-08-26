<?php

namespace App\Http\Controllers\Api\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logistic\TransaksiRequest;
use Illuminate\Support\Facades\Validator;
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

    public function update(Request $request, $id_req)
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
           
            $transaksirequests = TransaksiRequest::findOrFail($id_req);
            $transaksirequests->update([
                'surat_jalan' => $request->surat_jalan,
                'nama_kendaraan' => $request->nama_kendaraan,
                'nama_vendor' => $request->nama_vendor,
                'slot_req' => $request->slot_req,
                'sopir' => $request->sopir,
                'status' => $request->status,
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
}
