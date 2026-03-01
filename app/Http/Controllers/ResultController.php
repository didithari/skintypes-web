<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction;
use App\Models\Product;

class ResultController extends Controller
{
    public function show($predictionId)
    {
        $prediction = Prediction::with('skinType')->findOrFail($predictionId);
        
        // Get products for this skin type
        $products = Product::where('skin_type_id', $prediction->skin_type_id)
            ->get();
        
        return view('result', compact('prediction', 'products'));
    }
}
