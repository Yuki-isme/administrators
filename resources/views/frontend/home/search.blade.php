<div class="search-results">
    <ul>
        @foreach ($products as $product)
            <li>
                <a href="{{ route('productDetail', ['id' => $product->id]) }}" class="product-link">
                    <div class="product-item">
                        <img src="{{ asset('storage/' . $product->thumbnail->url) }}" class="product-image">
                        <div class="product-info">
                            <span class="product-name">{{ $product->name }}</span>
                            <span class="product-price">{{ $product->cart_price }}</span>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
