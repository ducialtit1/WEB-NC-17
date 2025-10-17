<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giỏ hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
  @include('layouts.header')

  <div class="container my-4">
    <h2 class="mb-3">Giỏ hàng</h2>

    @php $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']); @endphp

    @if(empty($cart))
      <div class="alert alert-info">Giỏ hàng trống.</div>
    @else
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Sản phẩm</th>
              <th>Size</th>
              <th>Giá</th>
              <th>Số lượng</th>
              <th>Tạm tính</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($cart as $item)
              <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['size'] ?? '-' }}</td>
                <td>{{ number_format($item['price']) }} VND</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['price'] * $item['quantity']) }} VND</td>
                <td>
                  <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">Xóa</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="4" class="text-end">Tổng</th>
              <th>{{ number_format($total) }} VND</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
    @endif
  </div>
    @if(!empty($cart))
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('checkout.index') }}" class="btn btn-success btn-lg">
                Thanh toán
            </a>
        </div>
    @endif
  @include('layouts.footer')
</body>
</html>