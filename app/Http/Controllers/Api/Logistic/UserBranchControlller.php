<?php

namespace App\Http\Controllers\Api\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logistic\UserBranch;
use App\Http\Resources\UserBranchResource;

class UserBranchControlller extends Controller
{
    // public function index()
    // {
    //     try {
    //         $userbranch = UserBranch::orderBy('PrcName', 'desc')->get();
    //         return response()->json([
    //             'success' => true,
    //             'data' => $userbranch,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Filed to retrieve data',
    //             'error' => $e->getMessage()
    //         ],500);
    //     }
    // }
    protected $data;

    public function __construct()
    {
        $this->data = UserBranch::getUserBranch();
    }

    public function index()
    {
         return new UserBranchResource(true, 'List Data Crossdock', $this->data);
    }
}
