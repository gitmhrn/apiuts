<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->input('user_id');
        $key = bin2hex(random_bytes(16));

        $apiKey = ApiKey::create([
            'user_id' => $userId,
            'key' => $key
        ]);

        return response()->json(['success' => true, 'api_key' => $apiKey->key]);
    }

}
