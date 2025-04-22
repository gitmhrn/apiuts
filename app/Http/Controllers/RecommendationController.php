<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecommendationController extends Controller
{

    public function index()
    {
        return response()->json(['success' => true, 'data' => Recommendation::all()]);
    }

    public function show($id)
    {
        $data = Recommendation::findOrFail($id);  
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'weather_condition_id' => 'required|integer',
            'skin_type_id' => 'required|integer',
            'skin_condition_id' => 'required|integer',
            'recommended_product_ids' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $recommendation = Recommendation::create($request->all());

        return response()->json(['success' => true, 'message' => 'Recommendation created', 'data' => $recommendation], 201);
    }

    public function update(Request $request, $id)
    {
        $recommendation = Recommendation::findOrFail($id);  
        $recommendation->update($request->all());

        return response()->json(['success' => true, 'message' => 'Recommendation updated', 'data' => $recommendation]);
    }

    public function destroy($id)
    {
        $recommendation = Recommendation::findOrFail($id);  
        $recommendation->delete();

        return response()->json(['success' => true, 'message' => 'Recommendation deleted']);
    }

    public function get(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'weather' => 'required|integer',  
        ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
    
        $recommendation = Recommendation::where('weather_condition_id', $request->query('weather'))->first();
    
        if (!$recommendation) {
            return response()->json(['success' => false, 'message' => 'Recommendation not found'], 404);
        }
    
        $ids = array_map('intval', explode(',', $recommendation->recommended_product_ids));
    
        $products = Product::whereIn('id', $ids)->get();
    
        return response()->json(['success' => true, 'data' => $products]);
    }    
}    