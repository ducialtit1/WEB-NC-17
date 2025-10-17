@extends('admin.layouts.admin')

@section('title', 'Quản lý đơn hàng')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/orders.css') }}">
@endpush

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="h2">Quản lý đơn hàng</h1>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Dashboard
            </a>
            <a href="#" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Tạo đơn hàng
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <form action="{{ route('admin.orders') }}" method="get" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Tất cả</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đang giao hàng</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date" class="form-label">Ngày đặt hàng</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ request('date') }}">
            </div>
            <div class="col-md-4">
                <label for="search" class="form-label">Tìm kiếm</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="ID, email, tên khách hàng..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter"></i> Lọc
                </button>
            </div>
        </form>
    </div>

    <!-- Stats -->
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card stats-card bg-warning text-dark h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold">Chờ xử lý</h6>
                            <h2 class="mb-0">{{ $pendingCount ?? 5 }}</h2>
                        </div>
                        <i class="bi bi-hourglass-split stats-icon"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card stats-card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold">Đang xử lý</h6>
                            <h2 class="mb-0">{{ $processingCount ?? 3 }}</h2>
                        </div>
                        <i class="bi bi-box stats-icon"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card stats-card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold">Đã hoàn thành</h6>
                            <h2 class="mb-0">{{ $deliveredCount ?? 12 }}</h2>
                        </div>
                        <i class="bi bi-check-circle stats-icon"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card stats-card bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold">Đã hủy</h6>
                            <h2 class="mb-0">{{ $cancelledCount ?? 2 }}</h2>
                        </div>
                        <i class="bi bi-x-circle stats-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Danh sách đơn hàng</h5>
            <div>
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-download"></i> Xuất Excel
                </button>
                <button class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="bi bi-printer"></i> In
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            @if(!isset($orders) || (isset($orders) && $orders->isEmpty()))
                <div class="text-center p-5">
                    <div class="empty-state">
                        <i class="bi bi-cart-x" style="font-size: 3rem; color: #ccc;"></i>
                        <h3 class="mt-3">Không tìm thấy đơn hàng nào</h3>
                        <p class="text-muted">Hãy thay đổi bộ lọc hoặc quay lại sau</p>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover orders-table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th class="actions-column">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders ?? [] as $index => $order)
                                <tr class="{{ $index === 0 ? 'new-order' : '' }}">
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id ?? 1) }}" class="order-id">
                                            #{{ $order->id ?? $index + 1 }}
                                        </a>
                                    </td>
                                    <td>
                                        <div>{{ $order->customer_name ?? 'Nguyễn Văn A' }}</div>
                                        <div class="order-summary">{{ $order->email ?? 'example@email.com' }}</div>
                                        <div class="order-summary">{{ $order->phone ?? '0123456789' }}</div>
                                    </td>
                                    <td class="date-column">
                                        <div>{{ $order->created_at ?? now()->subDays(rand(0, 7))->format('d/m/Y') }}</div>
                                        <div class="order-summary">{{ $order->created_at ?? now()->subDays(rand(0, 7))->format('H:i') }}</div>
                                    </td>
                                    <td class="price-column">
                                        {{ number_format($order->total ?? rand(100000, 2000000)) }}đ
                                    </td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'status-pending',
                                                'processing' => 'status-processing',
                                                'shipped' => 'status-shipped',
                                                'delivered' => 'status-delivered',
                                                'cancelled' => 'status-cancelled',
                                            ];
                                            $statusNames = [
                                                'pending' => 'Chờ xử lý',
                                                'processing' => 'Đang xử lý',
                                                'shipped' => 'Đang giao',
                                                'delivered' => 'Đã giao',
                                                'cancelled' => 'Đã hủy',
                                            ];
                                            $status = $order->status ?? array_keys($statusClasses)[$index % count($statusClasses)];
                                        @endphp
                                        <span class="badge status-badge {{ $statusClasses[$status] }}">
                                            {{ $statusNames[$status] }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(($order->is_paid ?? ($index % 2 == 0)))
                                            <span class="badge bg-success">Đã thanh toán</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.orders.confirm', $order->id ?? 1) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success" {{ ($order->status ?? 'pending') !== 'pending' ? 'disabled' : '' }}>
                                                <i class="bi bi-check-circle me-1"></i> Xác nhận
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            
                            <!-- Mẫu dữ liệu khi không có $orders -->
                            @if(!isset($orders))
                                @for($i = 0; $i < 10; $i++)
                                    <tr class="{{ $i === 0 ? 'new-order' : '' }}">
                                        <td>
                                            <a href="#" class="order-id">
                                                #{{ 1000 + $i }}
                                            </a>
                                        </td>
                                        <td>
                                            <div>Khách hàng {{ $i + 1 }}</div>
                                            <div class="order-summary">customer{{ $i + 1 }}@example.com</div>
                                            <div class="order-summary">0123456{{ 100 + $i }}</div>
                                        </td>
                                        <td class="date-column">
                                            <div>{{ now()->subDays($i)->format('d/m/Y') }}</div>
                                            <div class="order-summary">{{ now()->subDays($i)->format('H:i') }}</div>
                                        </td>
                                        <td class="price-column">
                                            {{ number_format(rand(100000, 2000000)) }}đ
                                        </td>
                                        <td>
                                            @php
                                                $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
                                                $status = $statuses[$i % count($statuses)];
                                                $statusClass = "status-" . $status;
                                                $statusName = [
                                                    'pending' => 'Chờ xử lý',
                                                    'processing' => 'Đang xử lý',
                                                    'shipped' => 'Đang giao',
                                                    'delivered' => 'Đã giao',
                                                    'cancelled' => 'Đã hủy',
                                                ][$status];
                                            @endphp
                                            <span class="badge status-badge {{ $statusClass }}">
                                                {{ $statusName }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($i % 2 == 0)
                                                <span class="badge bg-success">Đã thanh toán</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="actionMenu{{ 1000 + $i }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Thao tác
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionMenu{{ 1000 + $i }}">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="bi bi-eye me-2"></i>Xem chi tiết
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="bi bi-pencil me-2"></i>Cập nhật
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="bi bi-receipt me-2"></i>In hóa đơn
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" onclick="confirmDelete({{ 1000 + $i }})">
                                                            <i class="bi bi-trash me-2"></i>Xóa
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
                            @endif
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="card-footer">
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Hiển thị {{ isset($orders) ? ($orders->firstItem() ?? 1) : 1 }} - {{ isset($orders) ? ($orders->lastItem() ?? 10) : 10 }} 
                    trong số {{ isset($orders) ? $orders->total() ?? 10 : 10 }} đơn hàng
                </div>
                @if(isset($orders))
                    {{ $orders->links() }}
                @else
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Sau</a></li>
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Kích hoạt tooltip
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Áp dụng các tham số lọc từ URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('status')) {
            document.getElementById('status').value = urlParams.get('status');
        }
        if (urlParams.has('date')) {
            document.getElementById('date').value = urlParams.get('date');
        }
        if (urlParams.has('search')) {
            document.getElementById('search').value = urlParams.get('search');
        }
    });
</script>
@endpush