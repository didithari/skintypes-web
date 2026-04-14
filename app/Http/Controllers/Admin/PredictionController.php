<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prediction;
use App\Models\SkinType;

class PredictionController extends Controller
{
    public function index()
    {
        $predictions = Prediction::with('skinType')
            ->latest()
            ->paginate(10);

        return view('admin.predictions.index', compact('predictions'));
    }

    public function edit(Prediction $prediction)
    {
        $skinTypes = SkinType::orderBy('name')->get();

        return view('admin.predictions.edit', compact('prediction', 'skinTypes'));
    }

    public function update(Request $request, Prediction $prediction)
    {
        $validated = $request->validate([
            'skin_type_id' => 'required|exists:skin_types,id',
            'confidence' => 'nullable|numeric|min:0|max:1',
            'predicted_at' => 'nullable|date',
            'image_path' => 'nullable|string|max:255',
        ]);

        $prediction->update($validated);

        return redirect()->route('admin.predictions.index')->with('success', 'Prediction berhasil diperbarui.');
    }

    public function destroy(Prediction $prediction)
    {
        $prediction->delete();

        return redirect()->route('admin.predictions.index')->with('success', 'Prediction berhasil dihapus.');
    }
}
