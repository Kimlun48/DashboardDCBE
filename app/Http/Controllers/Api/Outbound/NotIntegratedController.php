<?php

namespace App\Http\Controllers\Api\Outbound;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Outbound\NotIntegratedResource;
use App\Models\Outbound\NotIntegreted;

class NotIntegratedController extends Controller
{
    protected $data;
    public function __construct()
    {
        $this -> data = NotIntegreted::getNotIntegreted();
    }

    public function index()
    {
        return new NotIntegratedResource(true, 'List data OutBound Not Integrated ', $this->data);
    }
}
