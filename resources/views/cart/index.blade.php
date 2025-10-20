<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giỏ hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{asset('css/cart.css')}}" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  @include('layouts.header')

  <div class="container my-5">
    <h2><i class="fas fa-shopping-cart"></i> Giỏ hàng của bạn</h2>
    
    <!-- Thông báo -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('cart') && count(session('cart')) > 0)
        <div class="cart-items">
            @php $total = 0 @endphp
            @foreach(session('cart') as $id => $item)
                @php $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1) @endphp
                <div class="cart-item" data-id="{{ $id }}">
                    <div class="item-image">
                        @php
                            $imagePath = $item['image'] ?? 'default.jpg';
                        @endphp
                        <img src="{{ asset('imgs/' . $imagePath) }}" alt="{{ $item['name'] ?? 'Sản phẩm' }}" 
                             onerror="this.src='{{ asset('imgs/default.jpg') }}'">
                    </div>
                    <div class="item-details">
                        <h5>{{ $item['name'] ?? 'Sản phẩm' }}</h5>
                        <p>{{ number_format($item['price'] ?? 0) }} VND</p>
                    </div>
                    <div class="item-quantity">
                        <button type="button" class="quantity-btn minus" data-id="{{ $id }}" onclick="updateQuantity('{{ $id }}', -1)">
                            -
                        </button>
                        <span class="quantity">{{ $item['quantity'] ?? 1 }}</span>
                        <button type="button" class="quantity-btn plus" data-id="{{ $id }}" onclick="updateQuantity('{{ $id }}', 1)">
                            +
                        </button>
                    </div>
                    <div class="item-total">
                        {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1)) }} VND
                    </div>
                    <div class="item-remove">
                        <button type="button" class="remove-btn" data-id="{{ $id }}" onclick="removeFromCart('{{ $id }}')">
                            Xóa
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="cart-summary">
            <div class="summary-details">
                <div class="summary-row">
                    <span>Tạm tính:</span>
                    <span id="subtotal">{{ number_format($total) }} VND</span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển:</span>
                    <span>Miễn phí</span>
                </div>
                <hr>
                <div class="summary-row total-row">
                    <span><strong>Tổng cộng:</strong></span>
                    <span><strong id="cart-total">{{ number_format($total) }} VND</strong></span>
                </div>
            </div>
            
            <div class="cart-actions">
                <div class="d-flex gap-3">
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                    </a>
                    <button type="button" class="btn btn-outline-danger" onclick="clearCart()">
                        <i class="fas fa-trash"></i> Xóa toàn bộ
                    </button>
                </div>
                <div class="checkout-section">
                    <button type="button" class="btn btn-success btn-lg checkout-btn" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                        <i class="fas fa-credit-card"></i> Tiến hành thanh toán
                    </button>
                    <p class="checkout-note">Đảm bảo thông tin giao hàng chính xác</p>
                </div>
                <!-- Checkout Modal -->
                <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header" style="background: linear-gradient(45deg, #28a745, #20c997); color: white;">
                        <h5 class="modal-title" id="checkoutModalLabel">
                          <i class="fas fa-shopping-bag"></i> Thanh toán đơn hàng
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form id="checkoutForm" class="checkout-form" method="POST" action="/checkout">
                        @csrf
                        <div class="modal-body" style="max-height: 90vh; overflow-y: auto; padding-bottom: 30px;">
                          <div class="row">
                            <div class="col-md-6">
                              <h6 class="mb-3"><i class="fas fa-user"></i> Thông tin khách hàng</h6>
                              <div class="mb-3">
                                <label for="name" class="form-label">Họ và tên *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                              </div>
                              <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                              </div>
                              <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <h6 class="mb-3"><i class="fas fa-map-marker-alt"></i> Địa chỉ giao hàng</h6>
                              <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ chi tiết *</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                              </div>
                              <div class="mb-3">
                                <label for="notes" class="form-label">Ghi chú</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Ghi chú thêm cho đơn hàng..."></textarea>
                              </div>
                            </div>
                          </div>
                          <hr>
                          <h6 class="mb-3"><i class="fas fa-credit-card"></i> Phương thức thanh toán</h6>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="payment-method" onclick="selectPaymentMethod('cod')" style="border: 2px solid #dee2e6; border-radius: 10px; padding: 15px; text-align: center; cursor: pointer; margin-bottom: 10px;">
                                <input type="radio" name="payment_method" value="cod" id="cod" checked style="display: none;">
                                <i class="fas fa-money-bill-wave fa-2x mb-2 text-success"></i>
                                <div><strong>Thanh toán khi nhận hàng</strong></div>
                                <small class="text-muted">COD</small>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="payment-method" onclick="selectPaymentMethod('bank_transfer')" style="border: 2px solid #dee2e6; border-radius: 10px; padding: 15px; text-align: center; cursor: pointer; margin-bottom: 10px;">
                                <input type="radio" name="payment_method" value="bank_transfer" id="bank_transfer" style="display: none;">
                                <i class="fas fa-university fa-2x mb-2 text-primary"></i>
                                <div><strong>Chuyển khoản ngân hàng</strong></div>
                                <small class="text-muted">ATM/Internet Banking</small>
                              </div>
                            </div>
                          </div>
                          <hr>
                          <div class="order-summary">
                            <h6><i class="fas fa-receipt"></i> Tóm tắt đơn hàng</h6>
                            <div class="d-flex justify-content-between">
                              <span>Tạm tính:</span>
                              <span>{{ number_format($total ?? 0) }} VND</span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <span>Phí vận chuyển:</span>
                              <span>Miễn phí</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5 text-danger">
                              <span>Tổng cộng:</span>
                              <span>{{ number_format($total ?? 0) }} VND</span>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer" style="margin-top: 20px;">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                          <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check"></i> Xác nhận đặt hàng
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    @else
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-cart fa-5x text-muted"></i>
            </div>
            <h4>Giỏ hàng của bạn đang trống</h4>
            <p>Hãy thêm một số sản phẩm vào giỏ hàng!</p>
            <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag"></i> Tiếp tục mua sắm
            </a>
        </div>
    @endif
  </div>

  @include('layouts.footer')

  <!-- Checkout Modal -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
function updateQuantity(id, change) {
    const button = event.target;
    const originalContent = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    
    fetch(`/cart/update/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ change: change })
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Update response:', data);
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Có lỗi xảy ra khi cập nhật giỏ hàng');
            button.disabled = false;
            button.innerHTML = originalContent;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi cập nhật giỏ hàng: ' + error.message);
        button.disabled = false;
        button.innerHTML = originalContent;
    });
}

function removeFromCart(id) {
    if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
        const button = event.target;
        const originalContent = button.innerHTML;
        
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        fetch(`/cart/remove/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Remove response:', data);
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Có lỗi xảy ra khi xóa sản phẩm');
                button.disabled = false;
                button.innerHTML = originalContent;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa sản phẩm: ' + error.message);
            button.disabled = false;
            button.innerHTML = originalContent;
        });
    }
}

