<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\user;
use App\Models\admin\User as AdminUser;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function index()
    {
    $role = auth()->user()->getRoleNames();

    if ($role[0] == 'admin') {
        // Jika role adalah admin, ambil semua user
        $users = User::when(request()->q, function($query) {
            $query->where('name', 'like', '%' . request()->q . '%');
        })->with('roles')->latest()->get();
    } else {
        // Jika bukan admin, ambil user berdasarkan ID sendiri (user yang sedang login)
        $users = User::when(request()->q, function($query) {
            $query->where('name', 'like', '%' . request()->q . '%');
        })->where('id', auth()->user()->id)->with('roles')->latest()->get();
    }

    return response([
        'success' => true,
        'data' => $users
    ], 200);
    }

    public function create(Request $request)
    {
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|string|exists:roles,name' 
    ]);

    try {
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
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
   
    $user = User::find($id);

   
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    try {
       
        $user->name = $request->name;
        $user->email = $request->email;

        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update user', 'message' => $e->getMessage()], 500);
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




}
