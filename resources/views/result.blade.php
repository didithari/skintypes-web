<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi Skincare - {{ ucfirst($prediction->skinType->name) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .skin-type-badge {
            display: inline-block;
            background: rgba(129, 199, 132, 0.2);
            color: #2e7d32;
            padding: 12px 28px;
            border-radius: 30px;
            font-size: 20px;
            margin-bottom: 24px;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(129, 199, 132, 0.3);
        }

        .main-title {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 16px;
            color: #7f8c8d;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .product-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
        }

        /* Ranking badge (Top 3) */
        .rank-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            z-index: 3;
            box-shadow: 0 6px 14px rgba(0,0,0,0.18);
        }
        .rank-1 { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #78350f; }
        .rank-2 { background: linear-gradient(135deg, #d1d5db, #9ca3af); color: #374151; }
        .rank-3 { background: linear-gradient(135deg, #f97316, #ea580c); color: #ffffff; }
        .rank-other { background: #eef2f7; color: #475569; box-shadow: 0 6px 14px rgba(0,0,0,0.10); }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.12);
        }

        .product-image {
            width: 100%;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-image-fallback {
            width: 120px;
            height: 160px;
            border-radius: 10px;
            background: #f1f3f5;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #6c757d;
            font-size: 13px;
            font-weight: 600;
            padding: 10px;
        }

        .product-name {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .product-description {
            font-size: 13px;
            color: #7f8c8d;
            margin-bottom: 12px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 12px;
        }

        .stars {
            display: flex;
            gap: 2px;
        }

        .star {
            width: 14px;
            height: 14px;
            fill: #ffc107;
        }

        .rating-value {
            font-size: 13px;
            color: #5f6368;
            font-weight: 500;
        }

        .price-section {
            margin-bottom: 16px;
        }

        .price-old {
            font-size: 13px;
            color: #95a5a6;
            text-decoration: line-through;
            margin-right: 8px;
        }

        .price {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
        }

        .buy-btn {
            width: 100%;
            background: #81c784;
            color: white;
            border: none;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .buy-btn:hover {
            background: #66bb6a;
        }

        .buy-btn svg {
            width: 16px;
            height: 16px;
        }

        .bottom-section {
            background: white;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }

        .ai-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 16px;
            background: linear-gradient(135deg, #81c784 0%, #66bb6a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ai-icon svg {
            width: 24px;
            height: 24px;
            fill: white;
        }

        .bottom-text {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .scan-again-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: #2c3e50;
            border: 2px solid #e0e0e0;
            padding: 12px 32px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .scan-again-btn:hover {
            border-color: #81c784;
            color: #66bb6a;
            background: #f1f8f4;
        }

        .scan-again-btn svg {
            width: 18px;
            height: 18px;
        }

        .view-image-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #2196F3;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 16px;
        }

        .view-image-btn:hover {
            background: #1976D2;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
        }

        .view-image-btn svg {
            width: 16px;
            height: 16px;
        }

        /* Top #1 Recommendation Popup */
        .top1-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(3px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 3000;
            padding: 18px;
        }
        .top1-overlay.show {
            display: flex;
        }
        .top1-modal {
            width: 100%;
            max-width: 720px;
            max-height: calc(100vh - 36px);
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 18px 60px rgba(0,0,0,0.25);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .top1-header {
            padding: 18px 20px;
            background: linear-gradient(135deg, rgba(129, 199, 132, 0.18) 0%, rgba(102, 187, 106, 0.12) 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .top1-title {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #2c3e50;
        }
        .top1-subtitle {
            margin: 4px 0 0;
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
        }
        .top1-close {
            appearance: none;
            border: 0;
            background: rgba(255,255,255,0.9);
            width: 36px;
            height: 36px;
            border-radius: 10px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #374151;
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        }
        .top1-close:hover {
            background: #fff;
        }
        .top1-body {
            padding: 18px 20px 20px;
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 16px;
            overflow: auto;
            -webkit-overflow-scrolling: touch;
            flex: 1;
        }
        .top1-product-image {
            width: 100%;
            height: 220px;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
            background: #fff;
        }
        .top1-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .top1-meta {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .top1-rank-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        .top1-rank-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            color: #2c3e50;
        }
        .top1-rank-badge .rank-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: #78350f;
            box-shadow: 0 8px 18px rgba(245,158,11,0.35);
        }
        .top1-product-name {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #111827;
            line-height: 1.25;
        }
        .top1-product-brand {
            margin: 0;
            font-size: 13px;
            color: #6b7280;
        }
        .top1-price {
            font-size: 18px;
            font-weight: 800;
            color: #2c3e50;
        }
        .top1-reason {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 12px 14px;
        }
        .top1-reason h4 {
            margin: 0 0 8px;
            font-size: 14px;
            font-weight: 800;
            color: #2e7d32;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .top1-reason p {
            margin: 0 0 10px;
            font-size: 13px;
            color: #4b5563;
            line-height: 1.55;
        }
        .top1-reason ul {
            margin: 0;
            padding-left: 18px;
            color: #374151;
            font-size: 13px;
            line-height: 1.6;
        }
        .top1-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }
        .top1-actions .buy-btn {
            width: auto;
            flex: 1;
            min-width: 160px;
        }
        .top1-actions .btn-secondary-ghost {
            flex: 1;
            min-width: 160px;
            background: #fff;
            border: 1px solid #e5e7eb;
            color: #374151;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }
        .top1-actions .btn-secondary-ghost:hover {
            background: #f9fafb;
        }
        @media (max-width: 720px) {
            .top1-overlay {
                padding: 12px;
            }
            .top1-body {
                grid-template-columns: 1fr;
            }
            .top1-product-image {
                height: 200px;
            }
        }

        .empty-products {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 16px;
            margin-bottom: 40px;
        }

        .empty-products svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-products h3 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .empty-products p {
            color: #7f8c8d;
        }

        .empty-products .not-found-message {
            margin-top: 8px;
            color: #c62828;
            font-weight: 700;
            font-size: 15px;
        }

        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 16px;
            }

            .main-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="skin-type-badge">
                🌿 Tipe Kulit: {{ ucfirst($prediction->skinType->name) }}
            </div>
            <div style="font-size: 15px; color: #7f8c8d; margin-top: -15px; margin-bottom: 25px; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 6px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Tingkat Kepercayaan: <strong style="color: #2c3e50;">{{ number_format($prediction->confidence * 100, 1) }}%</strong>
            </div>
            <h1 class="main-title">Rekomendasi Skincare Untuk Kamu</h1>
            <p class="subtitle">Berdasarkan hasil analisis kulit wajah</p>
        </div>


        <!-- Products Grid -->
        @if($rankedProducts->count() > 0)
            <div class="products-grid">
                @foreach($rankedProducts as $index => $product)
                    <div class="product-card">

                        <div class="rank-badge {{ $index === 0 ? 'rank-1' : ($index === 1 ? 'rank-2' : ($index === 2 ? 'rank-3' : 'rank-other')) }}" aria-label="Ranking {{ $index + 1 }}">
                            {{ $index + 1 }}
                        </div>


                        <!-- Product Image -->
                        <div class="product-image">
                            @php
                                $productImage = null;

                                if (!empty($product->image_url)) {
                                    $imagePath = ltrim((string) $product->image_url, '/');

                                    if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://'])) {
                                        $productImage = $imagePath;
                                    } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'storage/')) {
                                        $productImage = asset($imagePath);
                                    } else {
                                        $productImage = asset('storage/' . $imagePath);
                                    }
                                }
                            @endphp

                            <img
                                src="{{ $productImage ?: 'data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"120\" height=\"160\" viewBox=\"0 0 120 160\"><rect width=\"120\" height=\"160\" rx=\"10\" fill=\"%23f1f3f5\"/><text x=\"60\" y=\"84\" text-anchor=\"middle\" font-family=\"Arial, sans-serif\" font-size=\"12\" fill=\"%236c757d\">No Image</text></svg>' }}"
                                alt="{{ $product->name }}"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >
                            <div class="product-image-fallback" style="display: none;">
                                {{ $product->brand ?? 'Product' }}
                            </div>
                        </div>

                        <!-- Product Info -->
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <p class="product-description">{{ $product->description ?: 'Produk berkualitas untuk perawatan kulit ' . $prediction->skinType->name }}</p>

                        <!-- Rating -->
                        <div class="rating">
                            <div class="stars">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="star" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="rating-value">({{ number_format(4.5 + ($index * 0.1), 1) }})</span>
                        </div>

                        <!-- Price -->
                        <div class="price-section">
                            @if($index % 4 === 2 && $product->price)
                                <span class="price-old">Rp {{ number_format($product->price * 1.3, 0, ',', '.') }}</span>
                            @endif
                            <span class="price">Rp {{ number_format($product->price ?? (rand(70, 150) * 1000), 0, ',', '.') }}</span>
                        </div>

                        <!-- Buy Button -->
                        @php
                            $buyLink = trim((string) $product->link_produk);
                            $buyLinkIsUsable = $buyLink !== '' && preg_match('/^https?:\\/\\//i', $buyLink);
                        @endphp

                        @if($buyLinkIsUsable)
                            <a class="buy-btn" href="{{ $buyLink }}" target="_blank" rel="noopener noreferrer">
                                Beli Sekarang
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
                                </svg>
                            </a>
                        @else
                            <button class="buy-btn" type="button" onclick="alert('Link produk belum tersedia.')">
                                Beli Sekarang
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-products">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3>Belum Ada Produk</h3>
                @if(!empty($maxPrice))
                    <p>Produk untuk tipe kulit {{ $prediction->skinType->name }} dengan harga sampai Rp {{ number_format($maxPrice, 0, ',', '.') }} tidak tersedia.</p>
                @endif
                <p class="not-found-message">produk tidak ditemukan</p>
            </div>
        @endif

        <!-- Ingredients Info -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 40px; margin-top: 20px;">
            <!-- Recommended Ingredients -->
            <div style="background: white; border-radius: 16px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #81c784;">
                <h3 style="display: flex; align-items: center; gap: 8px; color: #2e7d32; font-size: 18px; margin-bottom: 15px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Kandungan Disarankan
                </h3>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @foreach($prediction->skinType->ingredients->where('type', 'good') as $ing)
                        <li style="margin-bottom: 12px; border-bottom: 1px solid #f9f9f9; padding-bottom: 12px;">
                            <strong style="color: #2c3e50; display: block; font-size: 15px; margin-bottom: 4px;">{{ $ing->name }}</strong>
                            <span style="color: #7f8c8d; font-size: 13.5px; line-height: 1.5; display: block;">{{ $ing->description }}</span>
                        </li>
                    @endforeach
                    @if($prediction->skinType->ingredients->where('type', 'good')->isEmpty())
                        <li style="color: #7f8c8d; font-size: 14px; font-style: italic;">Belum ada data kandungan.</li>
                    @endif
                </ul>
            </div>

            <!-- Avoid Ingredients -->
            <div style="background: white; border-radius: 16px; padding: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #e57373;">
                <h3 style="display: flex; align-items: center; gap: 8px; color: #c62828; font-size: 18px; margin-bottom: 15px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Sebaiknya Dihindari
                </h3>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    @foreach($prediction->skinType->ingredients->where('type', 'bad') as $ing)
                        <li style="margin-bottom: 12px; border-bottom: 1px solid #f9f9f9; padding-bottom: 12px;">
                            <strong style="color: #2c3e50; display: block; font-size: 15px; margin-bottom: 4px;">{{ $ing->name }}</strong>
                            <span style="color: #7f8c8d; font-size: 13.5px; line-height: 1.5; display: block;">{{ $ing->description }}</span>
                        </li>
                    @endforeach
                    @if($prediction->skinType->ingredients->where('type', 'bad')->isEmpty())
                        <li style="color: #7f8c8d; font-size: 14px; font-style: italic;">Belum ada data kandungan.</li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="bottom-section">
            <div class="ai-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
            <p class="bottom-text">
                Rekomendasi berdasarkan analisis AI. Hasil dapat bervariasi sesuai individu, Konsultasikan dengan dermatologis untuk perawatan yang lebih spesifik.
            </p>
            <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-top: 10px;">
                <a href="{{ route('scanner') }}" class="scan-again-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Scan Ulang
                </a>
                {{-- <a href="{{ route('questionnaire', ['prediction' => $prediction->id]) }}" class="scan-again-btn" style="border-color: #81c784; color: #2e7d32; background: #e8f5e9;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Isi Kuisioner
                </a> --}}
            </div>
        </div>
    </div>

    @if($rankedProducts->count() > 0)
        @php
            $topProduct = $rankedProducts->first();
            $skinName = strtolower((string) ($prediction->skinType->name ?? ''));
            $skinNameLabel = match ($skinName) {
                'dry' => 'kering',
                'oily' => 'berminyak',
                'normal' => 'normal',
                default => ucfirst((string) ($prediction->skinType->name ?? '')),
            };

            // Penjelasan dibuat beda per tipe kulit (case): kering / normal / berminyak
            $c1Value = (int) $topProduct->c1_kandungan;
            $c2Value = (int) $topProduct->c2_iritatif;
            $c1Explain = match ($skinName) {
                'dry' => match ($c1Value) {
                    4 => 'Untuk kulit kering: kandungan aktif sangat tinggi membantu menjaga kelembapan dan memperkuat skin barrier, jadi kulit terasa lebih nyaman.',
                    3 => 'Untuk kulit kering: kandungan aktif tinggi membantu hidrasi dan perawatan rutin tanpa terasa “kasar” di kulit.',
                    2 => 'Untuk kulit kering: kandungan aktif sedang cenderung lebih gentle untuk pemakaian harian dan minim risiko kulit terasa ketarik.',
                    1 => 'Untuk kulit kering: kandungan aktif rendah biasanya paling aman kalau kulit sedang sensitif/lagi kering-keringnya.',
                    default => 'Untuk kulit kering: kandungan aktifnya dinilai seimbang untuk pemakaian rutin.',
                },
                'oily' => match ($c1Value) {
                    4 => 'Untuk kulit berminyak: kandungan aktif sangat tinggi membantu kontrol minyak, membersihkan pori, dan membantu mencegah jerawat.',
                    3 => 'Untuk kulit berminyak: kandungan aktif tinggi cukup efektif untuk kontrol sebum dan menjaga kulit tetap bersih.',
                    2 => 'Untuk kulit berminyak: kandungan aktif sedang tetap membantu perawatan harian tanpa terasa terlalu “keras”.',
                    1 => 'Untuk kulit berminyak: kandungan aktif rendah cocok bila kamu lebih fokus ke pembersihan gentle dan menjaga skin barrier.',
                    default => 'Untuk kulit berminyak: kandungan aktifnya dinilai seimbang untuk pemakaian rutin.',
                },
                'normal' => match ($c1Value) {
                    4 => 'Untuk kulit normal: kandungan aktif sangat tinggi membantu hasil lebih terasa, tapi tetap perhatikan respons kulit.',
                    3 => 'Untuk kulit normal: kandungan aktif tinggi membantu menjaga kulit tetap bersih dan terawat dengan baik.',
                    2 => 'Untuk kulit normal: kandungan aktif sedang biasanya paling “aman” dan nyaman untuk pemakaian harian.',
                    1 => 'Untuk kulit normal: kandungan aktif rendah cocok bila kamu ingin opsi yang simpel dan gentle.',
                    default => 'Untuk kulit normal: kandungan aktifnya dinilai seimbang untuk pemakaian rutin.',
                },
                default => match ($c1Value) {
                    4 => 'Kandungan aktifnya sangat tinggi, membantu menargetkan kebutuhan utama kulit.',
                    3 => 'Kandungan aktifnya tinggi, cukup efektif untuk perawatan rutin.',
                    2 => 'Kandungan aktifnya sedang, cenderung aman untuk pemakaian harian.',
                    1 => 'Kandungan aktifnya rendah, biasanya terasa lebih gentle.',
                    default => 'Kandungan aktifnya dinilai seimbang untuk pemakaian rutin.',
                },
            };

            $c2Explain = match ($skinName) {
                'dry' => match ($c2Value) {
                    1 => 'Untuk kulit kering: minim iritan membantu mengurangi risiko kulit makin kering/terasa perih saat dipakai rutin.',
                    2 => 'Untuk kulit kering: ada sedikit potensi iritasi, jadi sebaiknya perhatikan bila kulit mudah perih atau mengelupas.',
                    3 => 'Untuk kulit kering: potensi iritasi lebih tinggi, disarankan coba bertahap (patch test) agar tidak memicu kering/kemerahan.',
                    default => 'Untuk kulit kering: potensi iritasinya dinilai moderat.',
                },
                'oily' => match ($c2Value) {
                    1 => 'Untuk kulit berminyak: minim iritan membuatnya lebih aman dipakai rutin tanpa memicu kemerahan yang tidak perlu.',
                    2 => 'Untuk kulit berminyak: ada sedikit potensi iritasi, tetap aman untuk banyak orang tapi pantau kalau muncul kering/ketarik.',
                    3 => 'Untuk kulit berminyak: potensi iritasi lebih tinggi, jadi lebih baik mulai pelan-pelan agar tidak mengganggu skin barrier.',
                    default => 'Untuk kulit berminyak: potensi iritasinya dinilai moderat.',
                },
                'normal' => match ($c2Value) {
                    1 => 'Untuk kulit normal: minim iritan membuatnya aman untuk pemakaian rutin.',
                    2 => 'Untuk kulit normal: ada sedikit potensi iritasi, tetap pantau reaksi kulit terutama bila sensitif.',
                    3 => 'Untuk kulit normal: potensi iritasi lebih tinggi, sebaiknya coba bertahap agar kulit tetap nyaman.',
                    default => 'Untuk kulit normal: potensi iritasinya dinilai moderat.',
                },
                default => match ($c2Value) {
                    1 => 'Tidak terdeteksi bahan iritan utama, jadi relatif lebih aman untuk pemakaian rutin.',
                    2 => 'Ada sedikit potensi iritan, tapi masih tergolong moderat untuk banyak orang.',
                    3 => 'Ada beberapa potensi iritan, jadi disarankan coba bertahap/patch test terlebih dulu.',
                    default => 'Potensi iritasinya dinilai moderat untuk pemakaian rutin.',
                },
            };
            $c3Explain = match ((int) $topProduct->c3_harga) {
                1 => 'Harganya terjangkau, cocok untuk pemakaian rutin tanpa terlalu membebani budget.',
                2 => 'Harganya masih di range yang aman untuk pemakaian rutin.',
                3 => 'Harganya menengah–premium, biasanya seimbang antara kualitas dan biaya pemakaian.',
                4 => 'Harganya premium, namun dipilih karena faktor lain (kandungan/keamanan/tekstur) tetap paling cocok secara keseluruhan.',
                default => 'Harganya dinilai seimbang dibanding manfaat yang didapat.',
            };
            $tekstur = strtolower((string) ($topProduct->c4_tekstur ?? ''));
            $c4Explain = match ($skinName) {
                'dry' => match ($tekstur) {
                    'cream' => 'Untuk kulit kering: tekstur cream cenderung lebih lembap dan nyaman, membantu mengurangi rasa ketarik setelah cuci muka.',
                    'gel' => 'Untuk kulit kering: tekstur gel terasa ringan, tapi pastikan kulit tetap terasa nyaman (tidak ketarik) setelah pemakaian.',
                    'foam' => 'Untuk kulit kering: foam bisa terasa lebih “kesat”, jadi pilih yang lembut supaya tidak bikin kulit makin kering.',
                    default => 'Untuk kulit kering: teksturnya dipilih agar tetap nyaman untuk pemakaian harian.',
                },
                'oily' => match ($tekstur) {
                    'gel' => 'Untuk kulit berminyak: tekstur gel biasanya paling nyaman karena ringan dan tidak terasa berat di kulit.',
                    'foam' => 'Untuk kulit berminyak: foam memberi sensasi bersih dan membantu mengangkat minyak berlebih.',
                    'cream' => 'Untuk kulit berminyak: cream terasa lebih rich, cocok bila kulit juga mudah dehidrasi/ketarik.',
                    default => 'Untuk kulit berminyak: teksturnya dipilih agar nyaman dan tetap terasa bersih.',
                },
                'normal' => match ($tekstur) {
                    'foam' => 'Untuk kulit normal: foam terasa praktis dan memberi sensasi bersih untuk pemakaian harian.',
                    'gel' => 'Untuk kulit normal: gel terasa ringan dan nyaman, cocok untuk penggunaan rutin.',
                    'cream' => 'Untuk kulit normal: cream terasa lebih lembap, cocok bila ingin hasil akhir lebih “hydrated”.',
                    default => 'Untuk kulit normal: teksturnya dipilih agar nyaman untuk pemakaian harian.',
                },
                default => match ($tekstur) {
                    'gel' => 'Tekstur gel terasa ringan dan cepat menyerap.',
                    'foam' => 'Tekstur foam umumnya memberi sensasi bersih dan praktis.',
                    'cream' => 'Tekstur cream terasa lebih rich dan membantu menjaga kelembapan.',
                    default => 'Teksturnya dipilih karena nyaman dan cocok untuk pemakaian harian.',
                },
            };
            $topProductImage = null;
            if (!empty($topProduct->image_url)) {
                $imagePath = ltrim((string) $topProduct->image_url, '/');
                if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://'])) {
                    $topProductImage = $imagePath;
                } elseif (\Illuminate\Support\Str::startsWith($imagePath, 'storage/')) {
                    $topProductImage = asset($imagePath);
                } else {
                    $topProductImage = asset('storage/' . $imagePath);
                }
            }
        @endphp

        <div class="top1-overlay" id="top1Popup" aria-hidden="true">
            <div class="top1-modal" role="dialog" aria-modal="true" aria-label="Rekomendasi Produk Terbaik">
                <div class="top1-header">
                    <div>
                        <h2 class="top1-title">Rekomendasi Terbaik untuk {{ ucfirst($prediction->skinType->name) }}</h2>
                        <p class="top1-subtitle">Dipilih sebagai rekomendasi utama berdasarkan kandungan, potensi iritasi, harga, dan tekstur</p>
                    </div>
                    <button type="button" class="top1-close" onclick="closeTop1Popup()" aria-label="Tutup popup">✕</button>
                </div>

                <div class="top1-body">
                    <div class="top1-product-image">
                        <img
                            src="{{ $topProductImage ?: 'data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"120\" height=\"160\" viewBox=\"0 0 120 160\"><rect width=\"120\" height=\"160\" rx=\"10\" fill=\"%23f1f3f5\"/><text x=\"60\" y=\"84\" text-anchor=\"middle\" font-family=\"Arial, sans-serif\" font-size=\"12\" fill=\"%236c757d\">No Image</text></svg>' }}"
                            alt="{{ $topProduct->name }}"
                        >
                    </div>

                    <div class="top1-meta">
                        <div class="top1-rank-row">
                            <div class="top1-rank-badge">
                                <span class="rank-circle">1</span>
                                #1 Produk Teratas
                            </div>
                        </div>

                        <h3 class="top1-product-name">{{ $topProduct->name }}</h3>
                        <p class="top1-product-brand">{{ $topProduct->brand ?? '-' }}</p>
                        <div class="top1-price">Rp {{ number_format($topProduct->price ?? 0, 0, ',', '.') }}</div>

                        <div class="top1-reason">
                            <h4><span>✅</span>Alasan direkomendasikan</h4>
                            <p>
                                Kulit wajah kamu terdeteksi sebagai <strong>{{ $skinNameLabel }}</strong>.
                                Ini rekomendasi utama yang paling cocok untuk kamu, dilihat dari beberapa faktor penting berikut.
                            </p>
                            <ul>
                                <li>
                                    <strong>Kandungan aktif</strong>: {{ $topProduct->c1_label }}
                                    <div style="color:#6b7280; font-size:12.5px; margin-top:4px;">{{ $c1Explain }}</div>
                                </li>
                                <li>
                                    <strong>Potensi iritasi</strong>: {{ $topProduct->c2_label }}
                                    <div style="color:#6b7280; font-size:12.5px; margin-top:4px;">{{ $c2Explain }}</div>
                                </li>
                                <li>
                                    <strong>Harga</strong>: {{ $topProduct->c3_label }}
                                    <div style="color:#6b7280; font-size:12.5px; margin-top:4px;">{{ $c3Explain }}</div>
                                </li>
                                <li>
                                    <strong>Tekstur</strong>: {{ ucfirst($topProduct->c4_tekstur) }}
                                    <div style="color:#6b7280; font-size:12.5px; margin-top:4px;">{{ $c4Explain }}</div>
                                </li>
                            </ul>
                        </div>

                        <div class="top1-actions">
                            @php
                                $topBuyLink = trim((string) $topProduct->link_produk);
                                $topBuyLinkIsUsable = $topBuyLink !== '' && preg_match('/^https?:\\/\\//i', $topBuyLink);
                            @endphp

                            @if($topBuyLinkIsUsable)
                                <a class="buy-btn" href="{{ $topBuyLink }}" target="_blank" rel="noopener noreferrer">Beli Sekarang</a>
                            @else
                                <button class="buy-btn" type="button" onclick="alert('Link produk belum tersedia.')">Beli Sekarang</button>
                            @endif
                            <button type="button" class="btn-secondary-ghost" onclick="closeTop1Popup()">Lihat semua rekomendasi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        // Modal functionality has been removed

        function openTop1Popup() {
            var el = document.getElementById('top1Popup');
            if (!el) return;
            el.classList.add('show');
            el.setAttribute('aria-hidden', 'false');
        }

        function closeTop1Popup() {
            var el = document.getElementById('top1Popup');
            if (!el) return;
            el.classList.remove('show');
            el.setAttribute('aria-hidden', 'true');
        }

        document.addEventListener('DOMContentLoaded', function () {
            var overlay = document.getElementById('top1Popup');
            if (!overlay) return;

            openTop1Popup();

            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) closeTop1Popup();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeTop1Popup();
            });
        });

    </script>
</body>
</html>
