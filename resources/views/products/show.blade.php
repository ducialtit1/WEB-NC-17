
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Chi tiết sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/comment.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.header')
    
    <div class="main-content">
        <div class="container my-5">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary mb-4">Quay lại</a>
            
            <div class="product-card mb-5">
                <div class="product-layout">
                    <!-- Ảnh bên trái -->
                    <div class="product-image">
                        @php
                            $imgPath = optional($product->mainImage)->path 
                                ?? optional($product->images->first())->path 
                                ?? 'default.jpg';
                        @endphp
                        <img src="{{ asset('imgs/' . $imgPath) }}" alt="{{ $product->name }}" class="product-img">
                    </div>
                    
                    <!-- Thông tin bên phải -->
                    <div class="product-details">
                        <h1>{{ $product->name }}</h1>
                        <p>{{ $product->description }}</p>
                        
                        <div class="product-meta">
                            <p><span>Loại:</span> {{ $product->type === 'food' ? 'Đồ ăn' : 'Đồ uống' }}</p>
                            <p><span>Size:</span> {{ $product->size }}</p>
                        </div>
                        
                        <div class="product-price">
                            {{ number_format($product->price) }} VND
                        </div>
                        
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <div class="product-quantity">
                                <span>Số lượng:</span>
                                <div class="quantity-control">
                                    <button type="button" class="quantity-btn minus">-</button>
                                    <input type="text" name="quantity" value="1" readonly>
                                    <button type="button" class="quantity-btn plus">+</button>
                                </div>
                            </div>
                            
                            <div class="product-actions">
                                <button type="submit" class="add-to-cart-btn">Thêm vào giỏ</button>
                                <button type="submit" name="buy_now" value="1" class="buy-now-btn">Mua ngay</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Phần bình luận -->
            <div class="product-comments">
                <h3 class="comments-title">Bình luận ({{ isset($comments) ? $comments->count() : count($randomComments) }})</h3>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(isset($comments))
                    @foreach ($comments as $comment)
                    <div class="comment-item">
                        <div class="comment-avatar">
                            @if($comment->user)
                                <img src="https://i.pravatar.cc/50?u={{ $comment->user->id }}" alt="{{ $comment->user->name }}">
                            @else
                                <img src="https://i.pravatar.cc/50?u={{ $comment->id }}" alt="{{ $comment->guest_name }}">
                            @endif
                        </div>
                        <div class="comment-content">
                            <div class="comment-header">
                                <h5>{{ $comment->user->name ?? $comment->guest_name }}</h5>
                                <div class="comment-rating">
                                    @for ($i = 0; $i < $comment->rating; $i++)
                                        <span class="star">★</span>
                                    @endfor
                                    @for ($i = $comment->rating; $i < 5; $i++)
                                        <span class="star empty">☆</span>
                                    @endfor
                                </div>
                            </div>
                            <div class="comment-date">{{ $comment->created_at->format('d/m/Y') }}</div>
                            <p>{{ $comment->content }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    @foreach ($randomComments as $comment)
                    <div class="comment-item">
                        <div class="comment-avatar">
                            <img src="https://i.pravatar.cc/50?u={{ $comment['id'] }}" alt="Avatar">
                        </div>
                        <div class="comment-content">
                            <div class="comment-header">
                                <h5>{{ $comment['name'] }}</h5>
                                <div class="comment-rating">
                                    @for ($i = 0; $i < $comment['rating']; $i++)
                                        <span class="star">★</span>
                                    @endfor
                                    @for ($i = $comment['rating']; $i < 5; $i++)
                                        <span class="star empty">☆</span>
                                    @endfor
                                </div>
                            </div>
                            <div class="comment-date">{{ $comment['date'] }}</div>
                            <p>{{ $comment['content'] }}</p>
                        </div>
                    </div>
                    @endforeach
                @endif
                
                <!-- Form bình luận mới -->
                <div class="comment-form">
                    <h4>Để lại bình luận</h4>
                    <form action="{{ route('comments.store', $product->id) }}" method="POST">
                        @csrf
                        @if(!Auth::check())
                        <div class="mb-3">
                            <label for="guest_name" class="form-label">Tên của bạn:</label>
                            <input type="text" class="form-control" name="guest_name" id="guest_name" required>
                        </div>
                        @endif
                        <div class="mb-3">
                            <label for="rating" class="form-label">Đánh giá:</label>
                            <div class="rating-select">
                                <div class="stars">
                                    <span class="star" data-value="1">☆</span>
                                    <span class="star" data-value="2">☆</span>
                                    <span class="star" data-value="3">☆</span>
                                    <span class="star" data-value="4">☆</span>
                                    <span class="star" data-value="5">☆</span>
                                </div>
                                <input type="hidden" name="rating" id="rating" value="5">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Nội dung:</label>
                            <textarea class="form-control" name="content" id="comment" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.footer')
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script điều khiển số lượng
        const minusBtn = document.querySelector('.quantity-btn.minus');
        const plusBtn = document.querySelector('.quantity-btn.plus');
        const quantityInput = document.querySelector('input[name="quantity"]');
        
        minusBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
        
        plusBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });
        
        // Script đánh giá sao
        const stars = document.querySelectorAll('.rating-select .star');
        const ratingInput = document.getElementById('rating');
        
        stars.forEach(star => {
            star.addEventListener('mouseover', function() {
                const value = this.dataset.value;
                highlightStars(stars, value);
            });
            
            star.addEventListener('mouseout', function() {
                const currentRating = ratingInput.value;
                highlightStars(stars, currentRating);
            });
            
            star.addEventListener('click', function() {
                const value = this.dataset.value;
                ratingInput.value = value;
                highlightStars(stars, value);
            });
        });
        
        function highlightStars(stars, value) {
            stars.forEach(star => {
                if (star.dataset.value <= value) {
                    star.textContent = '★';
                    star.classList.add('selected');
                } else {
                    star.textContent = '☆';
                    star.classList.remove('selected');
                }
            });
        }
    });
    </script>
</body>
</html>