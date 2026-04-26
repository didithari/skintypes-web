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

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.12);
        }

        .badge {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 1;
        }

        .badge-success {
            background: #81c784;
            color: white;
        }

        .badge-danger {
            background: #e57373;
            color: white;
        }

        .favorite-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: white;
            border: none;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }

        .favorite-btn:hover {
            background: #fee;
        }

        .favorite-btn svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: #e57373;
            stroke-width: 2;
        }

        .product-image {
            width: 100%;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
        }

        .product-image img {
            max-width: 120px;
            max-height: 160px;
            object-fit: contain;
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

        /* Modal Styles have been removed */

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

        /* Research Popup Styles */
        .research-popup-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(3px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .research-popup-overlay.show {
            display: flex;
            opacity: 1;
        }

        .research-popup-content {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 15px 50px rgba(0,0,0,0.2);
            transform: translateY(20px);
            transition: transform 0.3s ease;
            position: relative;
        }

        .research-popup-overlay.show .research-popup-content {
            transform: translateY(0);
        }

        .research-popup-title {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .research-popup-desc {
            font-size: 15px;
            color: #555;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .research-popup-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-direction: column;
        }

        .btn-boleh {
            background: #81c784;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: block;
        }

        .btn-boleh:hover {
            background: #66bb6a;
        }

        .btn-nanti {
            background: transparent;
            color: #7f8c8d;
            border: 2px solid #ecf0f1;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-nanti:hover {
            background: #f8f9fa;
            color: #2c3e50;
            border-color: #bdc3c7;
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
        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $index => $product)
                    <div class="product-card">
                        <!-- Badge -->
                        @if($index % 3 === 0)
                            <div class="badge badge-success">Best Seller</div>
                        @elseif($index % 3 === 1)
                            <div class="badge badge-danger">Best Price</div>
                        @endif

                        <!-- Favorite Button -->
                        <button class="favorite-btn" onclick="toggleFavorite(this)">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>

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
                        <button class="buy-btn" onclick="buyProduct('{{ $product->name }}')">
                            Beli Sekarang
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-products">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3>Belum Ada Produk</h3>
                <p>Produk untuk tipe kulit {{ $prediction->skinType->name }} akan segera tersedia</p>
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
                <a href="{{ route('questionnaire', ['prediction' => $prediction->id]) }}" class="scan-again-btn" style="border-color: #81c784; color: #2e7d32; background: #e8f5e9;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Isi Kuisioner
                </a>
            </div>
        </div>
    </div>

    <!-- Research Popup -->
    <div class="research-popup-overlay" id="researchPopup">
        <div class="research-popup-content">
            <h2 class="research-popup-title">Bantu Riset Skripsi Saya? 🙏</h2>
            <p class="research-popup-desc">Hanya butuh 1 menit untuk menjawab beberapa pertanyaan singkat. Bantuanmu sangat berharga!</p>
            <div class="research-popup-actions">
                <a href="{{ route('questionnaire', ['prediction' => $prediction->id]) }}" class="btn-boleh">Boleh, bantu isi</a>
                <button class="btn-nanti" onclick="closeResearchPopup()">Mungkin nanti</button>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality has been removed

        function toggleFavorite(btn) {
            const svg = btn.querySelector('svg');
            const path = svg.querySelector('path');
            
            if (svg.style.fill === 'none' || !svg.style.fill) {
                svg.style.fill = '#e57373';
                svg.style.stroke = 'none';
            } else {
                svg.style.fill = 'none';
                svg.style.stroke = '#e57373';
            }
        }

        function buyProduct(productName) {
            alert('Fitur pembelian untuk "' + productName + '" akan segera tersedia!');
            // Implementasi redirect ke marketplace atau checkout page
        }

        // Research popup logic
        setTimeout(() => {
            const popup = document.getElementById('researchPopup');
            popup.style.display = 'flex';
            // Trigger reflow
            void popup.offsetWidth;
            popup.classList.add('show');
        }, 10000);

        function closeResearchPopup() {
            const popup = document.getElementById('researchPopup');
            popup.classList.remove('show');
            setTimeout(() => {
                popup.style.display = 'none';
            }, 300);
        }
    </script>
</body>
</html>
