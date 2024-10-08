<?php

namespace App\Http\Controllers\Api\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logistic\LogisticDocUpload;
use App\Http\Resources\Inbound\LogisticDocUploadResource;

class LogisticDocUploadController extends Controller
{
    public function index()
    {
        try {
            $logisticdocupload = LogisticDocUpload::with('transaksiRequest')->orderBy('id', 'desc')->get();
            // return new LogisticDocUploadResource(true, 'Data Log Doc', $logisticdocupload);
            return response()->json([
                'success' => true,
                'data' => $logisticdocupload,
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
