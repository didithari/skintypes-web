@extends('admin.layouts.app')

@section('title', 'Skin Types')
@section('header_title', 'Skin Types')

@section('content')
    <section class="card page-card">
        <div class="toolbar">
            <h2 class="page-title" style="margin:0;">Skin Types</h2>
            <span class="muted">Data tetap dari API (id 0, 1, 2)</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>API ID</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Total Product</th>
                        <th>Total Prediction</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($skinTypes as $skinType)
                        <tr>
                            <td>{{ $skinType->api_id }}</td>
                            <td>{{ $skinType->name }}</td>
                            <td>{{ $skinType->description ?? '-' }}</td>
                            <td>{{ $skinType->products_count }}</td>
                            <td>{{ $skinType->predictions_count }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-secondary" href="{{ route('admin.skin-types.edit', $skinType) }}">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="muted">Belum ada data skin type.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">{{ $skinTypes->links() }}</div>
    </section>
@endsection
