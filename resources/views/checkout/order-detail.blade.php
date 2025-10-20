<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #{{ $order->id }} - Food Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.header')
    
    <div class="main-content">
        <div class="container my-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
                <a href="{{ route('my.orders') }}" class="btn btn-outline-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Quay lại danh sách
                </a>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                    <span class="badge bg-light text-primary">
                        @switch($order->status)
                            @case('pending')
                                Chờ xử lý
                                @break
                            @case('processing')
                                Đã xác nhận
                                @break
                            @case('completed')
                                Đã hoàn thành
                                @break
                            @case('cancelled')
                                Đã hủy
                                @break
                            @default
                                {{ $order->status }}
                        @endswitch
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Thông tin giao hàng</h6>
                            <p class="mb-1"><strong>Tên:</strong> {{ $order->name }}</p>
                            <p class="mb-1"><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                            @if($order->notes)
                                <p><strong>Ghi chú:</strong> {{ $order->notes }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Chi tiết thanh toán</h6>
                            <p class="mb-1"><strong>Phương thức:</strong> 
                                {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản ngân hàng' }}
                            </p>
                            <p class="mb-1"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Cập nhật cuối:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <h6 class="fw-bold mb-3">Chi tiết sản phẩm</h6>
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
                                    <th colspan="3">Tổng cộng:</th>
                                    <th class="text-end">{{ number_format($order->total) }} VND</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <a href="{{ url('/') }}" class="btn btn-outline-primary me-2">Tiếp tục mua sắm</a>
                
                @if($order->status === 'pending')
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                        Hủy đơn hàng
                    </button>
                    
                    <!-- Modal xác nhận hủy đơn -->
                    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelModalLabel">Xác nhận hủy đơn</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Bạn có chắc muốn hủy đơn hàng #{{ $order->id }} không?</p>
                                    <p>Hành động này không thể hoàn tác.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    @include('layouts.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>