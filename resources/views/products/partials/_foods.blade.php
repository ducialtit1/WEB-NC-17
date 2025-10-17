
<!-- filepath: d:\Do\WebNC\htdocs\my_Pro_FS\resources\views\products\partials\_foods.blade.php -->
<div class="row">
    @foreach ($foods as $food)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
            <div class="card h-100 w-100">
                <a href="{{ route('products.show', $food->slug) }}">
                    <img src="{{ asset('imgs/' . ($food->mainImage->path ?? 'default.jpg')) }}" class="card-img-top" alt="{{ $food->name }}">
                </a>
                <div class="card-body">
                    <a href="{{ route('products.show', $food->slug) }}" class="text-decoration-none">
                        <h5 class="card-title">{{ $food->name }}</h5>
                    </a>
                    <p class="card-text">{{ $food->description }}</p>
                    <p class="card-text"><strong>Size:</strong> {{ $food->size }}</p>
                    <p class="card-text"><strong>Giá:</strong> {{ number_format($food->price) }} VND</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="d-flex justify-content-center">
    {!! $foods->links('pagination::bootstrap-5') !!}
</div>