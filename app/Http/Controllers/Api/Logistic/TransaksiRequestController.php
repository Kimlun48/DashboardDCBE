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

    public function showsechedule($id_jadwal)
    {
        //$transaksirequest = TransaksiRequest::find($id_jadwal);//
        $transaksirequests = TransaksiRequest::with('schedule1')->where('id_jadwal', $id_jadwal)->get();
        if ($transaksirequests) {
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

    public function show($id_req)
    {
        //$transaksirequest = TransaksiRequest::find($id_jadwal);//
        $transaksirequests = TransaksiRequest::with('schedule')->where('id_req', $id_req)->get();
        if ($transaksirequests) {
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



    public function updatescanqrCodeInbound($id_req)
    {

        $transaksirequests = TransaksiRequest::where('id_req', $id_req)->first();

        if (!$transaksirequests) {
            return response()->json([
                'success' => false,
                'message' => 'Booking ID not found',
            ], 404);
        }

        $scheduleStart = Carbon::parse($transaksirequests->schedule->mulai);
        $now = Carbon::now('Asia/Jakarta');
        $differenceInMinutes = $scheduleStart->diffInMinutes($now, false);
        $today = Carbon::today()->format('Y-m-d');
        $statusCi = 'CI INBOUND';

        Log::info('Hari Jadwal (schedule->hari): ' . $transaksirequests->schedule->hari);
        Log::info('Hari Ini: ' . $today);

        // if ($transaksirequests->schedule->hari !== $today) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Transaction can only be updated on the scheduled day',
        //     ], 400);
        // }

        // Cek apakah date_arrived kosong
        if (is_null($transaksirequests->date_arrived)) {
            return response()->json([
                'success' => false,
                'message' => 'Please scan on security first before proceeding to inbound',
            ], 400);
        }


        if (
            $transaksirequests->date_arrived && $transaksirequests->date_completed &&
            $transaksirequests->date_loading_goods && $transaksirequests->date_checkout_security
        ) {
            return response()->json([
                'success' => false,
                'message' => 'All stages are completed, no further updates allowed.',
            ], 400);
        }

        if (
            $transaksirequests->date_arrived && $transaksirequests->date_completed &&
            $transaksirequests->date_loading_goods
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Please scan on security to CO SECURITY.',
            ], 400);
        }


        if (
            $transaksirequests->date_arrived &&
            $transaksirequests->date_loading_goods
        ) {
            $status = 'CO INBOUND';
            $transaksirequests->update([
                'status' => $status,
                'date_completed' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update to CO INBOUND success',
                'data' => $transaksirequests
            ], 200);
        }

        $transaksirequests->update([
            'status' => $statusCi,
            'date_loading_goods' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Update to CI INBOUND success',
            'data' => $transaksirequests
        ], 200);
    }


    // public function updatescanqrCodeSecurity(Request $request, $id_req)
    // {
    //     $transaksirequests = TransaksiRequest::with('schedule')->where('id_req', $id_req)->first();

    //     if (!$transaksirequests) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Booking ID not found',
    //         ], 404);
    //     }

    //     // Cek apakah ada transaksi lain yang memiliki status CI SECURITY
    //     $activeTransactions = TransaksiRequest::where('status', 'CI SECURITY')->where('id_req', '!=', $id_req)->get();

    //     if ($activeTransactions->isNotEmpty()) {
    //         // Ambil ID req dari transaksi yang masih dalam status CI SECURITY
    //         $activeIds = $activeTransactions->pluck('id_req')->implode(', ');

    //         return response()->json([
    //             'success' => false,
    //             'message' => "Booking ID no $id_req must be complete before scanning the next item. Active CI SECURITY IDs: $activeIds.",
    //         ], 400);
    //     }

    //     $scheduleStart = Carbon::parse($transaksirequests->schedule->mulai);
    //     $now = Carbon::now('Asia/Jakarta');
    //     $differenceInMinutes = $scheduleStart->diffInMinutes($now, false);
    //     $today = Carbon::today()->format('Y-m-d');

    //     Log::info('Hari Jadwal (schedule->hari): ' . $transaksirequests->schedule->hari);
    //     Log::info('Hari Ini: ' . $today);



    //     if ($transaksirequests->schedule->hari !== $today) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Transaction can only be updated on the scheduled day',
    //         ], 400);
    //     }

    //     if ($differenceInMinutes > 30) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Update can only be done within 30 minutes before the scheduled time.',
    //         ], 400);
    //     }


    //     if (
    //         $transaksirequests->date_arrived && $transaksirequests->date_completed &&
    //         $transaksirequests->date_loading_goods && $transaksirequests->date_checkout_security
    //     ) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'All stages are completed, no further updates allowed.',
    //         ], 400);
    //     }

    //     $status = 'CI SECURITY';

    //     // $scheduleStart = Carbon::parse($transaksirequests->schedule->mulai);
    //     // $now = Carbon::now('Asia/Jakarta');
    //     // $differenceInMinutes = $scheduleStart->diffInMinutes($now, false);
    //     //Log::info('Waktu mulai jadwal: ' . $scheduleStart);
    //     //Log::info('Waktu sekarang: ' . $now);
    //     //Log::info('Selisih waktu (dalam menit): ' . $differenceInMinutes);

    //     if (
    //         $transaksirequests->date_arrived && $transaksirequests->date_completed &&
    //         $transaksirequests->date_loading_goods
    //     ) {
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

    public function showVendor($id_req)
    {
        //$transaksirequest = TransaksiRequest::find($id_jadwal);//
        $transaksirequests = TransaksiRequest::with('schedule')->where('id_req', $id_req)->get();
        if ($transaksirequests) {
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

    public function updatescanqrCodeSecurity(Request $request, $id_req)
    {
        // Ambil transaksi berdasarkan ID booking
        $transaksirequests = TransaksiRequest::with('schedule')->where('id_req', $id_req)->first();

        // Jika Booking ID tidak ditemukan
        if (!$transaksirequests) {
            return response()->json([
                'success' => false,
                'message' => 'Booking ID not found',
            ], 404);
        }

        // Cek apakah ada transaksi lain yang memiliki status CI SECURITY
        $activeTransactions = TransaksiRequest::where('status', 'CI SECURITY')->where('id_req', '!=', $id_req)->get();

        if ($activeTransactions->isNotEmpty()) {
            // Ambil ID req dari transaksi yang masih dalam status CI SECURITY
            $activeIds = $activeTransactions->pluck('id_req')->implode(', ');

            return response()->json([
                'success' => false,
                'message' => "Booking ID no : $activeIds must be complete before scanning the next item",
            ], 400);
        }

        // Validasi tanggal dan waktu
        $scheduleStart = Carbon::parse($transaksirequests->schedule->mulai);
        $now = Carbon::now('Asia/Jakarta');
        $differenceInMinutes = $scheduleStart->diffInMinutes($now, false);
        $today = Carbon::today()->format('Y-m-d');

        // Cek apakah transaksi bisa diperbarui berdasarkan jadwal
        if ($transaksirequests->schedule->hari !== $today) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction can only be updated on the scheduled day',
            ], 400);
        }

        // Cek jika sudah melewati waktu mulai
        // if ($now->greaterThan($scheduleStart)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Update not allowed as the schedule start time has already passed.',
        //     ], 403);
        // }

        // Validasi hanya dalam 30 menit sebelum waktu mulai
        if ($differenceInMinutes < 0 || $differenceInMinutes <= 30) {
            return response()->json([
                'success' => false,
                'message' => 'Update can only be done within 30 minutes before the scheduled time.',
            ], 400);
        }

        // Cek status dan tanggal untuk memperbarui status
        if ($transaksirequests->date_checkout_security) {
            return response()->json([
                'success' => false,
                'message' => 'All stages are completed, no further updates allowed.',
            ], 400);
        }

        // Logika status untuk memperbarui tahap
        if ($transaksirequests->date_arrived) {
            // Jika sudah tiba, update ke CO SECURITY
            if ($transaksirequests->date_loading_goods) {
                $transaksirequests->update([
                    'status' => 'CO SECURITY',
                    'date_checkout_security' => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Update to CO SECURITY success',
                    'data' => $transaksirequests,
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Date CI Security is already set and cannot be updated',
            ], 400);
        }

        // Jika belum tiba, update ke CI SECURITY
        $transaksirequests->update([
            'status' => 'CI SECURITY',
            'date_arrived' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Update to CI SECURITY success',
            'data' => $transaksirequests,
        ], 200);
    }


    public function updateStatusScan(Request $request, $id_req)
    {
        $transaksiRequest = TransaksiRequest::where('id_req', $id_req)->first();

        if (!$transaksiRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Booking ID not found',
            ], 404);
        }

        $newStatus = $request->status;
        $currentDateTime = $request->currentDateTime;

        switch ($newStatus) {
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
    public function updateStatusScanAll($id_req)
    {
        $transaksiRequest = TransaksiRequest::where('id_req', $id_req)->first();

        if (!$transaksiRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Booking ID not found',
            ], 404);
        }

        $currentDateTime = Carbon::now('Asia/Jakarta');

        // Update status berdasarkan status saat ini
        switch ($transaksiRequest->status) {
            case 'RESERVED':
                $transaksiRequest->update([
                    'status' => 'CI SECURITY',
                    'date_arrived' => $currentDateTime,
                ]);
                $message = 'Updated to CI SECURITY';
                break;

            case 'CI SECURITY':
                $transaksiRequest->update([
                    'status' => 'CI INBOUND',
                    'date_loading_goods' => $currentDateTime,
                ]);
                $message = 'Updated to CI INBOUND';
                break;

            case 'CI INBOUND':
                $transaksiRequest->update([
                    'status' => 'CO INBOUND',
                    'date_completed' => $currentDateTime,
                ]);
                $message = 'Updated to CO INBOUND';
                break;

            case 'CO INBOUND':
                $transaksiRequest->update([
                    'status' => 'CO SECURITY',
                    'date_checkout_security' => $currentDateTime,
                ]);
                $message = 'Updated to CO SECURITY';
                break;

            default:
                return response()->json([
                    'success' => false,
                    'message' => 'All stages are completed, no further updates allowed.',
                ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $transaksiRequest
        ], 200);
    }




    public function logdoc()
    {
        try {
            $transaksiRequest = TransaksiRequest::with('logdoc')->orderBy('id_req', 'desc')->get();
            // return new LogisticDocUploadResource(true, 'Data Log Doc', $logisticdocupload);
            return response()->json([
                'success' => true,
                'data' => $transaksiRequest,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function sechedulelogdoc($id_req)
    {
        //$transaksirequest = TransaksiRequest::find($id_jadwal);//
        $transaksirequests = TransaksiRequest::with('logdoc')->where('id_req', $id_req)->get();
        if ($transaksirequests) {
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



    // public function updatescanqrCodeInbound(Request $request, $id_req) {

    //     $transaksirequests = TransaksiRequest::where('id_req', $id_req)->first();

    // if (!$transaksirequests) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Booking ID not found',
    //     ], 404);
    // } 

    // if ($transaksirequests->date_loading_goods) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Date CI Security is already set and cannot be updated',
    //     ], 400);
    // }

    // $transaksirequests->update([
    //     'status' => 'CI INBOUND',
    //     'date_loading_goods' => $request->date_loading_goods,
    //     'date_arrived' => now(),
    // ]);

    // return response()->json([
    //     'success' => true,
    //     'message' => 'Update data success',
    //     'data' => $transaksirequests
    // ], 200);
    // }



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

    // public function updatescanqrCode(Request $request, $id_req) {

    //     // Cari transaksi berdasarkan id_req
    //     $transaksirequests = TransaksiRequest::with('schedule')->where('id_req', $id_req)->first();

    //     // Jika transaksi tidak ditemukan
    //     if (!$transaksirequests) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Booking ID not found',
    //         ], 404);
    //     }

    //     // Ambil tanggal hari ini
    //     $today = Carbon::today()->format('Y-m-d');

    //     // Validasi apakah schedule.hari adalah hari ini
    //     if ($transaksirequests->schedule->hari !== $today) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Transaction can only be updated on the scheduled day',
    //         ], 400);
    //     }

    //     // Cek apakah user sedang mencoba meng-update status menjadi CI SECURITY
    //     $status = 'CI SECURITY';
    //     if ($request->status === $status) {
    //         // Ambil waktu mulai dari jadwal
    //         $scheduleStart = Carbon::parse($transaksirequests->schedule->mulai);

    //         // Waktu sekarang
    //         $now = Carbon::now('Asia/Jakarta'); // Sesuaikan timezone jika diperlukan

    //         // Hitung selisih waktu antara sekarang dan waktu mulai
    //         $differenceInMinutes = $scheduleStart->diffInMinutes($now, false);

    //         // Jika sudah melewati waktu mulai, kembalikan error
    //         if ($now->greaterThan($scheduleStart)) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Update not allowed after the schedule start time.',
    //             ], 403);
    //         }

    //         // Jika kurang dari 30 menit sebelum mulai, kembalikan error
    //         if ($differenceInMinutes < 30 && $differenceInMinutes >= 0) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Update is only allowed more than 30 minutes before the schedule starts.',
    //             ], 403);
    //         }

    //         // Jika date_arrived sudah ada, kembalikan pesan error
    //         if ($transaksirequests->date_arrived) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Date CI Security is already set and cannot be updated',
    //             ], 400);
    //         }

    //         // Update status dan date_arrived
    //         $transaksirequests->update([
    //             'status' => $status,
    //             'date_arrived' => now(),
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Update to CI SECURITY success',
    //             'data' => $transaksirequests
    //         ], 200);
    //     }

    //     // Cek apakah semua tahap sudah diselesaikan
    //     if ($transaksirequests->date_arrived && $transaksirequests->date_completed && 
    //         $transaksirequests->date_loading_goods && $transaksirequests->date_checkout_security) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'All stages are completed, no further updates allowed.',
    //         ], 400);
    //     }

    //     // Jika date_arrived, date_completed, dan date_loading_goods sudah ada, maka update ke CO SECURITY
    //     if ($transaksirequests->date_arrived && $transaksirequests->date_completed && 
    //         $transaksirequests->date_loading_goods) {
    //         $status = 'CO SECURITY';

    //         // Update status dan date_checkout_security
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

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Invalid status update request',
    //     ], 400);
    // }
}
