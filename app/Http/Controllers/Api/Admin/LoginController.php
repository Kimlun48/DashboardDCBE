<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\admin\RefreshToken;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(),[
    //         'name' => 'required',
    //         'password' => 'required',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }
        
    //     $request->validate([
    //         // 'email' => 'required|email',
    //         'name' => 'required',
    //         'password' => 'required',
    //     ]);

    //     $user = User::where('name', $request->name)->with('roles')->first();
        
    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return response([
    //             'success' => false,
    //             'message' => ['These credentials do not match our records.']
    //         ], 404);
    //     }

    //     $accessTokenName = env('ACCESS_TOKEN_NAME', 'DashboardDC');
    //     $accessToken = $user->createToken($accessTokenName)->plainTextToken;
    //     $refreshToken = Str::random(60);

        
    //     $user->tokens()->create([
    //         'name' => 'refresh_token',
    //         'token' => hash('sha256', $refreshToken),
    //         'abilities' => ['refresh'],
    //     ]);

    //     $response = [
    //         'success' => true,
    //         'user' => $user,
    //         'access_token' => $accessToken,
    //         'refresh_token' => $refreshToken
    //     ];

    //     return response($response, 201);
    // }
//     public function login(Request $request)
// {
//     // Validasi request
//     $validator = Validator::make($request->all(), [
//         'name' => 'required',
//         'password' => 'required',
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['errors' => $validator->errors()], 422);
//     }

//     // Cari user berdasarkan nama
//     $user = User::where('name', $request->name)->with('roles')->first();

//     // Cek apakah user ditemukan dan password sesuai
//     if (!$user || !Hash::check($request->password, $user->password)) {
//         return response()->json([
//             'success' => false,
//             'message' => ['These credentials do not match our records.']
//         ], 401); // Ubah ke status 401 Unauthorized
//     }

//     // Generate access token
//     $accessTokenName = env('ACCESS_TOKEN_NAME', 'DashboardDC');
//     $accessToken = $user->createToken($accessTokenName)->plainTextToken;

//     // Generate refresh token
//     $refreshToken = Str::random(60);
//     $user->tokens()->create([
//         'name' => 'refresh_token',
//         'token' => hash('sha256', $refreshToken),
//         'abilities' => ['refresh'],
//     ]);

//     // Ambil permissions user
//     $permissions = $user->getPermissionArray();

//     // Buat response
//     $response = [
//         'success' => true,
//         'user' => $user,
//         'permissions' => $permissions, // Tambahkan permissions di sini
//         'access_token' => $accessToken,
//         'refresh_token' => $refreshToken,
//     ];

//     return response()->json($response, 201);
// }

public function login(Request $request)
{
    
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    
    $user = User::where('name', $request->name)->with('roles')->first();

    if ($user && $user->is_online) {
        return response()->json(['message' => 'User already logged in'], 403);
    }
    
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => ['These credentials do not match our records.']
        ], 401); 
    }

    $user->is_online = true;
    $user->save();

    

    $accessTokenName = env('ACCESS_TOKEN_NAME', 'DashboardDC');
    $accessToken = $user->createToken($accessTokenName)->plainTextToken;

   
    $refreshToken = Str::random(60);
    
    
    $user->refreshTokens()->create([
        'token' => hash('sha256', $refreshToken),
        'expires_at' => now()->addDays(1), 
    ]);

    
    $permissions = $user->getPermissionArray();

   
    $response = [
        'success' => true,
        'user' => $user,
        'permissions' => $permissions, 
        'access_token' => $accessToken,
        'refresh_token' => $refreshToken,
        'expires_at' => now()->addDays(30), 
    ];

    return response()->json($response, 201);
}


public function refresh(Request $request)
{
    // Validasi input untuk memastikan refresh_token ada
    $request->validate([
        'refresh_token' => 'required|string',
    ]);

    // Cari refresh token di database
    $refreshToken = RefreshToken::where('token', hash('sha256', $request->refresh_token))->first();

    // Cek apakah token ditemukan dan belum kedaluwarsa
    if (!$refreshToken || $refreshToken->expires_at < now()) {
        return response()->json(['error' => 'Refresh token is invalid or expired'], 401);
    }

    // Cari user berdasarkan ID dari refresh token
    $user = User::find($refreshToken->user_id);

    // Cek jika pengguna tidak ditemukan
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Generate access token baru
    $accessTokenName = env('ACCESS_TOKEN_NAME', 'DashboardDC');
    $accessTokenExpiry = env('ACCESS_TOKEN_EXPIRY_MINUTES', 60);
    $newAccessToken = $user->createToken($accessTokenName)->plainTextToken;

    return response()->json([
        'success' => true,
        'access_token' => $newAccessToken,
        'expires_at' => now()->addMinutes($accessTokenExpiry)->toISOString(), // Atur waktu kedaluwarsa untuk access token baru
    ]);
}

    


public function logout(Request $request)
{
    
     $user = $request->user();
     $user->tokens()->delete(); 
 
     
     if (method_exists($user, 'refreshTokens')) {
         $user->refreshTokens()->delete();
     }
 
    
     $user->is_online = false;
     $user->save();
 
   
     return response()->json([
         'success' => true,
         'message' => 'Logout successful'
     ], 200);
}

public function updateStatus(Request $request)
{
    
    $user = $request->user();
    $user->is_online = $request->is_online;
    $user->save();

    return response()->json(['message' => 'Status updated successfully']);
}


    // public function refresh(Request $request)
    // {
    //     $request->validate([
    //         'refresh_token' => 'required'
    //     ]);

    //     $hashedToken = hash('sha256', $request->refresh_token);
    //     $token = PersonalAccessToken::where('token', $hashedToken)->first();

    //     if (!$token || !$token->can('refresh')) {
    //         return response([
    //             'success' => false,
    //             'message' => ['Invalid refresh token.']
    //         ], 401);
    //     }

    //     $user = $token->tokenable;

    //     $accessTokenName = env('ACCESS_TOKEN_NAME');
    //     $accessToken = $user->createToken($accessTokenName)->plainTextToken;
    //     $refreshToken = Str::random(60);

    //     // Hapus token refresh lama dan buat yang baru
    //     $token->delete();
    //     $user->tokens()->create([
    //         'name' => 'refresh_token',
    //         'token' => hash('sha256', $refreshToken),
    //         'abilities' => ['refresh'],
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'access_token' => $accessToken,
    //         'refresh_token' => $refreshToken
    //     ], 201);
    // } 

    


    
    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['message' => 'User registered successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to register user', 'message' => $e->getMessage()], 500);
        }
    }

    
}