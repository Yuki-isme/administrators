<div id="products-container">
    <div id="product-grid">
        <div class="row">
            @foreach ($newProducts as $product)
                <div class="col-lg-4 col-md-6 col-sm-6 d-flex product product-grid">
                    <div class="card w-100 my-2 shadow-2-strong">
                        <img src="{{ asset('storage/' . $product->thumbnail->url) }}"
                            class="card-img-top" />
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex flex-row">
                                <h5 class="mb-1 me-1">
                                    {{ number_format($product->cart_price, 0, ',', '.') }}
                                    VND</h5>
                                <span class="text-danger"><s>{{ number_format($product->price, 0, ',', '.') }}
                                        VND</s></span>
                            </div>
                            <p class="card-text">{{ $product->name }}
                            </p>
                            <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                <a href="{{ route('addToCart', ['id' => $product->id]) }}"
                                    class="btn btn-primary shadow-0 me-1 addToCartButton">Add to cart</a>
                                <a href="" class="btn btn-light border px-2 pt-2 icon-hover wishlistButton"
                                    data-product-id="{{ $product->id }}"
                                    data-current-action="{{ $wishlists ? (in_array($product->id, $wishlists) ? 'remove' : 'add') : 'add' }}">
                                    <i
                                        class="fas fa-heart fa-lg
                                        {{ $wishlists ? (in_array($product->id, $wishlists) ? 'text-primary' : 'text-secondary') : 'text-secondary' }}
                                        px-1 icon-wishlist"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="product-list">
        @foreach ($newProducts as $product)
            <div class="row justify-content-center mb-3 product product product-list">
                <div class="col-md-12">
                    <div class="card shadow-0 border rounded-3">
                        <div class="card-body" style="height: 150px">
                            <div class="row g-0">
                                <div class="col-xl-3 col-md-4 d-flex justify-content-center">
                                    <div
                                        class="bg-image hover-zoom ripple rounded ripple-surface me-md-3 mb-3 mb-md-0">
                                        <img src="{{ asset('storage/' . $product->thumbnail->url) }}"
                                            style="height: 50%;" class="w-100" />
                                        <a
                                            href="{{ route('productDetail', ['id' => $product->id]) }}">
                                            <div class="hover-overlay">
                                                <div class="mask"
                                                    style="background-color: rgba(253, 253, 253, 0.15);">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-md-4 col-sm-6">
                                    <h5><a href="{{ route('productDetail', ['id' => $product->id]) }}"
                                            style="color: inherit">{{ $product->name }}</a></h5>
                                    <div class="d-flex flex-row">
                                        <span class="text-muted" style="font-size: 14px">SKU:
                                            {{ $product->sku }}</span>

                                    </div>

                                    <p class="text mb-4 mb-md-0">
                                        {!! $product->description !!}
                                    </p>
                                </div>
                                <div class="col-xl-4 col-md-4 col-sm-6">
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        <h4 class="mb-1 me-2">
                                            {{ number_format($product->cart_price, 0, ',', '.') }}
                                            VND
                                        </h4>
                                        @if ($product->cart_price < $product->price)
                                            <span class="text-danger"><s>{{ number_format($product->price, 0, ',', '.') }}
                                                    VND</s></span>
                                        @endif
                                    </div>
                                    <h6 class="text-success">Free shipping</h6>
                                    <div class="mt-3">
                                        <a href="{{ route('addToCart', ['id' => $product->id]) }}"
                                            class="btn btn-primary shadow-0 me-1 addToCartButton">Add to cart</a>
                                        <a href="" class="btn btn-light border px-2 pt-2 icon-hover wishlistButton"
                                            data-product-id="{{ $product->id }}"
                                            data-current-action="{{ $wishlists ? (in_array($product->id, $wishlists) ? 'remove' : 'add') : 'add' }}">
                                            <i
                                                class="fas fa-heart fa-lg
                                                {{ $wishlists ? (in_array($product->id, $wishlists) ? 'text-primary' : 'text-secondary') : 'text-secondary' }}
                                                px-1 icon-wishlist"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
