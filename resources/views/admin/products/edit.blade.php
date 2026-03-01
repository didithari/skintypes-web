@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('header_title', 'Products')

@section('content')
    <section class="card page-card">
        <div class="toolbar">
            <h2 class="page-title" style="margin:0;">Edit Product</h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" class="form-grid">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="skin_type_id">Skin Type</label>
                <select id="skin_type_id" name="skin_type_id" required>
                    <option value="">Pilih skin type</option>
                    @foreach($skinTypes as $skinType)
                        <option value="{{ $skinType->id }}" @selected(old('skin_type_id', $product->skin_type_id) == $skinType->id)>{{ $skinType->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="brand">Brand</label>
                <input type="text" id="brand" name="brand" value="{{ old('brand', $product->brand) }}">
            </div>

            <div class="field form-full">
                <label for="name">Nama Product</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="field form-full">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-full">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </section>
@endsection
