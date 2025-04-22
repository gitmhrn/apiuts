<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
    
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => app('hash')->make($request->password),
            'api_key'  => Str::random(60), 
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'User created',
            'data'    => $user,
        ]);
    }
}
