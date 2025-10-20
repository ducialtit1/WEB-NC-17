<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Food Store</title>
    
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/admin/layouts.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md admin-navbar">
        <div class="container-fluid">
            <!-- Sidebar Toggle -->
            <button id="sidebarToggle" class="btn btn-link d-md-none me-2">
                <i class="bi bi-list text-white"></i>
            </button>
            
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Food Store Admin</a>
            
            <!-- Navbar Right -->
            <ul class="navbar-nav ms-auto">
                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                        <li><h6 class="dropdown-header">Thông báo</h6></li>
                        <li><a class="dropdown-item" href="#">Đơn hàng mới #123</a></li>
                        <li><a class="dropdown-item" href="#">5 bình luận mới cần duyệt</a></li>
                        <li><a class="dropdown-item" href="#">Người dùng mới đăng ký</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Xem tất cả thông báo</a></li>
                    </ul>
                </li>
                
                <!-- User Info -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ Auth::user()->name ?? 'Admin' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Hồ sơ</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Cài đặt</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    
    <!-- Sidebar -->
    <div class="sidebar" style="width: 250px;">
        <div class="position-sticky">
            <ul class="nav flex-column p-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        <i class="bi bi-box-seam"></i>
                        Sản phẩm
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-cart3"></i>
                        Đơn hàng
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.comments*') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                        <i class="bi bi-chat-dots"></i>
                        Bình luận
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="bi bi-people"></i>
                        Người dùng
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-divider"></div>
            
            <ul class="nav flex-column p-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}" target="_blank">
                        <i class="bi bi-house"></i>
                        Xem trang chính
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear"></i>
                        Cài đặt
                    </a>
                </li>
                
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link text-start w-100 bg-transparent border-0">
                            <i class="bi bi-box-arrow-right"></i>
                            Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @yield('content')
        
        <footer>
            <div class="container">
                <p>&copy; {{ date('Y') }} Food Store Admin. All rights reserved.</p>
            </div>
        </footer>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
        
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            if (window.innerWidth < 768 && sidebar.classList.contains('show') && 
                !sidebar.contains(event.target) && event.target !== sidebarToggle) {
                sidebar.classList.remove('show');
            }
        });
        
        window.setTimeout(function() {
            $('.alert-dismissible').fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>
