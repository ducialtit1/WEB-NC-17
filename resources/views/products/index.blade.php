<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.header')
    <div class="container mt-5">
        <h2>Đồ ăn</h2>
        <div id="foods-list">
            @include('products.partials._foods', ['foods' => $foods])
        </div>
        <h2>Đồ uống</h2>
        <div id="drinks-list">
            @include('products.partials._drinks', ['drinks' => $drinks])
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
<script>
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
            $('#foods-list').html(data);
        }
    });
});

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
            $('#drinks-list').html(data);
        }
    });
});
</script>
    </script>
    @include('layouts.footer')
</body>
</html>