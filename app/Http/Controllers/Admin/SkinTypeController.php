<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SkinType;

class SkinTypeController extends Controller
{
    public function index()
    {
        $skinTypes = SkinType::withCount(['products', 'predictions'])
            ->orderBy('api_id')
            ->paginate(10);

        return view('admin.skin-types.index', compact('skinTypes'));
    }

    public function create()
    {
        return redirect()->route('admin.skin-types.index')->with('success', 'Skin type menggunakan data API tetap (dry, normal, oily).');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.skin-types.index')->withErrors([
            'name' => 'Penambahan skin type baru tidak diizinkan. Gunakan data API id 0, 1, 2.',
        ]);
    }

    public function edit(SkinType $skinType)
    {
        return view('admin.skin-types.edit', compact('skinType'));
    }

    public function update(Request $request, SkinType $skinType)
    {
        $validated = $request->validate([
            'name' => 'required|string|in:dry,normal,oily',
            'description' => 'nullable|string',
        ]);

        $validated['api_id'] = SkinType::apiIdFromName($validated['name']);

        $skinType->update($validated);

        return redirect()->route('admin.skin-types.index')->with('success', 'Skin type berhasil diperbarui.');
    }

    public function destroy(SkinType $skinType)
    {
        return redirect()->route('admin.skin-types.index')->withErrors([
            'name' => 'Skin type tidak bisa dihapus karena sudah ditetapkan oleh API.',
        ]);
    }
}
