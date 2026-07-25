<div class="card h-100">
    @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" 
             class="card-img-top" alt="{{ $product->name }}">
    @endif
    <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        <p class="card-text">{{ Str::limit($product->description, 80) }}</p>
        <p class="fw-bold">${{ number_format($product->price, 2) }}</p>
        <a href="{{ route('products.show', $product) }}" class="btn btn-primary">
            Ver detalle
        </a>
    </div>
</div>
