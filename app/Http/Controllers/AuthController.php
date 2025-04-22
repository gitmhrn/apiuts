<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate & simpan API key
        $apiKey = ApiKey::create([
            'user_id' => $user->id,
            'key' => Str::random(16),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'api_key' => $apiKey->key,
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)
            ->with('apiKey') 
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'api_key' => $user->apiKey?->key,
            ]
        ]);
    }
}
