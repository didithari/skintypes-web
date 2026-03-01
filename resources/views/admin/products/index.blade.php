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
                        <th>Nama</th>
                        <th>Brand</th>
                        <th>Skin Type</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->brand ?? '-' }}</td>
                            <td><span class="badge">{{ $product->skinType->name ?? '-' }}</span></td>
                            <td>{{ $product->description ?? '-' }}</td>
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
                            <td colspan="5" class="muted">Belum ada data product.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">{{ $products->links() }}</div>
    </section>
@endsection
