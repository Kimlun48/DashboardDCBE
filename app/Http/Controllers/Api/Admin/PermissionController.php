<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    

    public function __invoke(Request $request)
    {

        $permissions = Permission::when($request->q, function ($query) {
            return $query->where('name', 'like', '%' . request()->q . '%');
        })
        ->orderBy('id', 'asc') 
        ->get();

    
        return response()->json([
            'success' => true,
            'data' => $permissions,
        ], 200);
    }

    public function store(Request $request)
    {
    $this->validate($request, [
        'name' => 'required|string|max:255|unique:permissions,name',
      
    ]);

   
    $guard_name = "api";
    $permission = Permission::create([
        'name' => $request->name,
        'guard_name' => $guard_name,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Permission created successfully.',
        'data' => $permission,
    ], 201);
    }

    public function destroy($id)
    {
       
        try {
            $permission = Permission::findOrFail($id);
    
            $permission->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Permission deleted successfully.',
            ], 200); 
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting permission: ' . $e->getMessage(),
            ], 500); 
        }
    }

    public function update(Request $request, $id)
{
   
    $this->validate($request, [
        'name' => 'required|string|max:255|unique:permissions,name,' . $id,
    ]);

    try {
      
        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->save();

        return response()->json([
            'success' => true,
            'message' => 'Permission updated successfully.',
            'data' => $permission,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error updating permission: ' . $e->getMessage(),
        ], 500);
    }
}

    


}
