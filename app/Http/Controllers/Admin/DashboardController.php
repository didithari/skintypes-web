<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prediction;
use App\Models\Product;
use App\Models\SkinType;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPredictions = Prediction::count();
        $totalProducts = Product::count();

        $mostDetected = SkinType::query()
            ->select('skin_types.name', DB::raw('COUNT(predictions.id) as total'))
            ->leftJoin('predictions', 'predictions.skin_type_id', '=', 'skin_types.id')
            ->groupBy('skin_types.id', 'skin_types.name')
            ->orderByDesc('total')
            ->first();

        $recentPredictions = Prediction::with('skinType')
            ->latest()
            ->take(7)
            ->get();

        return view('admin.dashboard.index', [
            'totalPredictions' => $totalPredictions,
            'totalProducts' => $totalProducts,
            'mostDetected' => $mostDetected?->name ?? '-',
            'recentPredictions' => $recentPredictions,
        ]);
    }
}
