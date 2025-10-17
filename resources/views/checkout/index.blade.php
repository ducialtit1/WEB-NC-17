<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - Food Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.header')
    
    <div class="main-content">
        <div class="container my-5">
            <h2 class="mb-4">Thanh toán</h2>
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <div class="row">
                <div class="col-md-7">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Thông tin giao hàng</h5>
                        </div>
                        <div class="card-body">
                            <form id="checkout-form" action="{{ route('checkout.place') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ tên người nhận *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ Auth::user()->name }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại *</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                        id="phone" name="phone" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ giao hàng *</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                        id="address" name="address" rows="3" required></textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Ghi chú</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label">Phương thức thanh toán *</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" 
                                            id="cod" value="cod" checked>
                                        <label class="form-check-label" for="cod">
                                            Thanh toán khi nhận hàng (COD)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" 
                                            id="bank_transfer" value="bank_transfer">
                                        <label class="form-check-label" for="bank_transfer">
                                            Chuyển khoản ngân hàng
                                        </label>
                                    </div>
                                    <div id="bank_info" class="mt-2 p-2 border rounded d-none">
                                        <p class="mb-1"><strong>Thông tin chuyển khoản:</strong></p>
                                        <p class="mb-1">Ngân hàng: BIDV</p>
                                        <p class="mb-1">Số tài khoản: 123456789</p>
                                        <p class="mb-0">Chủ tài khoản: FOOD STORE JSC</p>
                                    </div>
                                </div>
                                
                                <!-- NÚT ĐẶT HÀNG -->
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        XÁC NHẬN ĐẶT HÀNG
                                    </button>
                                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                        Quay lại giỏ hàng
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Đơn hàng của bạn</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th class="text-end">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cart as $item)
                                            <tr>
                                                <td>
                                                    {{ $item['name'] }}
                                                    @if(isset($item['size']))
                                                        <small class="text-muted d-block">Size: {{ $item['size'] }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td class="text-end">{{ number_format($item['price'] * $item['quantity']) }} VND</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Tổng cộng:</th>
                                            <th class="text-end">{{ number_format($total) }} VND</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- THÊM NÚT ĐẶT HÀNG PHÍA DƯỚI BẢNG ĐƠN HÀNG -->
                    <div class="d-grid gap-2 mt-3">
                        <button form="checkout-form" type="submit" class="btn btn-success btn-lg">
                            XÁC NHẬN ĐẶT HÀNG
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('layouts.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bankTransfer = document.getElementById('bank_transfer');
            const cod = document.getElementById('cod');
            const bankInfo = document.getElementById('bank_info');
            
            bankTransfer.addEventListener('change', function() {
                if (this.checked) {
                    bankInfo.classList.remove('d-none');
                }
            });
            
            cod.addEventListener('change', function() {
                if (this.checked) {
                    bankInfo.classList.add('d-none');
                }
            });
        });
    </script>
</body>
</html>