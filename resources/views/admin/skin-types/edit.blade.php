@extends('admin.layouts.app')

@section('title', 'Edit Skin Type')
@section('header_title', 'Skin Types')

@section('content')
    <section class="card page-card">
        <div class="toolbar">
            <h2 class="page-title" style="margin:0;">Edit Skin Type</h2>
            <a href="{{ route('admin.skin-types.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <form action="{{ route('admin.skin-types.update', $skinType) }}" method="POST" class="form-grid">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="api_id">API ID</label>
                <input type="number" id="api_id" value="{{ $skinType->api_id }}" readonly>
            </div>

            <div class="field">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $skinType->name) }}" readonly required>
            </div>

            <div class="field form-full">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description">{{ old('description', $skinType->description) }}</textarea>
            </div>

            <div class="form-full">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </section>
@endsection
