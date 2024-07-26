<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlertCash;
use App\Http\Resources\AlertCashResource;

class AlertCashController extends Controller
{
    public function index (){
        $data = AlertCash::getAlertCash();
        return new AlertCashResource(true, 'List Data CashAlert', $data);
        
    }
}
