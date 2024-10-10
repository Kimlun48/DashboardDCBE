<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    // public function __invoke()
    // {
    //     $permission = Permission::when(request()->q, function($permission) {
    //         $permission = $permission->where('name', 'like', '%'. request()->q. '%');
    //     })->latest()->pagnation(5);

    //     $permission -> appends(['q'=>request()->q]);

    //     return response()->json([
    //         'success' => true,
    //         'data' => $permission,
    //     ], 200);
    // }

    // public function __invoke()
    // {
    //     // Fetch permission with optional search query and pagination
    //     $permission = Permission::when(request()->q, function($query) {
    //         return $query->where('name', 'like', '%'. request()->q . '%');
    //     })->latest()->paginate(5);

    //     // Append query parameter to the pagination links
    //     $permission->appends(['q' => request()->q]);

    //     return response()->json([
    //         'success' => true,
    //         'data' => $permission,
    //     ], 200);
    // }

    public function __invoke(Request $request)
    {
       

        // Mengambil permission dengan pencarian berdasarkan query
        $permissions = Permission::when($request->q, function ($query) {
            return $query->where('name', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        // Menambahkan parameter query ke pagination
        $permissions->appends(['q' => $request->q]);

        return response()->json([
            'success' => true,
            'data' => $permissions,
        ], 200);


        // $permissions = Permission::when($request->q, function ($query) {
        //     return $query->where('name', 'like', '%' . request()->q . '%');
        // })->latest()->get(); // Ganti paginate(5) dengan get()
    
        // return response()->json([
        //     'success' => true,
        //     'data' => $permissions,
        // ], 200);
    }
}
