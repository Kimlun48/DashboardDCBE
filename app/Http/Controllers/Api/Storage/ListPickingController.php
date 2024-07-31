<?php

namespace App\Http\Controllers\Api\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Storage\ListPicking;
use App\Http\Resources\Storage\ListPickingResource;

class ListPickingController extends Controller
{
    protected $data;

    public function __construct()
    {
        $this->data = ListPicking::getListPicking();
    }

    public function index ()
    {
        return new ListPickingResource(true, "Data List Picking", $this->data);
    }
}
