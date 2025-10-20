@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">✏️ Chỉnh sửa sản phẩm</h2>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
        </div>

        <div class="mb-3">
            <label>Giá</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}">
        </div>

        <div class="mb-3">
            <label>Loại</label>
            <select name="type" class="form-select">
                <option value="food" {{ $product->type === 'food' ? 'selected' : '' }}>Đồ ăn</option>
                <option value="drink" {{ $product->type === 'drink' ? 'selected' : '' }}>Đồ uống</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Kích cỡ</label>
            <input type="text" name="size" class="form-control" value="{{ old('size', $product->size) }}">
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Ảnh chính hiện tại</label><br>
            @if ($product->mainImage)
                <img src="{{ asset('storage/' . $product->mainImage->path) }}" width="120" class="mb-2"><br>
            @else
                <span class="text-muted">Không có ảnh</span><br>
            @endif
            <input type="file" name="main_image" class="form-control mt-2">
        </div>

        <button class="btn btn-success">💾 Lưu thay đổi</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">⬅️ Quay lại</a>
    </form>
</div>
@endsection
