@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="mt-4 mb-4 fw-bold">Bảng điều khiển</h3>

    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="text-muted">TỔNG SẢN PHẨM</h5>
                    <h3>{{ $totalProducts }}</h3>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary mt-2">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="text-muted">TỔNG ĐƠN HÀNG</h5>
                    <h3>{{ $totalOrders }}</h3>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-success mt-2">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="text-muted">ĐƠN HÀNG CHỜ XỬ LÝ</h5>
                    <h3>{{ $pendingOrders }}</h3>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-warning mt-2">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="text-muted">TỔNG NGƯỜI DÙNG</h5>
                    <h3>{{ $totalUsers }}</h3>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-info mt-2">Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Đơn hàng gần đây --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="text-muted mb-3">Đơn hàng gần đây</h5>
                    @if ($recentOrders->isEmpty())
                        <p>Không có đơn hàng nào gần đây.</p>
                    @else
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Mã</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->user->name ?? 'Không xác định' }}</td>
                                        <td>{{ number_format($order->total) }} VND</td>
                                        <td>
                                            @php
                                                [$label, $class] = $order->status_label;
                                            @endphp
                                            <span class="badge {{ $class }}">{{ $label }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- Doanh thu --}}
        <div class="col-md-6">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="text-muted mb-3">Tổng doanh thu</h5>
                    <h3 class="text-success">{{ number_format($totalRevenue) }} VND</h3>
                    <p class="mb-1">Hôm nay: <strong>{{ number_format($todayRevenue) }} VND</strong></p>
                    <p>Tuần này: <strong>{{ number_format($weekRevenue) }} VND</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
