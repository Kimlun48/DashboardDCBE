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

//     public function store(Request $request)

//     {
//     $validator = Validator::make($request->all(), [
//         'mulai' => 'required|date_format:H:i',
//         'akhir' => 'required|date_format:H:i',
//         'jenis_aktivitas' => 'required|string',
//         'status' => 'required|string',
//         'slot' => 'required|integer',
//         'jenis_jam' => 'required|string',
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['errors' => $validator->errors()], 422);
//     }

//     try {
//         $masterhour = MasterHour::create([
//             'mulai' => $request->mulai,
//             'akhir' => $request->akhir,
//             'jenis_aktivitas' => 'ON LOAD',
//             'status' => 'AKTIF',
//             'slot' => 1,
//             'jenis_jam' => 'PER_30MNT',
//         ]);

//         return response()->json([
//             'success' => true,
//             'message' => 'Insert data success',
//             'data' => $masterhour
//         ], 201);

//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Failed to insert data',
//             'errors' => $e->getMessage()
//         ], 500);
//     }
// }
public function store(Request $request)
{
    // Validasi input dari frontend
    $validator = Validator::make($request->all(), [
        'jenis_aktivitas' => 'required|string',
        // 'status' => 'required|string',
       // 'slot' => 'required|integer',
        'jenis_jam' => 'required|string',
        'branch' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    try {
        // Tentukan interval berdasarkan input 'jenis_jam'
        switch ($request->jenis_jam) {
            case 'PER_60MNT':
                $interval = new \DateInterval('PT60M');  // Interval 60 menit
                break;
            case 'PER_30MNT':
                $interval = new \DateInterval('PT30M');  // Interval 30 menit
                break;
            case 'PER_15MNT':
                $interval = new \DateInterval('PT15M');  // Interval 15 menit
                break;
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid time interval'
                ], 400);
        }

        // Waktu mulai dan akhir
        $startTime = new \DateTime('08:00');  
        $endTime = new \DateTime('17:00');    

        $times = [];
        $status ="AKTIF";
        $slot = 2;
        
        // Loop untuk setiap interval
        while ($startTime < $endTime) {
            $mulai = $startTime->format('H:i');
            $akhir = $startTime->add($interval)->format('H:i');

            // Buat record untuk setiap interval
            $masterhour = MasterHour::create([
                'mulai' => $mulai,
                'akhir' => $akhir,
                'jenis_aktivitas' => $request->jenis_aktivitas,
                'status' => $status,
                'slot' => $slot,
                'jenis_jam' => $request->jenis_jam,
                'branch' => $request->branch,
            ]);

            $times[] = $masterhour;
        }

        return response()->json([
            'success' => true,
            'message' => 'Insert data success',
            'data' => $times
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
            // 'mulai' => 'required|date_format:H:i',
            // 'akhir' => 'required|date_format:H:i',
            'jenis_aktivitas' => 'required|string',
            // 'status' => 'required|string',
            //'slot' => 'required|integer',
            'jenis_jam' => 'required|string',
            'branch' => 'required|string',
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
                // 'status' => $request->status,
                // 'slot' => $request->slot,
                'jenis_jam' => $request->jenis_jam,
                'branch' => $request->branch,
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
