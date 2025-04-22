<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiKey;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        
        $response = $this->validateApiKey($request);
        if ($response) {
            return $response; 
        }

        return $next($request); 
    }

    private function validateApiKey(Request $request)
    {
        
        $apiKey = $request->query('api_key') ?: $request->header('X-API-KEY');

        if (!$apiKey || !ApiKey::where('key', $apiKey)->exists()) {
            return response()->json(['success' => false, 'message' => 'Invalid or missing API key'], 401);
        }

        return null; 
    }
}
