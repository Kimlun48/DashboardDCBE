<?php

namespace App\Http\Controllers\Api\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logistic\Kendaraan;
use Illuminate\Support\Facades\Validator;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $kendaraan = Kendaraan::orderBy('id_kendaraan', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $kendaraan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'Jenis_Kendaraan' => 'required|string',
        'slot_Kendaraan' => 'required|integer',
        'tipe_pallet' => 'required|string',
        'tipe_kendaraan' => 'required|integer',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        // Konversi tipe data yang diperlukan
        $jenisKendaraan = trim($request->Jenis_Kendaraan);
        $slotKendaraan = (int) $request->slot_Kendaraan;
        $tipePallet = trim($request->tipe_pallet);
        $tipeKendaraan = (int) $request->tipe_kendaraan;

        // Cek apakah data sudah ada berdasarkan field yang relevan
        $existingKendaraan = Kendaraan::where('Jenis_Kendaraan', $jenisKendaraan)
            ->where('slot_Kendaraan', $slotKendaraan)
            ->where('tipe_pallet', $tipePallet)
            ->where('tipe_kendaraan', $tipeKendaraan)
            ->first();

        if ($existingKendaraan) {
            return response()->json([
                'success' => false,
                'message' => 'Data already exists',
                'data' => $existingKendaraan
            ], 409); // Menggunakan HTTP 409 Conflict untuk menandakan data sudah ada
        }

        // Jika tidak ada data yang sama, simpan data baru
        $kendaraan = Kendaraan::create([
            'Jenis_Kendaraan' => $jenisKendaraan,
            'slot_Kendaraan' => $slotKendaraan,
            'tipe_pallet' => $tipePallet,
            'tipe_kendaraan' => $tipeKendaraan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Insert data success',
            'data' => $kendaraan
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
    public function show($id_kendaraan)
    {
        $kendaraan = Kendaraan::find($id_kendaraan);
        if ($kendaraan){
            return response()->json([
                'success' => true,
                'data' => $kendaraan,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'data not pound',
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
    public function update(Request $request, $id_kendaraan)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'Jenis_Kendaraan' => 'required|string', // Pastikan tipe data yang benar
        'slot_Kendaraan' => 'required|integer',
        'tipe_pallet' => 'required|string',
        'tipe_kendaraan' => 'required|integer',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        // Temukan kendaraan berdasarkan ID
        $kendaraan = Kendaraan::findOrFail($id_kendaraan);

        // Cek apakah ada kendaraan lain yang memiliki kombinasi data yang sama
        $existingKendaraan = Kendaraan::where('Jenis_Kendaraan', $request->Jenis_Kendaraan)
            ->where('slot_Kendaraan', $request->slot_Kendaraan)
            ->where('tipe_pallet', $request->tipe_pallet)
            ->where('tipe_kendaraan', $request->tipe_kendaraan)
            ->where('id_kendaraan', '!=', $id_kendaraan) // Kecualikan kendaraan yang sedang di-update
            ->first();

        if ($existingKendaraan) {
            return response()->json([
                'success' => false,
                'message' => 'Data already exists for another record',
            ], 409); // Kode HTTP 409: Conflict
        }

        // Perbarui data kendaraan
        $kendaraan->update([
            'Jenis_Kendaraan' => $request->Jenis_Kendaraan,
            'slot_Kendaraan' => $request->slot_Kendaraan,
            'tipe_pallet' => $request->tipe_pallet,
            'tipe_kendaraan' => $request->tipe_kendaraan,
        ]);

        // Kembalikan respons sukses
        return response()->json([
            'success' => true,
            'message' => 'Update data success',
            'data' => $kendaraan
        ], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Kendaraan not found',
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
    public function destroy($id_kendaraan)
    {
        try {
           
            $kendaraan = Kendaraan::findOrFail($id_kendaraan);
            
           
            $kendaraan->delete();
    
            
            return response()->json([
                'success' => true,
                'message' => 'Delete data success'
            ], 200);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
          
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan not found',
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
