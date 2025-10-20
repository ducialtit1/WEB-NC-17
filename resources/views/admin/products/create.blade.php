@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">➕ Thêm sản phẩm mới</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label>Giá</label>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}">
        </div>

        <div class="mb-3">
            <label>Loại</label>
            <select name="type" class="form-select">
                <option value="food">Đồ ăn</option>
                <option value="drink">Đồ uống</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Kích cỡ</label>
            <input type="text" name="size" class="form-control" value="{{ old('size') }}">
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Ảnh chính</label>
            <input type="file" name="main_image" class="form-control">
        </div>

        <button class="btn btn-success">💾 Lưu sản phẩm</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">⬅️ Quay lại</a>
    </form>
</div>
@endsection
