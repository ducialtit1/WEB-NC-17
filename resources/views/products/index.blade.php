<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Store - Thực phẩm tươi ngon, giao hàng tận nơi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/homepage.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.header')
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background">
            <div class="hero-overlay"></div>
            <div class="container">
                <div class="row align-items-center min-vh-75">
                    <div class="col-lg-6">
                        <div class="hero-content">
                            <h1 class="hero-title">
                                Thực phẩm tươi ngon
                                <span class="text-primary">giao tận nơi</span>
                            </h1>
                            <p class="hero-subtitle">
                                Khám phá thế giới ẩm thực đa dạng với những món ăn và đồ uống chất lượng cao, 
                                được chế biến từ nguyên liệu tươi ngon nhất.
                            </p>
                            <div class="hero-buttons">
                                <a href="#featured-products" class="btn btn-primary btn-lg hero-btn">
                                    <i class="bi bi-basket2-fill me-2"></i>Khám phá ngay
                                </a>
                                <a href="#foods-list" class="btn btn-outline-primary btn-lg hero-btn">
                                    <i class="bi bi-arrow-down me-2"></i>Xem sản phẩm
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-image">
                            <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Delicious Food" class="img-fluid rounded-4 shadow-lg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h5>Giao hàng nhanh</h5>
                        <p>Giao hàng trong vòng 30 phút trong khu vực nội thành</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5>Chất lượng đảm bảo</h5>
                        <p>Tất cả sản phẩm đều được kiểm tra chất lượng nghiêm ngặt</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h5>Hỗ trợ 24/7</h5>
                        <p>Đội ngũ chăm sóc khách hàng luôn sẵn sàng hỗ trợ bạn</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="featured-products" class="featured-section py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title">Sản phẩm nổi bật</h2>
                <p class="section-subtitle">Những món ăn và đồ uống được yêu thích nhất</p>
                <div class="section-divider"></div>
            </div>
            
            <!-- Featured Foods -->
            <div class="row mb-5">
                <div class="col-12">
                    <h3 class="category-title">
                        <i class="bi bi-cup-hot me-2"></i>Đồ ăn ngon
                    </h3>
                </div>
            </div>
            <div class="row g-4 mb-5">
                @foreach($foods->take(6) as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="product-card-modern">
                        <div class="product-image-wrapper">
                            @if($product->mainImage && $product->mainImage->path)
                                <img src="{{ asset('imgs/' . $product->mainImage->path) }}"
                                     alt="{{ $product->name }}" class="product-image">
                            @else
                                <img src="{{ asset('imgs/default.jpg') }}"
                                     alt="{{ $product->name }}" class="product-image">
                            @endif
                            <div class="product-overlay">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye me-1"></i>Xem chi tiết
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-name">{{ $product->name }}</h5>
                            <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                            <div class="product-footer">
                                <span class="product-price">{{ number_format($product->price) }}đ</span>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Featured Drinks -->
            <div class="row mb-4">
                <div class="col-12">
                    <h3 class="category-title">
                        <i class="bi bi-cup-straw me-2"></i>Đồ uống tươi mát
                    </h3>
                </div>
            </div>
            <div class="row g-4">
                @foreach($drinks->take(6) as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="product-card-modern">
                        <div class="product-image-wrapper">
                            @if($product->mainImage && $product->mainImage->path)
                                <img src="{{ asset('imgs/' . $product->mainImage->path) }}"
                                     alt="{{ $product->name }}" class="product-image">
                            @else
                                <img src="{{ asset('imgs/default.jpg') }}"
                                     alt="{{ $product->name }}" class="product-image">
                            @endif
                            <div class="product-overlay">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye me-1"></i>Xem chi tiết
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-name">{{ $product->name }}</h5>
                            <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                            <div class="product-footer">
                                <span class="product-price">{{ number_format($product->price) }}đ</span>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- All Products Section -->
    <section class="all-products-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title">Tất cả sản phẩm</h2>
                <p class="section-subtitle">Khám phá toàn bộ thực đơn của chúng tôi</p>
                <div class="section-divider"></div>
            </div>

            <!-- Foods Section -->
            <div id="foods-list" class="mb-5">
                <h3 class="category-title-full">
                    <i class="bi bi-cup-hot me-2"></i>Đồ ăn
                </h3>
                @include('products.partials._foods', ['foods' => $foods])
            </div>

            <!-- Drinks Section -->
            <div id="drinks-list">
                <h3 class="category-title-full">
                    <i class="bi bi-cup-straw me-2"></i>Đồ uống
                </h3>
                @include('products.partials._drinks', ['drinks' => $drinks])
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-content">
                        <h2 class="about-title">Về Food Store</h2>
                        <p class="about-text">
                            Food Store là điểm đến tin cậy cho những ai yêu thích ẩm thực chất lượng. 
                            Chúng tôi cam kết mang đến cho bạn những sản phẩm tươi ngon nhất với 
                            dịch vụ giao hàng nhanh chóng và chuyên nghiệp.
                        </p>
                        <p class="about-text">
                            Với đa dạng các món ăn và đồ uống từ truyền thống đến hiện đại, 
                            chúng tôi luôn nỗ lực để đáp ứng mọi nhu cầu ẩm thực của khách hàng.
                        </p>
                        <div class="about-stats">
                            <div class="stat-item">
                                <h4>1000+</h4>
                                <span>Khách hàng hài lòng</span>
                            </div>
                            <div class="stat-item">
                                <h4>50+</h4>
                                <span>Món ăn đa dạng</span>
                            </div>
                            <div class="stat-item">
                                <h4>5⭐</h4>
                                <span>Đánh giá trung bình</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Restaurant Kitchen" class="img-fluid rounded-4 shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact-section" class="contact-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="contact-title">Liên hệ với chúng tôi</h2>
                    <p class="contact-subtitle">
                        Có câu hỏi hoặc cần hỗ trợ? Chúng tôi luôn sẵn sàng giúp đỡ bạn!
                    </p>
                    <div class="contact-info">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="contact-item">
                                    <i class="bi bi-telephone-fill"></i>
                                    <h5>Điện thoại</h5>
                                    <p>0123 456 789</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="contact-item">
                                    <i class="bi bi-envelope-fill"></i>
                                    <h5>Email</h5>
                                    <p>info@foodstore.com</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="contact-item">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <h5>Địa chỉ</h5>
                                    <p>123 Đường ABC, Quận 1, TP.HCM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // AJAX pagination for foods
        $(document).on('click', '#foods-list .pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            if (!url.includes('/foods')) {
                var page = url.split('page=')[1];
                url = '/foods?page=' + page;
            }
            $.ajax({
                url: url,
                type: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(data) {
                    $('#foods-list').html('<h3 class="category-title-full"><i class="bi bi-cup-hot me-2"></i>Đồ ăn</h3>' + data);
                }
            });
        });

        // AJAX pagination for drinks
        $(document).on('click', '#drinks-list .pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            if (!url.includes('/drinks')) {
                var page = url.split('page=')[1];
                url = '/drinks?page=' + page;
            }
            $.ajax({
                url: url,
                type: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(data) {
                    $('#drinks-list').html('<h3 class="category-title-full"><i class="bi bi-cup-straw me-2"></i>Đồ uống</h3>' + data);
                }
            });
        });

        // Add animation on scroll
        window.addEventListener('scroll', function() {
            const elements = document.querySelectorAll('.product-card-modern, .feature-card');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('animate-in');
                }
            });
        });
    </script>

    @include('layouts.footer')
</body>
</html>