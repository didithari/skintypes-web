@extends('admin.layouts.app')

@section('title', 'Tambah Skin Type')
@section('header_title', 'Skin Types')

@section('content')
    <section class="card page-card">
        <div class="toolbar">
            <h2 class="page-title" style="margin:0;">Tambah Skin Type</h2>
            <a href="{{ route('admin.skin-types.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <form action="{{ route('admin.skin-types.store') }}" method="POST" class="form-grid">
            @csrf
            <div class="field form-full">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="field form-full">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
            </div>

            <div class="form-full">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </section>
@endsection
