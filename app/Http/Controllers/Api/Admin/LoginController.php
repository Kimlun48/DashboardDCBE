<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'success' => false,
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $accessTokenName = env('ACCESS_TOKEN_NAME');
        $accessToken = $user->createToken($accessTokenName)->plainTextToken;
        $refreshToken = Str::random(60);

        // Simpan refresh token di database
        $user->tokens()->create([
            'name' => 'refresh_token',
            'token' => hash('sha256', $refreshToken),
            'abilities' => ['refresh'],
        ]);

        $response = [
            'success' => true,
            'user' => $user,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // Menghapus semua token pengguna

        return response()->json([
            'success' => true
        ], 200);
    }

    public function refresh(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required'
        ]);

        $hashedToken = hash('sha256', $request->refresh_token);
        $token = PersonalAccessToken::where('token', $hashedToken)->first();

        if (!$token || !$token->can('refresh')) {
            return response([
                'success' => false,
                'message' => ['Invalid refresh token.']
            ], 401);
        }

        $user = $token->tokenable;

        $accessTokenName = env('ACCESS_TOKEN_NAME');
        $accessToken = $user->createToken($accessTokenName)->plainTextToken;
        $refreshToken = Str::random(60);

        // Hapus token refresh lama dan buat yang baru
        $token->delete();
        $user->tokens()->create([
            'name' => 'refresh_token',
            'token' => hash('sha256', $refreshToken),
            'abilities' => ['refresh'],
        ]);

        return response()->json([
            'success' => true,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ], 201);
    } 
    
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