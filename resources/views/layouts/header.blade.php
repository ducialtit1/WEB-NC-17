<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">Food Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/#foods-list') }}">Đồ ăn</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/#drinks-list') }}">Đồ uống</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Liên hệ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('cart.index') }}">
            Giỏ hàng
            <span class="badge bg-light text-primary ms-1">
            {{ collect(session('cart', []))->sum('quantity') }}
            </span>
            </a>
        </li>
        @auth
        <!-- Nút đường dẫn tới thông tin đặt hàng cho người dùng đã đăng nhập -->
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
        <li class="nav-item">
          <span class="nav-link">{{ Auth::user()->name }}</span>
        </li>
        <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="nav-link btn btn-link" type="submit">Đăng xuất</button>
          </form>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>