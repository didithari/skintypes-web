@extends('admin.layouts.app')

@section('title', 'Preview Perangkingan SAW')
@section('header_title', 'Preview SAW')

@section('content')
    <style>
        /* ── SAW Preview Styles ── */
        .saw-hero {
            background: linear-gradient(135deg, #059669 0%, #047857 50%, #065f46 100%);
            color: #fff;
            border-radius: 16px;
            padding: 28px 32px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        .saw-hero::after {
            content: '';
            position: absolute;
            right: -30px;
            top: -30px;
            width: 180px;
            height: 180px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
        }
        .saw-hero h2 {
            margin: 0 0 6px;
            font-size: 26px;
            font-weight: 800;
        }
        .saw-hero p {
            margin: 0;
            opacity: 0.85;
            font-size: 14px;
            max-width: 600px;
        }

        /* Filter tabs */
        .skin-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        .skin-tab {
            padding: 10px 20px;
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            background: #fff;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #4b5563;
        }
        .skin-tab:hover {
            border-color: #059669;
            color: #059669;
            background: #f0fdf4;
        }
        .skin-tab.active {
            background: #059669;
            color: #fff;
            border-color: #059669;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        /* Section cards */
        .saw-section {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .saw-section-title {
            margin: 0 0 4px;
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .saw-section-subtitle {
            margin: 0 0 16px;
            color: #6b7280;
            font-size: 13px;
        }

        /* Weight cards */
        .weight-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }
        .weight-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            transition: transform 0.2s ease;
        }
        .weight-card:hover {
            transform: translateY(-2px);
        }
        .weight-card .criteria-code {
            font-size: 13px;
            font-weight: 800;
            color: #059669;
            margin-bottom: 4px;
        }
        .weight-card .criteria-name {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 8px;
        }
        .weight-card .criteria-weight {
            font-size: 28px;
            font-weight: 800;
            color: #047857;
        }
        .weight-card .criteria-type {
            display: inline-block;
            margin-top: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 3px 10px;
            border-radius: 999px;
        }
        .type-benefit {
            background: #dbeafe;
            color: #1d4ed8;
        }
        .type-cost {
            background: #fef3c7;
            color: #b45309;
        }

        /* SAW Tables */
        .saw-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .saw-table thead th {
            background: #f9fafb;
            color: #374151;
            font-weight: 700;
            padding: 12px 14px;
            border-bottom: 2px solid #e5e7eb;
            text-align: center;
            white-space: nowrap;
        }
        .saw-table thead th:first-child {
            text-align: left;
        }
        .saw-table tbody td {
            padding: 10px 14px;
            border-bottom: 1px solid #f3f4f6;
            text-align: center;
        }
        .saw-table tbody td:first-child {
            text-align: left;
            font-weight: 600;
            color: #111827;
        }
        .saw-table tbody tr:hover {
            background: #f0fdf4;
        }
        .saw-table .highlight-max {
            background: #dcfce7;
            font-weight: 700;
            color: #047857;
            border-radius: 4px;
        }
        .saw-table .highlight-min {
            background: #fef9c3;
            font-weight: 700;
            color: #92400e;
            border-radius: 4px;
        }

        /* Rank badge */
        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-weight: 800;
            font-size: 14px;
        }
        .rank-1 { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #78350f; box-shadow: 0 2px 8px rgba(245,158,11,0.4); }
        .rank-2 { background: linear-gradient(135deg, #d1d5db, #9ca3af); color: #374151; box-shadow: 0 2px 6px rgba(156,163,175,0.3); }
        .rank-3 { background: linear-gradient(135deg, #f97316, #ea580c); color: #fff; box-shadow: 0 2px 6px rgba(249,115,22,0.3); }
        .rank-other { background: #f3f4f6; color: #6b7280; }

        /* V score bar */
        .v-score-cell {
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
        }
        .v-score-bar {
            width: 80px;
            height: 8px;
            background: #e5e7eb;
            border-radius: 999px;
            overflow: hidden;
        }
        .v-score-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, #34d399, #059669);
            transition: width 0.6s ease;
        }
        .v-score-value {
            font-weight: 800;
            color: #047857;
            font-size: 14px;
            min-width: 50px;
        }

        /* Formula display */
        .formula-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px 18px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: #334155;
            margin-bottom: 16px;
            line-height: 1.7;
        }
        .formula-box .formula-label {
            font-family: 'Segoe UI', sans-serif;
            font-weight: 700;
            color: #059669;
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Info tag */
        .info-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }
        .info-tag-blue { background: #dbeafe; color: #1d4ed8; }
        .info-tag-amber { background: #fef3c7; color: #b45309; }

        /* Info tooltip (small i icon) */
        .info-tooltip-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        .info-tooltip {
            appearance: none;
            border: 0;
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: #eef2f7;
            color: #475569;
            font-size: 12px;
            font-weight: 900;
            line-height: 1;
            cursor: pointer;
            user-select: none;
            padding: 0;
        }
        .info-tooltip:hover {
            background: #dcfce7;
            color: #047857;
        }
        .info-tooltip:focus {
            outline: 2px solid #059669;
            outline-offset: 2px;
        }
        .info-popover {
            position: absolute;
            top: calc(100% + 10px);
            left: 50%;
            width: min(520px, 80vw);
            min-width: 280px;
            max-height: 240px;
            overflow: auto;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 14px 16px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
            color: #111827;
            font-size: 12px;
            line-height: 1.6;
            z-index: 9999;
            opacity: 0;
            transform: translate(-50%, -4px);
            pointer-events: none;
        }
        .info-popover::before {
            content: '';
            position: absolute;
            top: -6px;
            left: 50%;
            width: 12px;
            height: 12px;
            background: #ffffff;
            border-left: 1px solid #e5e7eb;
            border-top: 1px solid #e5e7eb;
            transform: translateX(-50%) rotate(45deg);
        }
        .info-tooltip-wrap:hover .info-popover,
        .info-tooltip-wrap:focus-within .info-popover {
            opacity: 1;
            transform: translate(-50%, 0);
            pointer-events: auto;
        }
        .info-popover p {
            margin: 0 0 10px;
        }
        .info-popover p:last-child {
            margin-bottom: 0;
        }
        .info-popover strong {
            color: #047857;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #9ca3af;
        }
        .empty-state .empty-icon {
            font-size: 48px;
            margin-bottom: 12px;
        }
        .empty-state h3 {
            color: #6b7280;
            margin: 0 0 6px;
            font-size: 18px;
        }
        .empty-state p {
            margin: 0;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .weight-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .weight-grid { grid-template-columns: 1fr; }
            .saw-hero { padding: 20px; }
        }
    </style>

    {{-- Hero Banner --}}
    <div class="saw-hero">
        <h2>📊 Preview Perangkingan SAW</h2>
        <p>Simulasi perhitungan metode Simple Additive Weighting (SAW) untuk seluruh data produk berdasarkan jenis kulit. Menampilkan matriks keputusan, normalisasi, dan skor preferensi akhir.</p>
    </div>

    {{-- Bobot Kriteria --}}
    <div class="saw-section">
        <h3 class="saw-section-title">⚖️ Bobot Kriteria (W)</h3>
        <p class="saw-section-subtitle">Bobot yang digunakan dalam perhitungan SAW. Total bobot = 1.00</p>

        <div class="weight-grid">
            <div class="weight-card">
                <div class="criteria-code">C1</div>
                <div class="criteria-name">Kandungan Aktif</div>
                <div class="criteria-weight">{{ $weights['c1'] }}</div>
                <span class="criteria-type type-benefit">Benefit</span>
            </div>
            <div class="weight-card">
                <div class="criteria-code">C2</div>
                <div class="criteria-name">Kandungan Iritatif</div>
                <div class="criteria-weight">{{ $weights['c2'] }}</div>
                <span class="criteria-type type-cost">Cost</span>
            </div>
            <div class="weight-card">
                <div class="criteria-code">C3</div>
                <div class="criteria-name">Range Harga</div>
                <div class="criteria-weight">{{ $weights['c3'] }}</div>
                <span class="criteria-type type-cost">Cost</span>
            </div>
            <div class="weight-card">
                <div class="criteria-code">C4</div>
                <div class="criteria-name">Tekstur</div>
                <div class="criteria-weight">{{ $weights['c4'] }}</div>
                <span class="criteria-type type-benefit">Benefit</span>
            </div>
        </div>

        <div class="formula-box">
            <span class="formula-label">Rumus Normalisasi</span>
            Benefit → R = Xᵢⱼ / Max(Xⱼ)<br>
            Cost &nbsp;&nbsp;&nbsp;→ R = Min(Xⱼ) / Xᵢⱼ
        </div>
        <div class="formula-box">
            <span class="formula-label">Rumus Nilai Preferensi</span>
            V = (W₁ × R₁) + (W₂ × R₂) + (W₃ × R₃) + (W₄ × R₄)
        </div>
    </div>

    {{-- Skin Type Tabs --}}
    <div class="skin-tabs">
        <a href="{{ route('admin.products.saw-preview') }}"
           class="skin-tab {{ is_null($activeSkinType) ? 'active' : '' }}">
            📋 Semua
        </a>
        @foreach($skinTypes as $st)
            <a href="{{ route('admin.products.saw-preview', ['skin_type' => $st->id]) }}"
               class="skin-tab {{ $activeSkinType == $st->id ? 'active' : '' }}">
                {{ ucfirst($st->name) }}
            </a>
        @endforeach
    </div>

    @foreach($rankedGroups as $groupName => $group)
        @if($group['products']->isEmpty())
            @continue
        @endif

        @php
            $products = $group['products'];
            $maxV = $products->max(fn($p) => $p->saw_details['v'] ?? 0);
        @endphp

        {{-- Group Title --}}
        <div class="saw-section" style="border-left: 4px solid #059669;">
            <h3 class="saw-section-title">
                🧴 {{ ucfirst($groupName) }}
                <span style="font-size:13px; font-weight:400; color:#6b7280;">({{ $products->count() }} produk)</span>
            </h3>
        </div>

        {{-- Step 1: Matriks Keputusan --}}
        <div class="saw-section">
            <h3 class="saw-section-title">
                📐 Matriks Keputusan
                <span class="info-tooltip-wrap">
                    <button type="button" class="info-tooltip" aria-label="Info kriteria benefit dan cost">i</button>
                    <div class="info-popover" role="tooltip">
                        <p><strong>Kriteria Benefit / Keuntungan (R1 - Kandungan &amp; R4 - Tekstur):</strong> Menggunakan prinsip semakin tinggi skor kriteria, maka semakin baik. Produk yang kandungannya paling kaya atau teksturnya paling cocok akan mendapatkan nilai mendekati atau tepat 1.00.</p>
                        <p><strong>Kriteria Cost / Biaya (R2 - Bahan Iritatif &amp; R3 - Harga):</strong> Menggunakan prinsip semakin rendah skor kriteria, maka semakin bagus. Sistem secara otomatis membalikkan nilai lewat rumus cost, sehingga produk yang paling aman (iritan paling sedikit) atau paling murah justru akan mendapatkan nilai tertinggi yaitu 1.00.</p>
                    </div>
                </span>
            </h3>
            <p class="saw-section-subtitle">Nilai kriteria asli setiap alternatif produk</p>
            <div class="table-wrap">
                <table class="saw-table">
                    <thead>
                        <tr>
                            <th>Alternatif</th>
                            <th>Produk</th>
                            <th>C1 <span class="info-tag info-tag-blue">Benefit</span></th>
                            <th>C2 <span class="info-tag info-tag-amber">Cost</span></th>
                            <th>C3 <span class="info-tag info-tag-amber">Cost</span></th>
                            <th>C4 <span class="info-tag info-tag-blue">Benefit</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>A{{ $loop->iteration }}</td>
                                <td style="text-align:left;">
                                    <strong>{{ $product->name }}</strong>
                                    <span style="color:#9ca3af; font-size:11px; display:block;">{{ $product->brand ?? '-' }}</span>
                                </td>
                                <td>{{ $product->c1_kandungan }}</td>
                                <td>{{ $product->c2_iritatif }}</td>
                                <td>{{ $product->c3_harga }}</td>
                                <td>{{ $group['teksturMap'][$product->c4_tekstur] ?? 2 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Step 2: Matriks Normalisasi --}}
        <div class="saw-section">
            <h3 class="saw-section-title">
                🔄 Matriks Normalisasi (R)
                <span class="info-tooltip-wrap">
                    <button type="button" class="info-tooltip" aria-label="Info kriteria benefit dan cost">i</button>
                    <div class="info-popover" role="tooltip">
                        <p><strong>Kriteria Benefit / Keuntungan (R1 - Kandungan &amp; R4 - Tekstur):</strong> Menggunakan prinsip semakin tinggi skor kriteria, maka semakin baik. Produk yang kandungannya paling kaya atau teksturnya paling cocok akan mendapatkan nilai mendekati atau tepat 1.00.</p>
                        <p><strong>Kriteria Cost / Biaya (R2 - Bahan Iritatif &amp; R3 - Harga):</strong> Menggunakan prinsip semakin rendah skor kriteria, maka semakin bagus. Sistem secara otomatis membalikkan nilai lewat rumus cost, sehingga produk yang paling aman (iritan paling sedikit) atau paling murah justru akan mendapatkan nilai tertinggi yaitu 1.00.</p>
                    </div>
                </span>
            </h3>
            <p class="saw-section-subtitle">Nilai ternormalisasi menggunakan rumus Benefit/Cost</p>
            <div class="table-wrap">
                <table class="saw-table">
                    <thead>
                        <tr>
                            <th>Alternatif</th>
                            <th>Produk</th>
                            <th>R1 (C1)</th>
                            <th>R2 (C2)</th>
                            <th>R3 (C3)</th>
                            <th>R4 (C4)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            @php $d = $product->saw_details; @endphp
                            <tr>
                                <td>A{{ $loop->iteration }}</td>
                                <td style="text-align:left;">{{ $product->name }}</td>
                                <td>{{ number_format($d['r1'], 4) }}</td>
                                <td>{{ number_format($d['r2'], 4) }}</td>
                                <td>{{ number_format($d['r3'], 4) }}</td>
                                <td>{{ number_format($d['r4'], 4) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Step 3: Perhitungan Nilai Preferensi --}}
        <div class="saw-section">
            <h3 class="saw-section-title">🧮 Perhitungan Nilai Preferensi (V)</h3>
            <p class="saw-section-subtitle">V = Σ (Wⱼ × Rᵢⱼ) — detail per alternatif</p>
            <div class="table-wrap">
                <table class="saw-table">
                    <thead>
                        <tr>
                            <th>Alternatif</th>
                            <th>Produk</th>
                            <th>W1×R1</th>
                            <th>W2×R2</th>
                            <th>W3×R3</th>
                            <th>W4×R4</th>
                            <th>V (Total)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            @php
                                $d = $product->saw_details;
                                $wr1 = $weights['c1'] * $d['r1'];
                                $wr2 = $weights['c2'] * $d['r2'];
                                $wr3 = $weights['c3'] * $d['r3'];
                                $wr4 = $weights['c4'] * $d['r4'];
                            @endphp
                            <tr>
                                <td>A{{ $loop->iteration }}</td>
                                <td style="text-align:left;">{{ $product->name }}</td>
                                <td>{{ number_format($wr1, 4) }}</td>
                                <td>{{ number_format($wr2, 4) }}</td>
                                <td>{{ number_format($wr3, 4) }}</td>
                                <td>{{ number_format($wr4, 4) }}</td>
                                <td>
                                    <div class="v-score-cell">
                                        <div class="v-score-bar">
                                            <div class="v-score-fill" style="width: {{ $maxV > 0 ? ($d['v'] / $maxV) * 100 : 0 }}%"></div>
                                        </div>
                                        <span class="v-score-value">{{ number_format($d['v'], 4) }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Step 4: Hasil Perangkingan --}}
        <div class="saw-section" style="border: 2px solid #a7f3d0;">
            <h3 class="saw-section-title">🏆 Hasil Perangkingan</h3>
            <p class="saw-section-subtitle">Produk diurutkan berdasarkan nilai preferensi (V) tertinggi</p>
            <div class="table-wrap">
                <table class="saw-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Produk</th>
                            <th>Brand</th>
                            <th>Harga</th>
                            <th>Tekstur</th>
                            <th>Nilai V</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            @php
                                $rank = $product->saw_rank;
                                $badgeClass = match(true) {
                                    $rank === 1 => 'rank-1',
                                    $rank === 2 => 'rank-2',
                                    $rank === 3 => 'rank-3',
                                    default => 'rank-other',
                                };
                            @endphp
                            <tr style="{{ $rank <= 3 ? 'background:#f0fdf4;' : '' }}">
                                <td>
                                    <span class="rank-badge {{ $badgeClass }}">{{ $rank }}</span>
                                </td>
                                <td style="text-align:left;">
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        @if($product->image_url)
                                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" style="width:40px; height:40px; object-fit:cover; border-radius:8px; border: 1px solid #e5e7eb;">
                                        @else
                                            <div style="width:40px; height:40px; background:#f3f4f6; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:10px;">No img</div>
                                        @endif
                                        <div>
                                            <strong>{{ $product->name }}</strong>
                                            <span style="display:block; font-size:11px; color:#6b7280;">{{ $product->skinType->name ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product->brand ?? '-' }}</td>
                                <td>{{ $product->price ? 'Rp ' . number_format($product->price, 0, ',', '.') : '-' }}</td>
                                <td><span class="badge" style="text-transform:capitalize;">{{ $product->c4_tekstur }}</span></td>
                                <td>
                                    <div class="v-score-cell">
                                        <div class="v-score-bar">
                                            <div class="v-score-fill" style="width: {{ $maxV > 0 ? ($product->saw_details['v'] / $maxV) * 100 : 0 }}%"></div>
                                        </div>
                                        <span class="v-score-value">{{ number_format($product->saw_details['v'], 4) }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endforeach

    @if($rankedGroups->every(fn($g) => $g['products']->isEmpty()))
        <div class="saw-section">
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>Belum Ada Data Produk</h3>
                <p>Tambahkan produk terlebih dahulu untuk melihat preview perangkingan SAW.</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="margin-top:16px;">+ Tambah Product</a>
            </div>
        </div>
    @endif

@endsection
