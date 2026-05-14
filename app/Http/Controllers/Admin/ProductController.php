<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SkinType;
use App\Services\SawService;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('skinType')
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $skinTypes = SkinType::orderBy('name')->get();

        return view('admin.products.create', compact('skinTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'skin_type_id'  => 'required|exists:skin_types,id',
            'name'          => 'required|string|max:255',
            'brand'         => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'nullable|integer|min:0',
            'image_url'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'c1_kandungan'  => 'required|integer|min:1|max:4',
            'c2_iritatif'   => 'required|integer|min:1|max:3',
            'c4_tekstur'    => 'required|in:gel,foam,cream',
            'link_produk'   => 'nullable|url|max:500',
        ]);

        // Handle image upload
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('products', 'public');
            $validated['image_url'] = $path;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $skinTypes = SkinType::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'skinTypes'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'skin_type_id'  => 'required|exists:skin_types,id',
            'name'          => 'required|string|max:255',
            'brand'         => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'nullable|integer|min:0',
            'image_url'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'c1_kandungan'  => 'required|integer|min:1|max:4',
            'c2_iritatif'   => 'required|integer|min:1|max:3',
            'c4_tekstur'    => 'required|in:gel,foam,cream',
            'link_produk'   => 'nullable|url|max:500',
        ]);

        // Handle image upload
        if ($request->hasFile('image_url')) {
            // Delete old image if exists
            if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
                Storage::disk('public')->delete($product->image_url);
            }

            $path = $request->file('image_url')->store('products', 'public');
            $validated['image_url'] = $path;
        } else {
            // Keep old image if no new image uploaded
            unset($validated['image_url']);
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product berhasil dihapus.');
    }

    /**
     * SAW ranking preview — shows full calculation breakdown per skin type.
     */
    public function sawPreview(Request $request, SawService $saw)
    {
        $skinTypes = SkinType::orderBy('name')->get();
        $activeSkinType = $request->query('skin_type');
        $weights = $saw->getWeights();

        $teksturMap = [
            'gel'   => 3,
            'foam'  => 2,
            'cream' => 1,
        ];

        // Decide which skin types to show
        $displayTypes = $activeSkinType
            ? $skinTypes->where('id', $activeSkinType)
            : $skinTypes;

        $rankedGroups = collect();

        foreach ($displayTypes as $skinType) {
            $products = Product::with('skinType')
                ->where('skin_type_id', $skinType->id)
                ->get();

            $ranked = $saw->rank($products);

            // Compute max/min for display
            $matrix = $products->map(fn ($p) => [
                'c1' => (int) $p->c1_kandungan,
                'c2' => (int) $p->c2_iritatif,
                'c3' => (int) $p->c3_harga,
                'c4' => $teksturMap[$p->c4_tekstur] ?? 2,
            ]);

            $rankedGroups[$skinType->name] = [
                'products'   => $ranked,
                'maxC1'      => $matrix->max('c1') ?: 1,
                'minC2'      => $matrix->min('c2') ?: 1,
                'minC3'      => $matrix->min('c3') ?: 1,
                'maxC4'      => $matrix->max('c4') ?: 1,
                'teksturMap' => $teksturMap,
            ];
        }

        return view('admin.products.saw-preview', compact(
            'skinTypes', 'activeSkinType', 'weights', 'rankedGroups'
        ));
    }
}