function clearCart() {
    if (confirm('Bạn có chắc muốn xóa toàn bộ sản phẩm trong giỏ hàng?')) {
        fetch('/cart/clear', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Clear cart response:', data);
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Có lỗi xảy ra khi xóa giỏ hàng');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa giỏ hàng: ' + error.message);
        });
    }
}

// Auto dismiss alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (bootstrap.Alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
});

function selectPaymentMethod(method) {
    document.querySelectorAll('.payment-method').forEach(el => {
        el.style.borderColor = '#dee2e6';
        el.style.backgroundColor = 'white';
    });
    
    event.currentTarget.style.borderColor = '#28a745';
    event.currentTarget.style.backgroundColor = '#f8fff9';
    
    document.getElementById(method).checked = true;
}


function getPaymentMethodText(method) {
    switch(method) {
        case 'cod': return 'Thanh toán khi nhận hàng';
        case 'bank': return 'Chuyển khoản ngân hàng';
        case 'momo': return 'Ví MoMo';
        default: return 'Không xác định';
    }
}

// Initialize first payment method as selected
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        const firstPaymentMethod = document.querySelector('.payment-method');
        if (firstPaymentMethod) {
            firstPaymentMethod.style.borderColor = '#28a745';
            firstPaymentMethod.style.backgroundColor = '#f8fff9';
        }
    }, 100);
});
  </script>
</body>
</html>