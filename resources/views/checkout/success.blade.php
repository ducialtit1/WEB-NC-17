<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - Food Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.header')
    
    <div class="main-content">
        <div class="container my-5">
            <div class="text-center mb-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h1 class="mb-3">Đặt hàng thành công!</h1>
                <p class="lead">Cảm ơn bạn đã đặt hàng tại Food Store</p>
                <p>Mã đơn hàng của bạn: <strong>#{{ $order->id }}</strong></p>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Thông tin giao hàng</h6>
                            <p class="mb-1"><strong>Tên:</strong> {{ $order->name }}</p>
                            <p class="mb-1"><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                            @if($order->notes)
                                <p><strong>Ghi chú:</strong> {{ $order->notes }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Chi tiết thanh toán</h6>
                            <p class="mb-1"><strong>Phương thức:</strong> 
                                {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản ngân hàng' }}
                            </p>
                            <p class="mb-1"><strong>Trạng thái:</strong> Chờ xử lý</p>
                            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            {{ $item->name }}
                                            @if($item->size)
                                                <small class="text-muted d-block">Size: {{ $item->size }}</small>
                                            @endif
                                        </td>
                                        <td>{{ number_format($item->price) }} VND</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">{{ number_format($item->price * $item->quantity) }} VND</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" style="padding: 3px 8px;">Tổng cộng:</th>
                                    <th class="text-end" style="padding: 3px 8px;">{{ number_format($order->total) }} VND</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <a href="{{ url('/') }}" class="btn btn-primary me-2">Tiếp tục mua sắm</a>
                <a href="{{ route('my.orders') }}" class="btn btn-outline-secondary">Xem đơn hàng của tôi</a>
            </div>
        </div>
    </div>
    
    @include('layouts.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>