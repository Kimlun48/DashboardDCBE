<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CpsResource;
use Illuminate\Http\Request;
use App\Models\CpsV2;
use App\Http\Resources\CpsV2Resource;


class Cpsv2Controller extends Controller
{
    public function index(){
        $data = CpsV2::getCpsV2();
        return new CpsResource(true, 'LIST DATA CSP', $data);
    }
}
