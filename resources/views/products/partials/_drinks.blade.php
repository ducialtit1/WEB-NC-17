
<!-- filepath: d:\Do\WebNC\htdocs\my_Pro_FS\resources\views\products\partials\_drinks.blade.php -->
<div class="row">
    @foreach ($drinks as $drink)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card h-100 w-100">
                <a href="{{ route('products.show', $drink->slug) }}">
                    <img src="{{ asset('imgs/' . ($drink->mainImage->path ?? 'default.jpg')) }}" class="card-img-top" alt="{{ $drink->name }}">
                </a>
                <div class="card-body">
                    <a href="{{ route('products.show', $drink->slug) }}" class="text-decoration-none">
                        <h5 class="card-title">{{ $drink->name }}</h5>
                    </a>
                    <p class="card-text">{{ $drink->description }}</p>
                    <p class="card-text"><strong>Size:</strong> {{ $drink->size }}</p>
                    <p class="card-text"><strong>Giá:</strong> {{ number_format($drink->price) }} VND</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="d-flex justify-content-center">
    {!! $drinks->links('pagination::bootstrap-5') !!}
</div>