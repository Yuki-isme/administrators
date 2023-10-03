@foreach ($products as $product)
    <div class="row gy-3 mb-4">
        <div class="col-lg-5">
            <div class="me-lg-5">
                <div class="d-flex">
                    <img src="{{ asset('storage/' . $product->thumbnail->url) }}" class="border rounded me-3"
                        style="width: 96px; height: 96px" />
                    <div class="">
                        <a href="#" class="nav-link">{{ $product->name }}</a>
                        <p class="text-muted">
                            @foreach ($product->tags as $tag)
                                <a>{{ $tag->name }}</a>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
            <div class="">
                <select style="width: 100px" class="form-select me-4">
                    @for ($i = 1; $i <= $product->stock; $i++)
                        <option>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div style="display: flex; justify-content: center;">
                <div class="h6">
                    @if ($product->sale_price == 0)
                        <strong class="">{{ number_format($product->cart_price, 0, ',', '.') }}
                            VND</strong>
                    @else
                        <strong class="">{{ number_format($product->cart_price, 0, ',', '.') }}
                            VND</strong>
                        <div class="price-wrap mb-2">
                            <del class=" text-danger">{{ number_format($product->price, 0, ',', '.') }}
                                VND</del>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div
            class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
            <div class="float-md-end">
                <a href="" class="btn btn-light border px-2 icon-hover wishlistUpdate"
                    data-product-id="{{ $product->id }}"
                    data-current-action="{{ $wishlists ? (in_array($product->id, $wishlists) ? 'remove' : 'add') : 'add' }}">
                    <i
                        class="fas fa-heart fa-lg {{ $wishlists ? (in_array($product->id, $wishlists) ? 'text-primary' : 'text-secondary') : 'text-secondary' }} px-1 icon-wishlist"></i>
                </a>
                <a href="{{ route('addToCart', ['id' => $product->id]) }}"
                    class="btn btn-outline-primary addToCartButton">ADD TO CART</a>
            </div>
        </div>
    </div>
@endforeach
