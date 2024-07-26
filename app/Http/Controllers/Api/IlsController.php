<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ils;
use App\Http\Resources\IlsResource;
use App\Http\Resources\ilsLateResource;
use App\Http\Resources\ilsUnLateResource;
use Illuminate\Pagination\LengthAwarePaginator;

class IlsController extends Controller
{
    public function index()
    {
        $data = Ils::orderBy('RECEIVED_DATE', 'desc')->paginate(5);

        //return collection of posts as a resource
        return new IlsResource(true, 'List Data Post', $data);
    }

    public function getIlsPs(Request $request)
    {

        $data = Ils::getIlsSp();
        return new IlsResource(true, 'List Data IlsPS', $data);
    }

    public function getLate(Request $request)
    {
        $data = Ils::getIlsSP();
        $late = $data->where('late', '>', 0);

        return new IlsLateResource(true, 'List Data Ils Late', $late);
    }

    public function getUnLate()
    {

        $data = Ils::getIlsSP();
        $late = $data->where('late', '=', 0);

        return new ilsUnLateResource(true, 'List Data Ils Late', $late);
    }

    public function getStatistics()
    {
        // Ambil data dari metode getIlsSP yang sekarang mengembalikan koleksi
        $data = Ils::getIlsSP();

        // Hitung jumlah item dengan nilai 'late' > 0 dan 'late' = 0
        $late = $data->where('late', '>', 0)->count();
        $unlate = $data->where('late', '=', 0)->count();
        $all = $unlate + $late;

        return response()->json([
            'success' => true,
            'message' => 'Statistik Data',
            'data' => [
                'late' => $late,
                'unlate' => $unlate,
                'all' => $all,
            ],
        ]);
    }
}
