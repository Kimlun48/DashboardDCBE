<?php

namespace App\Http\Controllers\Api\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logistic\TransaksiRequest;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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

    public function showsechedule ($id_jadwal) 
    {
        //$transaksirequest = TransaksiRequest::find($id_jadwal);//
        $transaksirequests = TransaksiRequest::with('schedule1')->where('id_jadwal', $id_jadwal)->get();
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

    public function show ($id_req) 
    {
        //$transaksirequest = TransaksiRequest::find($id_jadwal);//
        $transaksirequests = TransaksiRequest::with('schedule')->where('id_req', $id_req)->get();
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
                'date_arrived' => $request->date_arrived,
                'date_completed' => $request->date_completed,
                'date_loading_goods' => $request->date_loading_goods,
                'date_checkout_security' => $request->date_checkout_security
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

    public function updatescanqrCodeInbound(Request $request, $id_req) {

        $transaksirequests = TransaksiRequest::where('id_req', $id_req)->first();

    if (!$transaksirequests) {
        return response()->json([
            'success' => false,
            'message' => 'Booking ID not found',
        ], 404);
    } 

    if ($transaksirequests->date_loading_goods) {
        return response()->json([
            'success' => false,
            'message' => 'Date CI Security is already set and cannot be updated',
        ], 400);
    }
 
    $transaksirequests->update([
        'status' => 'CI INBOUND',
        'date_loading_goods' => $request->date_loading_goods,
        'date_arrived' => now(),
    ]);
 
    return response()->json([
        'success' => true,
        'message' => 'Update data success',
        'data' => $transaksirequests
    ], 200);
    }

    

    // public function updatescanqrCode(Request $request, $id_req) {

        
    //     $transaksirequests = TransaksiRequest::where('id_req', $id_req)->first();
    
        
    //     if (!$transaksirequests) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Booking ID not found',
    //         ], 404);
    //     }
    
       
    //     if ($transaksirequests->date_arrived && $transaksirequests->date_completed && $transaksirequests->date_loading_goods && $transaksirequests->date_checkout_security) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'All stages are completed, no further updates allowed.',
    //         ], 400);
    //     }
    
    //     $status = 'CI SECURITY';  
    
        
    //     if ($transaksirequests->date_arrived && $transaksirequests->date_completed && $transaksirequests->date_loading_goods) {
    //         $status = 'CO SECURITY';
    
           
    //         $transaksirequests->update([
    //             'status' => $status,
    //             'date_checkout_security' => now(),
    //         ]);
    
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Update to CO SECURITY success',
    //             'data' => $transaksirequests
    //         ], 200);
    //     }
    
       
    //     if ($transaksirequests->date_arrived) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Date CI Security is already set and cannot be updated',
    //         ], 400);
    //     }
    
        
    //     $transaksirequests->update([
    //         'status' => $status,
    //         'date_arrived' => now(),
    //     ]);
    
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Update to CI SECURITY success',
    //         'data' => $transaksirequests
    //     ], 200);
    // }

    public function showVendor ($id_req) 
    {
        //$transaksirequest = TransaksiRequest::find($id_jadwal);//
        $transaksirequests = TransaksiRequest::with('schedule')->where('id_req', $id_req)->get();
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

    

public function updatescanqrCodeSecurity(Request $request, $id_req) {

   
   
    $transaksirequests = TransaksiRequest::with('schedule')->where('id_req', $id_req)->first();

    $scheduleStart = Carbon::parse($transaksirequests->schedule->mulai);
    $now = Carbon::now('Asia/Jakarta');
    $differenceInMinutes = $scheduleStart->diffInMinutes($now, false);
    $today = Carbon::today()->format('Y-m-d');

    Log::info('Hari Jadwal (schedule->hari): ' . $transaksirequests->schedule->hari);
    Log::info('Hari Ini: ' . $today);

    if (!$transaksirequests) {
        return response()->json([
            'success' => false,
            'message' => 'Booking ID not found',
        ], 404);
    }   
    $today = Carbon::today()->format('Y-m-d');   
    if ($transaksirequests->schedule->hari !== $today) {
        return response()->json([
            'success' => false,
            'message' => 'Transaction can only be updated on the scheduled day',
        ], 400);
    }

    

    if ($transaksirequests->date_arrived && $transaksirequests->date_completed && 
        $transaksirequests->date_loading_goods && $transaksirequests->date_checkout_security) {
        return response()->json([
            'success' => false,
            'message' => 'All stages are completed, no further updates allowed.',
        ], 400);
    }

    $status = 'CI SECURITY';
    
    // $scheduleStart = Carbon::parse($transaksirequests->schedule->mulai);
    // $now = Carbon::now('Asia/Jakarta');
    // $differenceInMinutes = $scheduleStart->diffInMinutes($now, false);
    Log::info('Waktu mulai jadwal: ' . $scheduleStart);
        Log::info('Waktu sekarang: ' . $now);
        Log::info('Selisih waktu (dalam menit): ' . $differenceInMinutes);
    
    if ($transaksirequests->date_arrived && $transaksirequests->date_completed && 
        $transaksirequests->date_loading_goods) {
        $status = 'CO SECURITY';

       
        $transaksirequests->update([
            'status' => $status,
            'date_checkout_security' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Update to CO SECURITY success',
            'data' => $transaksirequests
        ], 200);
    }



   
    if ($transaksirequests->date_arrived) {
        return response()->json([
            'success' => false,
            'message' => 'Date CI Security is already set and cannot be updated',
        ], 400);
    }

    // if ($differenceInMinutes < 30) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Update is only allowed more than 30 minutes before the schedule starts.',
    //     ], 403);
    // }

    //scan jam boking
    // if ($now->greaterThan($scheduleStart)) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Update not allowed after the schedule start time.',
    //     ], 403);
    // }

   
    $transaksirequests->update([
        'status' => $status,
        'date_arrived' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Update to CI SECURITY success',
        'data' => $transaksirequests
    ], 200);
}



    
    
    public function updateStatusScan(Request $request, $id_req) {
        $transaksiRequest = TransaksiRequest::where('id_req', $id_req)->first();
        
        if (!$transaksiRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Booking ID not found',
            ], 404);
        }
        
        $newStatus = $request->status;
        $currentDateTime = $request->currentDateTime; 
        
        switch($newStatus) {
            case 'CI SECURITY':
                if ($transaksiRequest->status !== null) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please scan on security',
                    ], 400);
                }
    
                $transaksiRequest->update([
                    'status' => 'CI SECURITY',
                    'date_arrived' => $currentDateTime,
                ]);
                break;
        
            case 'CI INBOUND':
                if ($transaksiRequest->status !== 'CI SECURITY') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Arr',
                    ], 400);
                }
    
                $transaksiRequest->update([
                    'status' => 'CI INBOUND',
                    'date_loading_goods' => $currentDateTime,
                ]);
                break;
        
            case 'CO INBOUND':
                if ($transaksiRequest->status !== 'CI INBOUND') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Onl',
                    ], 400);
                }
    
                $transaksiRequest->update([
                    'status' => 'CO INBOUND',
                    'date_completed' => $currentDateTime,
                ]);
                break;

            case 'CO SECURITY':
                    if ($transaksiRequest->status !== 'CO INBOUND') {
                        return response()->json([
                            'success' => false,
                            'message' => 'Onl',
                        ], 400);
                    }
        
                    $transaksiRequest->update([
                        'status' => 'CO SECURITY',
                        'date_completed' => $currentDateTime,
                    ]);
                    break;
        
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Status not valid!',
                ], 400);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'data' => $transaksiRequest
        ], 200);
    }


    public function logdoc ()
    {
        try {
            $transaksiRequest = TransaksiRequest::with('logdoc')->orderBy('id_req', 'desc')->get();
            // return new LogisticDocUploadResource(true, 'Data Log Doc', $logisticdocupload);
            return response()->json([
                'success' => true,
                'data' => $transaksiRequest,
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function sechedulelogdoc ($id_req) 
    {
        //$transaksirequest = TransaksiRequest::find($id_jadwal);//
        $transaksirequests = TransaksiRequest::with('logdoc')->where('id_req', $id_req)->get();
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


