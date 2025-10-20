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
                            <img src="{{ asset('imgs/' . basename($product->mainImage->path)) }}" width="80" alt="" class="img-thumbnail">
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

    @if ($products->lastPage() > 1)
        <nav aria-label="Phân trang sản phẩm">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $products->url(1) }}" aria-label="Trang đầu">
                        <i class="bi bi-chevron-double-left"></i>
                    </a>
                </li>
                <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $products->previousPageUrl() ?? '#' }}" aria-label="Trang trước">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>
                @for ($i = 1; $i <= $products->lastPage(); $i++)
                    <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $products->currentPage() == $products->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $products->nextPageUrl() ?? '#' }}" aria-label="Trang sau">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li class="page-item {{ $products->currentPage() == $products->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $products->url($products->lastPage()) }}" aria-label="Trang cuối">
                        <i class="bi bi-chevron-double-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    @endif
</div>
@endsection
