<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SkinType;

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
            'skin_type_id' => 'required|exists:skin_types,id',
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

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
            'skin_type_id' => 'required|exists:skin_types,id',
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product berhasil dihapus.');
    }
}
