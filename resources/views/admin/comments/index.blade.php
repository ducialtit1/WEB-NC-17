
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bình luận - Admin Food Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/css/admin/comments.css" rel="stylesheet">
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
                        <a class="nav-link" href="/admin"><i class="bi bi-speedometer2"></i> Bảng điều khiển</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/products"><i class="bi bi-box-seam"></i> Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/orders"><i class="bi bi-cart3"></i> Đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin/comments"><i class="bi bi-chat-dots"></i> Bình luận</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users"><i class="bi bi-people"></i> Người dùng</a>
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
                <div class="page-header d-flex justify-content-between align-items-center">
                    <h1 class="h2">Quản lý bình luận</h1>
                </div>
                
                <!-- Filter Section -->
                <div class="filter-card">
                    <form action="" method="get" class="row g-3">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Tất cả</option>
                                <option value="pending">Chờ duyệt</option>
                                <option value="approved">Đã duyệt</option>
                                <option value="rejected">Đã từ chối</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="product" class="form-label">Sản phẩm</label>
                            <select class="form-select" id="product" name="product_id">
                                <option value="">Tất cả sản phẩm</option>
                                <!-- Lặp qua danh sách sản phẩm nếu có -->
                                @if(isset($products))
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="search" class="form-label">Tìm kiếm</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Tìm theo nội dung, tên người dùng...">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-filter"></i> Lọc
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase fw-bold">Chờ duyệt</h6>
                                        <h2 class="mb-0">{{ $pendingCount ?? 5 }}</h2>
                                    </div>
                                    <i class="bi bi-hourglass-split" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase fw-bold">Đã duyệt</h6>
                                        <h2 class="mb-0">{{ $approvedCount ?? 18 }}</h2>
                                    </div>
                                    <i class="bi bi-check-circle" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-danger">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase fw-bold">Đã từ chối</h6>
                                        <h2 class="mb-0">{{ $rejectedCount ?? 3 }}</h2>
                                    </div>
                                    <i class="bi bi-x-circle" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Comments List -->
                <div class="comments-container">
                    @if(!isset($comments) || (isset($comments) && $comments->isEmpty()))
                        <div class="alert alert-info">Không có bình luận nào.</div>
                    @else
                        @foreach($comments ?? [] as $index => $comment)
                            <div class="comment-card">
                                <div class="comment-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="https://via.placeholder.com/40" alt="User" class="rounded-circle me-2">
                                        <div>
                                            <h6 class="mb-0">{{ $comment->user_name ?? 'Người dùng '.($index+1) }}</h6>
                                            <small class="comment-info">
                                                {{ $comment->created_at ?? '15/10/2025 14:30' }}
                                            </small>
                                        </div>
                                    </div>
                                    <div>
                                        @if(($comment->is_approved ?? ($index % 3 == 0)) === true)
                                            <span class="badge badge-approved">Đã duyệt</span>
                                        @elseif(($comment->is_rejected ?? ($index % 3 == 2)) === true)
                                            <span class="badge badge-rejected">Đã từ chối</span>
                                        @else
                                            <span class="badge badge-pending">Chờ duyệt</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="comment-content">
                                    <p class="mb-0">{{ $comment->content ?? 'Bình luận mẫu số '.($index+1).'. Nội dung bình luận sẽ hiển thị ở đây. Đây là một bình luận từ người dùng về sản phẩm.' }}</p>
                                </div>
                                <div class="comment-footer d-flex justify-content-between">
                                    <div>
                                        <span class="comment-info">
                                            Sản phẩm: <a href="#" class="product-link">{{ $comment->product_name ?? 'Sản phẩm '.($index+1) }}</a>
                                        </span>
                                    </div>
                                    <div class="comment-actions">
                                        @if(($comment->is_approved ?? ($index % 3 == 0)) !== true && ($comment->is_rejected ?? ($index % 3 == 2)) !== true)
                                            <form action="{{ route('admin.comments.approve', $comment->id ?? 1) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-check"></i> Duyệt
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.comments.destroy', $comment->id ?? 1) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Dummy Comments for display -->
                        @if(!isset($comments))
                            @for($i = 0; $i < 5; $i++)
                                <div class="comment-card">
                                    <div class="comment-header d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/40" alt="User" class="rounded-circle me-2">
                                            <div>
                                                <h6 class="mb-0">Nguyễn Văn A</h6>
                                                <small class="comment-info">
                                                    15/10/2025 14:30
                                                </small>
                                            </div>
                                        </div>
                                        <div>
                                            @if($i % 3 == 0)
                                                <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                            @elseif($i % 3 == 1)
                                                <span class="badge bg-success">Đã duyệt</span>
                                            @else
                                                <span class="badge bg-danger">Đã từ chối</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <p class="mb-0">Bình luận mẫu số {{ $i+1 }}. Nội dung bình luận sẽ hiển thị ở đây. Đây là một bình luận từ người dùng về sản phẩm.</p>
                                    </div>
                                    <div class="comment-footer d-flex justify-content-between">
                                        <div>
                                            <span class="comment-info">
                                                Sản phẩm: <a href="#" class="product-link">Bánh Mì Gà Teriyaki</a>
                                            </span>
                                        </div>
                                        <div class="comment-actions">
                                            @if($i % 3 == 0)
                                                <button class="btn btn-sm btn-success">
                                                    <i class="bi bi-check"></i> Duyệt
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="bi bi-x"></i> Từ chối
                                                </button>
                                            @endif
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endif
                    @endif
                </div>
                
                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Trước</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Tiếp</a>
                        </li>
                    </ul>
                </nav>
                
                <!-- Footer -->
                <footer class="mt-auto">
                    <div class="text-center py-3">
                        <p>&copy; 2025 Food Store Admin. All rights reserved.</p>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
            if (urlParams.has('product_id')) {
                document.getElementById('product').value = urlParams.get('product_id');
            }
            if (urlParams.has('search')) {
                document.getElementById('search').value = urlParams.get('search');
            }
        });
    </script>
</body>
</html>