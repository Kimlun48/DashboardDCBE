<?php

namespace App\Http\Controllers\Api\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logistic\MasterHour;
use Illuminate\Support\Facades\Validator;


class MasterHourController extends Controller
{
    public function index ()
    {
        try {
            $masterhour = MasterHour::all();
            return response()->json([
                'success' => true,
                'data' => $masterhour,
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data',
                'erros'=> $e -> getMessage()
            ],500);
        }
    }

    public function hour () {
        $masterhour = MasterHour::distinct()->get(['jenis_jam']);
        return response()->json([
            'success' => true,
            'data' => $masterhour,
        ],200);
    }

    public function store(Request $request)

    {
    $validator = Validator::make($request->all(), [
        'mulai' => 'required|date_format:H:i',
        'akhir' => 'required|date_format:H:i',
        'jenis_aktivitas' => 'required|string',
        'status' => 'required|string',
        'slot' => 'required|integer',
        'jenis_jam' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        $masterhour = MasterHour::create([
            'mulai' => $request->mulai,
            'akhir' => $request->akhir,
            'jenis_aktivitas' => $request->jenis_aktivitas,
            'status' => $request->status,
            'slot' => $request->slot,
            'jenis_jam' => $request->jenis_jam,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Insert data success',
            'data' => $masterhour
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to insert data',
            'errors' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $masterhour = MasterHour::find($id);
        if ($masterhour){
            return response()->json([
                'success' => true,
                'data' => $masterhour,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'data not found',
        ], 404);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'mulai' => 'required|date_format:H:i:s',
            'akhir' => 'required|date_format:H:i:s',
            'jenis_aktivitas' => 'required|string',
            'status' => 'required|string',
            'slot' => 'required|integer',
            'jenis_jam' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
           
            $masterhour = MasterHour::findOrFail($id);
            $masterhour->update([
                'mulai' => $request->mulai,
                'akhir' => $request->akhir,
                'jenis_aktivitas' => $request->jenis_aktivitas,
                'status' => $request->status,
                'slot' => $request->slot,
                'jenis_jam' => $request->jenis_jam,
            ]);
    
            // Kembalikan respons sukses
            return response()->json([
                'success' => true,
                'message' => 'Update data success',
                'data' => $masterhour
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
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
           
            $masterhour = MasterHour::findOrFail($id);
            $masterhour->delete();
            return response()->json([
                'success' => true,
                'message' => 'Delete data success'
            ], 200);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
          
            return response()->json([
                'success' => false,
                'message' => 'master time not found',
                'errors' => $e->getMessage()
            ], 404);
            
        } catch (\Exception $e) {
           
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
