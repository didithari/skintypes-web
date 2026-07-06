<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction;
use App\Models\Product;
use App\Services\SawService;

class ResultController extends Controller
{
    public function show($predictionId, SawService $saw)
    {
        $prediction = Prediction::with('skinType.ingredients')->findOrFail($predictionId);

        $pricePreference = request()->query('price_preference', 'lowest');
        $texturePreference = request()->query('texture_preference', 'foam');

        $saw->setPreferenceWeights($pricePreference, $texturePreference);

        // Get products for this skin type
        $products = Product::where('skin_type_id', $prediction->skin_type_id)->get();

        // Rank products using SAW method
        $rankedProducts = $saw->rank($products);
        $weights = $saw->getWeights();

        return view('result', compact('prediction', 'rankedProducts', 'weights'));
    }
}
