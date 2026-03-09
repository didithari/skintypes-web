@extends('admin.layouts.app')

@section('title', 'Tambah Product')
@section('header_title', 'Products')

@section('content')
    <section class="card page-card">
        <div class="toolbar">
            <h2 class="page-title" style="margin:0;">Tambah Product</h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="form-grid">
            @csrf

            <div class="field">
                <label for="skin_type_id">Skin Type</label>
                <select id="skin_type_id" name="skin_type_id" required>
                    <option value="">Pilih skin type</option>
                    @foreach($skinTypes as $skinType)
                        <option value="{{ $skinType->id }}" @selected(old('skin_type_id') == $skinType->id)>{{ $skinType->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="brand">Brand</label>
                <input type="text" id="brand" name="brand" value="{{ old('brand') }}">
            </div>

            <div class="field form-full">
                <label for="name">Nama Product</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="field form-full">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
            </div>

            <div class="field">
                <label for="price">Harga</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="0">
            </div>

            <div class="field">
                <label for="image_url">Gambar Product</label>
                <input type="file" id="image_url" name="image_url" accept="image/*">
                <small style="color:#6b7280; margin-top:4px; display:block;">Format: JPG, PNG, GIF (Max 2MB)</small>
            </div>

            <div class="form-full">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </section>
@endsection
