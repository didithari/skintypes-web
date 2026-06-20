@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('header_title', 'Products')

@section('content')
    <section class="card page-card">
        <div class="toolbar">
            <h2 class="page-title" style="margin:0;">Edit Product</h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="form-grid">
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

            <div class="field">
                <label for="price">Harga</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" placeholder="0">
            </div>

            <div class="field form-full">
                <label for="image_url">Gambar Product</label>
                @if($product->image_url)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" style="max-width: 200px; border-radius: 8px;">
                        <p style="margin: 8px 0 0; font-size: 12px; color: #6b7280;">Gambar saat ini</p>
                    </div>
                @endif
                <input type="file" id="image_url" name="image_url" accept="image/*">
                <small style="color:#6b7280; margin-top:4px; display:block;">Format: JPG, PNG, GIF, WebP (Max 2MB) - Biarkan kosong jika tidak ingin mengubah</small>
            </div>

            {{-- SAW Criteria Section --}}
            <div class="form-full" style="margin-top: 8px; margin-bottom: 4px;">
                <h3 style="font-size: 16px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px;">Kriteria SAW</h3>
            </div>

            <div class="field">
                <div class="label-row">
                    <label for="c1_kandungan">C1 - Kandungan Aktif</label>
                    <span class="info-tooltip-wrap">
                        <button type="button" class="info-tooltip" aria-label="Info C1 - Kandungan Aktif">i</button>
                        <div class="info-popover" role="tooltip">
                            <p><strong>Benefit.</strong> Semakin tinggi nilainya semakin baik. Bobot C1 biasanya diprioritaskan karena kandungan aktif paling berpengaruh pada efektivitas produk.</p>
                        </div>
                    </span>
                </div>
                <select id="c1_kandungan" name="c1_kandungan" required>
                    <option value="1" @selected(old('c1_kandungan', $product->c1_kandungan) == 1)>1 - Rendah = 1</option>
                    <option value="2" @selected(old('c1_kandungan', $product->c1_kandungan) == 2)>2 - Sedang = 2</option>
                    <option value="3" @selected(old('c1_kandungan', $product->c1_kandungan) == 3)>3 - Tinggi = 3</option>
                    <option value="4" @selected(old('c1_kandungan', $product->c1_kandungan) == 4)>4 - Sangat Tinggi ≥4</option>
                </select>
            </div>

            <div class="field">
                <div class="label-row">
                    <label for="c2_iritatif">C2 - Kandungan Iritatif</label>
                    <span class="info-tooltip-wrap">
                        <button type="button" class="info-tooltip" aria-label="Info C2 - Kandungan Iritatif">i</button>
                        <div class="info-popover" role="tooltip">
                            <p><strong>Cost.</strong> Semakin rendah nilainya semakin baik. Bobot C2 menekankan keamanan (meminimalkan bahan iritatif seperti alkohol, paraben, dan fragrance).</p>
                        </div>
                    </span>
                </div>
                <select id="c2_iritatif" name="c2_iritatif" required>
                    <option value="1" @selected(old('c2_iritatif', $product->c2_iritatif) == 1)>Tanpa Iritan</option>
                    <option value="2" @selected(old('c2_iritatif', $product->c2_iritatif) == 2)>1 Iritan</option>
                    <option value="3" @selected(old('c2_iritatif', $product->c2_iritatif) == 3)>&gt;1 Iritan</option>
                </select>
            </div>

            <div class="field">
                <div class="label-row">
                    <label for="c3_harga_info">C3 - Range Harga</label>
                    <span class="info-tooltip-wrap">
                        <button type="button" class="info-tooltip" aria-label="Info C3 - Range Harga">i</button>
                        <div class="info-popover" role="tooltip">
                            <p><strong>Cost.</strong> Range harga dihitung otomatis dari harga: 1=&lt;50rb, 2=50–100rb, 3=100–150rb, 4=&gt;150rb. Bobot C3 mengatur seberapa sensitif hasil SAW terhadap faktor budget.</p>
                        </div>
                    </span>
                </div>
                <input id="c3_harga_info" type="text" value="Saat ini: {{ $product->c3_harga }} ({{ $product->c3_label }}) — Otomatis dari harga" disabled style="background:#f3f4f6; color:#6b7280;">
            </div>

            <div class="field">
                <div class="label-row">
                    <label for="c4_tekstur">C4 - Tekstur</label>
                    <span class="info-tooltip-wrap">
                        <button type="button" class="info-tooltip" aria-label="Info C4 - Tekstur">i</button>
                        <div class="info-popover" role="tooltip">
                            <p><strong>Benefit.</strong> Tekstur diberi skor (gel=3, foam=2, cream=1). Bobot C4 dipakai untuk menyeimbangkan kenyamanan/feel produk terhadap kriteria lain saat perangkingan.</p>
                        </div>
                    </span>
                </div>
                <select id="c4_tekstur" name="c4_tekstur" required>
                    <option value="gel" @selected(old('c4_tekstur', $product->c4_tekstur) == 'gel')>Gel = 3</option>
                    <option value="foam" @selected(old('c4_tekstur', $product->c4_tekstur) == 'foam')>Foam = 2</option>
                    <option value="cream" @selected(old('c4_tekstur', $product->c4_tekstur) == 'cream')>Cream = 1</option>
                </select>
            </div>

            <div class="field form-full">
                <label for="link_produk">Link Produk (Toko Online)</label>
                <input type="url" id="link_produk" name="link_produk" value="{{ old('link_produk', $product->link_produk) }}" placeholder="https://tokopedia.com/...">
            </div>

            <div class="form-full">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </section>
@endsection
