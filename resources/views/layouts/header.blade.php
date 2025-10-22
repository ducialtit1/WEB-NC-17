<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-0 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold fs-3" href="{{ url('/') }}">
      <i class="bi bi-shop me-2"></i>Food Store
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link fw-500 {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
            <i class="bi bi-house me-1"></i>Trang chủ
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-500" href="{{ url('/#foods-list') }}">
            <i class="bi bi-cup-hot me-1"></i>Đồ ăn
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-500" href="{{ url('/#drinks-list') }}">
            <i class="bi bi-cup-straw me-1"></i>Đồ uống
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-500" href="#contact-section">
            <i class="bi bi-telephone me-1"></i>Liên hệ
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-500 position-relative" href="{{ route('cart.index') }}">
            <i class="bi bi-bag me-1"></i>Giỏ hàng
            @if(collect(session('cart', []))->sum('quantity') > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
              {{ collect(session('cart', []))->sum('quantity') }}
            </span>
            @endif
          </a>
        </li>
        @auth
        
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('my.orders') ? 'active' : '' }}" href="{{ route('my.orders') }}">
            <i class="bi bi-box"></i> Đơn hàng của tôi
          </a>
        </li>
        @endauth
        @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
        </li>
        @endguest
        @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-500" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item" type="submit">
                  <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                </button>
              </form>
            </li>
          </ul>
        </li>
        @endauth
        @auth
        @if(Auth::user()->is_admin)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Quản lý
            </a>
        </li>
        @endif
        @endauth
      </ul>
    </div>
  </div>
</nav>