<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inbound\ItrIn;
use App\Models\Inbound\Crossdock;
use App\Models\Inbound\Po;
use App\Models\Inbound\ReturnInbound;
use App\Models\Outbound\ArReserve;
use App\Models\Outbound\ItrOut;
use App\Models\Outbound\SalesOrder;
use App\Models\Storage\CashPicking;
use App\Models\Storage\DeliveryPicking;
use App\Models\Storage\Putaway;
use App\Models\Storage\Replenishment;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
       
    }
}
