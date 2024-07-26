<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DashIndbound;
use App\Http\Resources\DashInboundResource;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashInboundController extends Controller
{
    public function index()
    {
        $data = DashIndbound::getDashInbound();
        return new DashInboundResource(true, 'LIST DATA DASHBOARD INBOUND', $data);
    }
}
