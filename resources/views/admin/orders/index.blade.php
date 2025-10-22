@extends('admin.layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">📦 Danh sách đơn hàng</h1>

    @if($orders->isEmpty())
        <div class="alert alert-info">Hiện chưa có đơn hàng nào.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Người đặt</th>
                        <th>SĐT</th>
                        <th>Địa chỉ</th>
                        <th>Phương thức</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->address }}</td>
                            <td>
                                {{ $order->payment_method == 'cod' ? 'COD' : 'Chuyển khoản ngân hàng' }}
                            </td>
                            <td>{{ number_format($order->total, 0, ',', '.') }} ₫</td>
                            <td>
                                @php
                                    $statusLabels = [
                                        'pending' => 'Chờ xác nhận',
                                        'processing' => 'Đã xác nhận',
                                        'shipping' => 'Đang giao hàng',
                                        'completed' => 'Đã hoàn thành',
                                        'cancelled' => 'Đã hủy',
                                    ];
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'shipping' => 'primary',
                                        'completed' => 'success',
                                        'cancelled' => 'danger',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Nếu đơn hàng đang chờ xác nhận --}}
                                    @if($order->status === 'pending')
                                        <a href="{{ route('admin.orders.confirm', $order->id) }}" class="btn btn-sm btn-success" title="Xác nhận đơn hàng">
                                            <i class="bi bi-check-circle"></i>
                                        </a>
                                    @endif

                                    {{-- Nếu đơn hàng đã xác nhận, có thể chuyển sang đang giao hàng --}}
                                    @if($order->status === 'processing')
                                        <form action="{{ route('admin.orders.shipping', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-warning" title="Chuyển sang đang giao hàng" onclick="return confirm('Chuyển đơn hàng sang trạng thái đang giao hàng?')">
                                                <i class="bi bi-truck"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Nếu đơn hàng đang xử lý hoặc đang giao hàng, có thể hoàn thành --}}
                                    @if(in_array($order->status, ['processing', 'shipping']))
                                        <form action="{{ route('admin.orders.completed', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="Hoàn thành đơn hàng" onclick="return confirm('Đánh dấu đơn hàng đã hoàn thành?')">
                                                <i class="bi bi-check2-all"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Xóa đơn hàng --}}
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa đơn hàng" onclick="return confirm('Xóa đơn hàng này?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $orders->links() }}
    @endif
</div>
@endsection
