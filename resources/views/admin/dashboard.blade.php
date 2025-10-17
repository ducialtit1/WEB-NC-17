<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng điều khiển - Admin Food Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin/dashboard.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar d-md-block">
                <div class="text-center p-3">
                    <h5>Food Store Admin</h5>
                </div>
                <hr class="bg-secondary">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="bi bi-speedometer2"></i> Bảng điều khiển</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-box-seam"></i> Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/orders"><i class="bi bi-cart3"></i> Đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/comments"><i class="bi bi-chat-dots"></i> Bình luận</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-people"></i> Người dùng</a>
                    </li>
                </ul>
                <hr class="bg-secondary">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="bi bi-house"></i> Xem trang chính</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
                    </li>
                </ul>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ml-sm-auto px-md-4 py-4">
                <!-- Header -->
                <div class="dashboard-header d-flex justify-content-between align-items-center">
                    <h1 class="h2">Bảng điều khiển</h1>
                    <div>
                        <button class="btn btn-sm btn-outline-light">
                            <i class="bi bi-bell"></i> Thông báo
                        </button>
                        <button class="btn btn-sm btn-outline-light ms-2">
                            <i class="bi bi-gear"></i> Cài đặt
                        </button>
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="card stat-card bg-primary text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase fw-bold">Tổng sản phẩm</h6>
                                        <h2 class="mb-0">{{ $stats['products'] ?? '0' }}</h2>
                                    </div>
                                    <i class="bi bi-box-seam" style="font-size: 3rem;"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">Xem chi tiết</a>
                                <i class="bi bi-chevron-right text-white"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="card stat-card bg-success text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase fw-bold">Tổng đơn hàng</h6>
                                        <h2 class="mb-0">{{ $stats['orders'] ?? '0' }}</h2>
                                    </div>
                                    <i class="bi bi-cart3" style="font-size: 3rem;"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">Xem chi tiết</a>
                                <i class="bi bi-chevron-right text-white"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="card stat-card bg-warning h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase fw-bold text-dark">Đơn hàng chờ xử lý</h6>
                                        <h2 class="mb-0 text-dark">{{ $stats['pending_orders'] ?? '0' }}</h2>
                                    </div>
                                    <i class="bi bi-hourglass-split text-dark" style="font-size: 3rem;"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small stretched-link text-dark" href="#">Xem chi tiết</a>
                                <i class="bi bi-chevron-right text-dark"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <div class="card stat-card bg-info text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase fw-bold">Tổng người dùng</h6>
                                        <h2 class="mb-0">{{ $stats['users'] ?? '0' }}</h2>
                                    </div>
                                    <i class="bi bi-people" style="font-size: 3rem;"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">Xem chi tiết</a>
                                <i class="bi bi-chevron-right text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders & Revenue -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card table-container mb-4">
                            <div class="card-header d-flex justify-content-between">
                                <div>
                                    <i class="bi bi-cart3 me-1"></i>
                                    Đơn hàng gần đây
                                </div>
                                <div>
                                    <a href="#" class="btn btn-sm btn-primary">
                                        <i class="bi bi-plus-circle"></i> Thêm đơn hàng
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(!isset($recentOrders) || (isset($recentOrders) && $recentOrders->isEmpty()))
                                    <div class="alert alert-info">Không có đơn hàng nào gần đây.</div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Khách hàng</th>
                                                    <th>Trạng thái</th>
                                                    <th>Tổng tiền</th>
                                                    <th>Thời gian</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($recentOrders as $order)
                                                    <tr>
                                                        <td>#{{ $order->id }}</td>
                                                        <td>{{ $order->name }}</td>
                                                        <td>
                                                            @switch($order->status)
                                                                @case('pending')
                                                                    <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                                                    @break
                                                                @case('processing')
                                                                    <span class="badge bg-info">Đang xử lý</span>
                                                                    @break
                                                                @case('completed')
                                                                    <span class="badge bg-success">Hoàn thành</span>
                                                                    @break
                                                                @case('cancelled')
                                                                    <span class="badge bg-danger">Đã hủy</span>
                                                                    @break
                                                                @default
                                                                    <span class="badge bg-secondary">Không xác định</span>
                                                            @endswitch
                                                        </td>
                                                        <td>{{ number_format($order->total) }} VND</td>
                                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                        <td>
                                                            <a href="#" class="btn btn-sm btn-info">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer text-muted">
                                <a href="#" class="btn btn-sm btn-outline-primary">Xem tất cả đơn hàng</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="revenue-card mb-4">
                            <div class="text-center">
                                <i class="bi bi-graph-up" style="font-size: 3rem;"></i>
                                <h3 class="mt-3">Tổng doanh thu</h3>
                                <h1 class="display-4">{{ number_format($stats['revenue'] ?? 0) }} <small>VND</small></h1>
                                <p class="text-light">Từ các đơn hàng đã hoàn thành</p>
                                <hr class="bg-light">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="mb-1">Hôm nay</p>
                                        <h5>{{ number_format(($stats['revenue'] ?? 0) * 0.1) }} VND</h5>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-1">Tuần này</p>
                                        <h5>{{ number_format(($stats['revenue'] ?? 0) * 0.4) }} VND</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="bi bi-bell me-1"></i>
                                Thông báo gần đây
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-cart-check text-success me-2"></i>
                                            Đơn hàng mới vừa được tạo
                                            <small class="d-block text-muted">10 phút trước</small>
                                        </div>
                                        <span class="badge bg-success rounded-pill">Mới</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-chat-left-dots text-primary me-2"></i>
                                            Có bình luận mới cần duyệt
                                            <small class="d-block text-muted">30 phút trước</small>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">5</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-person-plus text-info me-2"></i>
                                            Người dùng mới đăng ký
                                            <small class="d-block text-muted">1 giờ trước</small>
                                        </div>
                                        <span class="badge bg-info rounded-pill">3</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer text-muted">
                                <a href="#" class="btn btn-sm btn-outline-secondary w-100">Xem tất cả thông báo</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activities & Quick Actions -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="bi bi-clock-history me-1"></i>
                                Hoạt động gần đây
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <span class="avatar bg-primary text-white p-2 rounded">
                                                    <i class="bi bi-person"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="mb-0"><strong>Admin</strong> đã cập nhật trạng thái đơn hàng #123</p>
                                                <small class="text-muted">5 phút trước</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <span class="avatar bg-success text-white p-2 rounded">
                                                    <i class="bi bi-box-seam"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="mb-0"><strong>Admin</strong> đã thêm sản phẩm mới "Bánh Mì Gà"</p>
                                                <small class="text-muted">30 phút trước</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <span class="avatar bg-danger text-white p-2 rounded">
                                                    <i class="bi bi-trash"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="mb-0"><strong>Admin</strong> đã xóa bình luận spam</p>
                                                <small class="text-muted">1 giờ trước</small>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="bi bi-lightning-charge me-1"></i>
                                Thao tác nhanh
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <a href="#" class="btn btn-primary w-100">
                                            <i class="bi bi-plus-circle me-1"></i> Thêm sản phẩm
                                        </a>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <a href="#" class="btn btn-success w-100">
                                            <i class="bi bi-cart-plus me-1"></i> Tạo đơn hàng
                                        </a>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <a href="#" class="btn btn-info w-100 text-white">
                                            <i class="bi bi-people me-1"></i> Quản lý người dùng
                                        </a>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <a href="#" class="btn btn-secondary w-100">
                                            <i class="bi bi-gear me-1"></i> Cài đặt hệ thống
                                        </a>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <a href="#" class="btn btn-outline-dark w-100">
                                        <i class="bi bi-file-earmark-text me-1"></i> Báo cáo tổng hợp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <footer class="mt-auto">
                    <div class="text-center">
                        <p>&copy; 2025 Food Store Admin. All rights reserved.</p>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>