<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ApiKey;

class ProductController extends Controller
{
    private function validateApiKey(Request $request)
    {
    
        $apiKey = $request->query('api_key') ?: $request->header('X-API-KEY');
        
        if (!$apiKey || !ApiKey::where('key', $apiKey)->exists()) {
            return response()->json(['success' => false, 'message' => 'Invalid or missing API key'], 401);
        }
        
        return null; 
    }

    public function index(Request $request)
    {
        $validationResponse = $this->validateApiKey($request);
        if ($validationResponse) {
            return $validationResponse;
        }

        $products = Product::paginate(10); 

        return response()->json(['success' => true, 'data' => $products]);
    }

    public function show(Request $request, $id)
    {
        $validationResponse = $this->validateApiKey($request);
        if ($validationResponse) {
            return $validationResponse;
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $product]);
    }

    public function store(Request $request)
    {
        $validationResponse = $this->validateApiKey($request);
        if ($validationResponse) {
            return $validationResponse;
        }

        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_type' => 'nullable|string|max:255',
            'key_ingredients' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $product = Product::create($validator->validated());

        return response()->json(['success' => true, 'message' => 'Product created', 'data' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        $validationResponse = $this->validateApiKey($request);
        if ($validationResponse) {
            return $validationResponse;
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // Validate the request input
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'product_type' => 'nullable|string|max:255',
            'key_ingredients' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $product->update($validator->validated());

        return response()->json(['success' => true, 'message' => 'Product updated', 'data' => $product]);
    }

    public function destroy(Request $request, $id)
    {
        $validationResponse = $this->validateApiKey($request);
        if ($validationResponse) {
            return $validationResponse;
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted']);
    }
}
