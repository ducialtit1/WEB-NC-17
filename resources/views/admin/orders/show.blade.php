@extends('admin.layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">🧾 Chi tiết đơn hàng #{{ $order->id }}</h1>

    {{-- Thông tin khách hàng --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5>👤 Thông tin khách hàng</h5>
            <p><strong>Tên:</strong> {{ $order->name }}</p>
            <p><strong>SĐT:</strong> {{ $order->phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
            <p><strong>Ghi chú:</strong> {{ $order->notes ?? 'Không có' }}</p>
        </div>
    </div>

    {{-- Sản phẩm trong đơn --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5>🛍️ Sản phẩm trong đơn</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Size</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->size }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} ₫</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} ₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Thông tin đơn hàng --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5>📦 Thông tin đơn hàng</h5>
            <p><strong>Phương thức thanh toán:</strong> {{ ucfirst($order->payment_method) }}</p>
            <p><strong>Trạng thái hiện tại:</strong>
                @if($order->status == 'pending')
                    <span class="badge bg-warning text-dark">Chờ xử lý</span>
                @elseif($order->status == 'processing')
                    <span class="badge bg-primary">Đang giao hàng</span>
                @elseif($order->status == 'completed')
                    <span class="badge bg-success">Hoàn tất</span>
                @elseif($order->status == 'cancelled')
                    <span class="badge bg-danger">Đã hủy</span>
                @endif
            </p>
            <h4 class="text-end mt-3">Tổng cộng: <strong>{{ number_format($order->total, 0, ',', '.') }} ₫</strong></h4>
        </div>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        ← Quay lại danh sách
    </a>
</div>
@endsection
