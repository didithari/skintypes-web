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

        $maxPrice = request()->integer('max_price');
        $texturePreference = request()->query('texture_preference', 'foam');
        $texturePreference = in_array($texturePreference, ['gel', 'foam', 'cream'], true) ? $texturePreference : 'foam';

        if ($maxPrice !== null && $maxPrice > 0) {
            $saw->setBudgetFilterMode($texturePreference);
        } else {
            $saw->setPreferenceWeights('lowest', $texturePreference);
        }

        // Get products for this skin type
        $productsQuery = Product::where('skin_type_id', $prediction->skin_type_id);

        $productsQuery->where('c4_tekstur', $texturePreference);

        if ($maxPrice !== null && $maxPrice > 0) {
            $productsQuery->where('price', '<=', $maxPrice);
        }

        $products = $productsQuery->get();

        // Rank products using SAW method
        $rankedProducts = $saw->rank($products);
        $weights = $saw->getWeights();

        return view('result', compact('prediction', 'rankedProducts', 'weights', 'maxPrice', 'texturePreference'));
    }
}
