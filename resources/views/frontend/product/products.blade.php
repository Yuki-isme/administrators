<div id="products-container">
    @foreach ($newProducts as $product)
        <div class="row justify-content-center mb-3 product">
            <div class="col-md-12">
                <div class="card shadow-0 border rounded-3">
                    <div class="card-body" style="height: 150px">
                        <div class="row g-0">
                            <div class="col-xl-3 col-md-4 d-flex justify-content-center">
                                <div
                                    class="bg-image hover-zoom ripple rounded ripple-surface me-md-3 mb-3 mb-md-0">
                                    <img src="{{ asset('storage/' . $product->thumbnail->url) }}" style="height: 50%;"
                                        class="w-100" />
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
                                        {{ number_format($product->cart_price, 0, ',', '.') }} VND
                                    </h4>
                                    @if ($product->cart_price < $product->price)
                                        <span class="text-danger"><s>{{ number_format($product->price, 0, ',', '.') }}
                                                VND</s></span>
                                    @endif
                                </div>
                                <h6 class="text-success">Free shipping</h6>
                                <div class="mt-3">
                                    <button class="btn btn-primary shadow-0" type="button">Add to
                                        cart</button>
                                    <a href="#!"
                                        class="btn btn-light border px-2 pt-2 icon-hover"><i
                                            class="fas fa-heart fa-lg px-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<hr />

<div id="paginations">
    <!-- Pagination -->
    <nav id="pagination" aria-label="Page navigation example"
        class="d-flex justify-content-center mt-3">
        <ul class="pagination">

        </ul>
    </nav>
    <!-- Pagination -->
</div>