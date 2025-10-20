@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📦 Quản lý sản phẩm</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">➕ Thêm sản phẩm</a>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Loại</th>
                <th>Giá</th>
                <th>Kích cỡ</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($product->mainImage)
                            <img src="{{ asset('imgs/' . $product->mainImage->path) }}" width="80" alt="" class="img-thumbnail">
                        @else
                            <span class="text-muted">Không có</span>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->type === 'food' ? 'Đồ ăn' : 'Đồ uống' }}</td>
                    <td>{{ number_format($product->price) }}₫</td>
                    <td>{{ $product->size }}</td>
                    <td>{{ Str::limit($product->description, 40) }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">✏️ Sửa</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Xóa sản phẩm này?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">🗑️ Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted">Chưa có sản phẩm nào</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
</div>
@endsection
