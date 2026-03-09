@extends('admin.layouts.app')

@section('title', 'Products')
@section('header_title', 'Products')

@section('content')
    <section class="card page-card">
        <div class="toolbar">
            <h2 class="page-title" style="margin:0;">Products</h2>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Tambah Product</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Brand</th>
                        <th>Skin Type</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                @if($product->image_url)
                                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" style="width:50px; height:50px; object-fit:cover; border-radius:6px;">
                                @else
                                    <div style="width:50px; height:50px; background:#f3f4f6; border-radius:6px; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:12px;">No image</div>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->brand ?? '-' }}</td>
                            <td><span class="badge">{{ $product->skinType->name ?? '-' }}</span></td>
                            <td>{{ $product->price ? 'Rp ' . number_format($product->price, 0, ',', '.') : '-' }}</td>
                            <td>{{ Str::words($product->description, 5, '...') ?? '-' }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-secondary" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                                    <form class="js-delete-form" data-delete-label="Product {{ $product->name }} akan dihapus permanen." action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="muted">Belum ada data product.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">{{ $products->links() }}</div>
    </section>
@endsection
