<?php

namespace App\Http\Controllers\Api\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logistic\Schedule;
use App\Models\Logistic\MasterHour;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Carbon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index() 
    {
        try {
            $schedule = Schedule::orderBy('id', 'asc')->get();
            
            return response()->json([
                'success' => true,
                'data' => $schedule
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // public function showScedule() 
    // {
    //     try {
    //         $schedule = Schedule::with('transaksiRequest1')->orderBy('id', 'asc')->get();
            
    //         return response()->json([
    //             'success' => true,
    //             'data' => $schedule
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to retrieve data',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function showSchedule() 
{
    try {
        $schedule = Schedule::with(['transaksiRequest1' => function($query) {
            $query->first();
        }])->orderBy('id', 'asc')->get();

        // Untuk memastikan transaksi_request1 tidak dalam bentuk array
        $schedule->each(function($item) {
            $item->transaksi_request1 = $item->transaksiRequest1->first();
        });
        
        return response()->json([
            'success' => true,
            'data' => $schedule
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to retrieve data',
            'error' => $e->getMessage()
        ], 500);
    }
}

    

    // public function generateSchedule(Request $request)
    // {
    //     $request->validate([
    //         'slot' => 'required|integer',
    //         'jenis_jam' => 'required|string',
    //         'monthyear' => 'required|date_format:Y-m',
    //     ]);

    //     $sl = $request->input('slot');
    //     $jm = $request->input('jenis_jam');
    //     $gt = $request->input('monthyear');
    //     $thn = substr($gt, 0, 4);
    //     $bln = substr($gt, 5, 2);
    //     $jmlh = 0;

    //     // Mulai transaksi
    //     DB::transaction(function () use ($thn, $bln, $jm, $sl, &$jmlh) {
    //         // Ambil data dari MasterHour berdasarkan jenis_jam
    //         $listjam = MasterHour::where('jenis_jam', $jm)
    //             ->get(['mulai', 'akhir', 'jenis_aktivitas']);

    //         // Generate schedule berdasarkan jumlah hari dalam bulan
    //         for ($yy = 1; $yy <= Carbon::create($thn, $bln)->daysInMonth; $yy++) {
    //             foreach ($listjam as $jj) {
    //                 $jmlh++;
    //                 Schedule::create([
    //                     'hari' => Carbon::create($thn, $bln, $yy)->format('Y-m-d'),
    //                     'mulai' => $jj->mulai,
    //                     'akhir' => $jj->akhir,
    //                     'jenis_aktivitas' => $jj->jenis_aktivitas,
    //                     'slot' => $sl,
    //                     'available_slot' => $sl,
    //                 ]);
    //             }
    //         }

    //         // Update slot dan available_slot menjadi 0 untuk schedule tertentu
    //         Schedule::where('jenis_aktivitas', '!=', 'ON LOAD')
    //             ->orderBy('id', 'desc')
    //             ->limit($jmlh)
    //             ->update(['slot' => 0, 'available_slot' => 0]);
    //     });

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Generate Schedule Berhasil',
    //     ]);
    // }
    // public function generateSchedule(Request $request)
    // {
       
    //     $validator = Validator::make($request->all(), [
    //         'slot' => 'required|integer',
    //         'jenis_jam' => 'required|string',
    //         'monthyear' => 'required|date_format:Y-m',
    //     ]);

       
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $slot = $request->input('slot');
    //     $jenis_jam = $request->input('jenis_jam');
    //     $monthyear = $request->input('monthyear');

    //     $year = substr($monthyear, 0, 4);
    //     $month = substr($monthyear, 5, 7);

    //     $totalDays = Carbon::createFromDate($year, $month)->daysInMonth;
    //     $totalEntries = 0;

        
    //     $masterHours = MasterHour::where('jenis_jam', $jenis_jam)->get();

        
    //     DB::transaction(function () use ($masterHours, $year, $month, $totalDays, $slot, &$totalEntries) {
    //         for ($day = 1; $day <= $totalDays; $day++) {
    //             foreach ($masterHours as $hour) {
    //                 $totalEntries++;
    //                 Schedule::create([
    //                     'hari' => Carbon::createFromDate($year, $month, $day)->format('Y-m-d'),
    //                     'mulai' => $hour->mulai,
    //                     'akhir' => $hour->akhir,
    //                     'jenis_aktivitas' => $hour->jenis_aktivitas,
    //                     'slot' => $slot,
    //                     'available_slot' => $slot,
    //                 ]);
    //             }
    //         }

           
    //         Schedule::where('jenis_aktivitas', '!=', 'ON LOAD')
    //             ->orderBy('id', 'desc')
    //             ->take($totalEntries)
    //             ->update(['slot' => 0, 'available_slot' => 0]);
    //     });

    //     return response()->json(['message' => 'Generate Schedule Berhasil'], 200);
    // }
    public function generateSchedule(Request $request)
{
    $validator = Validator::make($request->all(), [
        'slot' => 'required|integer',
        'jenis_jam' => 'required|string',
        'monthyear' => 'required|date_format:Y-m',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $slot = $request->input('slot');
    $jenis_jam = $request->input('jenis_jam');
    $monthyear = $request->input('monthyear');

    $year = substr($monthyear, 0, 4);
    $month = substr($monthyear, 5, 7);

    $totalDays = Carbon::createFromDate($year, $month)->daysInMonth;

    $masterHours = MasterHour::where('jenis_jam', $jenis_jam)->get();

    $existingDays = [];
    $available = 'AVAILABLE';
    $off = 'OFF';
   

    DB::transaction(function () use ($masterHours, $year, $month, $totalDays, $slot, $available, $off, &$existingDays) {
        for ($day = 1; $day <= $totalDays; $day++) {
            $hari = Carbon::createFromDate($year, $month, $day)->format('Y-m-d');

            foreach ($masterHours as $hour) {
                $existingSchedule = Schedule::where('hari', $hari)
                    ->exists();

                if ($existingSchedule) {
                    $existingDays[] = $hari;
                    break 2;  // Keluar dari kedua loop jika ditemukan jadwal yang sama
                }
            }
        }

        if (empty($existingDays)) {  // Jika tidak ada jadwal yang sama, buat jadwal baru
            for ($day = 1; $day <= $totalDays; $day++) {
                $hari = Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
                $booked = 0;

                foreach ($masterHours as $hour) {
                    $status = $hour->jenis_aktivitas === 'ON LOAD' ? $available : $off;

                    Schedule::create([
                        'hari' => $hari,
                        'mulai' => $hour->mulai,
                        'akhir' => $hour->akhir,
                        'jenis_aktivitas' => $hour->jenis_aktivitas,
                        'slot' => $status === $available ? $slot : 0,  // Set slot ke 0 jika status off
                        'available_slot' => $status === $available ? $slot : 0,  // Set available_slot ke 0 jika status off
                        'status' => $status,
                        'is_booked' => $booked,
                    ]);
                }
            }

            // Menjaga status schedule yang tidak 'ON LOAD'
            Schedule::where('jenis_aktivitas', '!=', 'ON LOAD')
                ->orderBy('id', 'desc')
                ->update(['slot' => 0, 'available_slot' => 0, 'status' => $off]);
        }
    });

    if (!empty($existingDays)) {
        return response()->json([
            'message' => 'Generate Schedule Failed, Schedule Already Exists',
        ], 409);
    }

    return response()->json(['message' => 'Generate Schedule Berhasil'], 200);
}


}
