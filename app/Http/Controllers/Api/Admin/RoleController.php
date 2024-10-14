<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    
    public function index()
    {

  $role = auth()->user()->getRoleNames();

  try {
    if ($role[0] == 'super_admin'){
        $roles = Role::when(request()->q, function($query) {
            return $query->where('name', 'like', '%' . request()->q . '%');
        })
        ->with('permissions')
        ->orderBy('id', 'asc') 
        ->get(); 
    } else {
        $roles = Role::when(request()->q, function($query) {
            return $query->where('name', 'like', '%' . request()->q . '%');
        }) ->where('id', auth()->user()->id)
        ->with('permissions')
        ->orderBy('id', 'asc') 
        ->get(); 
    }

    return response()->json([
        'success' => true,
        'data' => $roles,
        ], 200);

  } catch (\Throwable $th) {
    return response()->json([
        'error' => 'Failed to find user',
        'message' => $e->getMessage()
    ], 500);
  }
      
    // $roles = Role::when(request()->q, function($query) {
    //     return $query->where('name', 'like', '%' . request()->q . '%');
    // })
    // ->with('permissions')
    // ->orderBy('id', 'asc') 
    // ->get(); 

    // return response()->json([
    // 'success' => true,
    // 'data' => $roles,
    // ], 200);
        
    }



    public function create(Request $request): JsonResponse
    {
        
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

       
        $role = Role::create(['name' => $request->name, 'guard_name' => 'api']);

        return response()->json([
            'success' => true,
            'data' => $role,
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
   
        public function store(Request $request)
    {
    /**
     * Validate request
     */
    $request->validate([
        'name'        => 'required|string|max:255',
        'permissions' => 'required|array', 
        'permissions.*' => 'string', 
    ]);

    try {
       
        $guard_name = 'api';
        $role = Role::create(['name' => $request->name, 'guard_name' => $guard_name]);

        
        $role->givePermissionTo($request->permissions);

        
        return response()->json([
            'success' => true,
            'message' => 'Role created successfully',
            'data'    => $role
        ], 201); 
    } catch (\Exception $e) {
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to create role',
            'error'   => $e->getMessage()
        ], 500); 
    }
}
    

    /**
     * Show the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        
        $role = Role::with('permissions')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $role,
        ]);
    }

    

    public function update(Request $request, Role $role)
    {
        // Validate request
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'required|array',
        ]);
    
        try {
            // Update role
            $role->update([
                'name' => $request->name,
                'guard_name' => 'api',
            ]);
    
            // Sync permissions to role (overwrite existing permissions)
            $role->syncPermissions($request->permissions);
    
            // Return success response as JSON
            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully',
                'data' => $role
            ], 200); // Status 200 untuk OK
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json([
                'success' => false,
                'message' => 'Failed to update role',
                'error' => $e->getMessage()
            ], 500); // Status 500 untuk Server Error
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Temukan role berdasarkan ID
        $role = Role::findOrFail($id);
    
        // Hapus role
        $role->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.',
        ]);
    }

    public function getRole()
    {
        $roles = Role::all();
        return response()->json([
            'success' => true,
            'data' => $roles,
            ], 200);
    }
    
}
