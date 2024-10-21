<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;


class UserController extends Controller
{


    public function getCurrentUser(Request $request)
    {
        $user = $request->User();
        
        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'id_branch' => $user->id_branch,
                'name_branch' => $user->name_branch,
                'roles' => $user->roles->pluck('name')->toArray() // Ensures roles are in an array
            ]
        ]);
    }

    public function getUserPermissions(Request $request)
{
    $user = auth()->user();
    $roles = $user->getRoleNames(); 
    $permissions = $user->getAllPermissions()->pluck('name'); 

    return response()->json([
        'roles' => $roles,
        'permissions' => $permissions
    ]);
}


    public function index()
    {
        try {
            $role = auth()->user()->getRoleNames();

            if ($role[0] == 'super_admin') {
                
                $users = User::when(request()->q, function($query) {
                    $query->where('name', 'like', '%' . request()->q . '%');
                })->with('roles')->latest()->get();
            } else {
               
                $users = User::when(request()->q, function($query) {
                    $query->where('name', 'like', '%' . request()->q . '%');
                })->where('id', auth()->user()->id)->with('roles')->latest()->get();
            }
        
            return response([
                'success' => true,
                'data' => $users
            ], 200);
            
        } 
        catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to find user',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request)
    {
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'id_branch' => 'required|max:100',
        'name_branch' => 'required|max:255',
        'role' => 'required|string|exists:roles,name' 
    ]);

    try {
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'id_branch' => $request->id_branch,
            'name_branch' => $request->name_branch,
            'password' => Hash::make($request->password),
        ]);

       
        $user->assignRole($request->role);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to register user',
            'message' => $e->getMessage()
        ], 500);
    }
    }   


    public function update(Request $request, $id)
{
    // Validasi input dari request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id, 
        'password' => 'nullable|string|min:8|confirmed', 
        'id_branch' => 'required|max:100',
        'name_branch' => 'required|max:255',
        'role' => 'required|string|exists:roles,name'
    ]);

    try {
        $user = User::findOrFail($id);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'id_branch' => $request->id_branch,
            'name_branch' => $request->name_branch,
            'password' => $request->password ? Hash::make($request->password) : $user->password, 
        ]);
        $user->syncRoles([$request->role]);

             return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);

    } catch (\Exception $e) {
        // Penanganan error
        return response()->json([
            'error' => 'Failed to update user',
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function updateStatusOffline($id) {
       
        try {
            $user = User::findOrFail($id);

            $user->update([
             'is_online' => false,
              ]);
             return response()->json([
                'message' => 'Status updated successfully'
                ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update user',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
           
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'Delete data success'
            ], 200);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
          
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan not found',
                'errors' => $e->getMessage()
            ], 404);
            
        } catch (\Exception $e) {
           
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function userBranch()
    {
        $userBranch = User::select('name_branch')
                          ->distinct()
                          ->orderBy('name_branch', 'asc') 
                          ->get();
    
        return response()->json([
            'success' => true,
            'data' => $userBranch,
        ], 200);
    }
    




}
