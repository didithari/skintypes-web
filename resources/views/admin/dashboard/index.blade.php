@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('header_title', 'Dashboard Overview')

@section('content')
    <div class="stat-grid">
        <article class="card stat-card">
            <div class="stat-icon" style="background:#d1fae5; color:#059669;">🧠</div>
            <div class="stat-label">Total Predictions</div>
            <div class="stat-value">{{ number_format($totalPredictions) }}</div>
        </article>

        <article class="card stat-card">
            <div class="stat-icon" style="background:#ede9fe; color:#7c3aed;">💧</div>
            <div class="stat-label">Most Detected</div>
            <div class="stat-value" style="font-size:38px;">{{ $mostDetected }}</div>
        </article>

        <article class="card stat-card">
            <div class="stat-icon" style="background:#ffedd5; color:#ea580c;">👜</div>
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ number_format($totalProducts) }}</div>
        </article>
    </div>

    <section class="card page-card">
        <div class="panel-header">
            <h2 class="panel-title">Predictions Analytics</h2>
            <select class="panel-select" disabled>
                <option>Last 7 Days</option>
            </select>
        </div>

        <div class="analytics-body">Area analytics</div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Skin Type</th>
                        <th>Confidence</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPredictions as $prediction)
                        <tr>
                            <td>{{ optional($prediction->predicted_at ?? $prediction->created_at)->format('d M Y H:i') }}</td>
                            <td>{{ $prediction->skinType->name ?? '-' }}</td>
                            <td>{{ $prediction->confidence !== null ? number_format((float) $prediction->confidence * 100, 2) . '%' : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="muted">Belum ada data prediksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
