<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DashboardStore;
use App\Http\Resources\DashboardStoreResource;
use App\Http\Resources\DashInboundResource;

class DashboardStoreController extends Controller
{
    public function index()
    {
        $data = DashboardStore::GetDashboardStore();
        return new DashInboundResource(true, 'DATA DASHBOARD STORE', $data);
    }
}
