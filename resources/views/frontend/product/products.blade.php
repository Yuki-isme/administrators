<header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
    <strong class="d-block py-2">{{ count($newProducts) }} Items found </strong>
    <div class="ms-auto">
        <select class="form-select d-inline-block w-auto border pt-1">
            <option value="0">Best match</option>
            <option value="1">Recommended</option>
            <option value="2">High rated</option>
            <option value="3">Randomly</option>
        </select>
    </div>
</header>

<div id="products-container">
        @foreach ($newProducts as $product)
            <div class="row justify-content-center mb-3 product">
                <div class="col-md-12">
                    <div class="card shadow-0 border rounded-3">
                        <div class="card-body">
                            <div class="row g-0">
                                <div class="col-xl-3 col-md-4 d-flex justify-content-center">
                                    <div
                                        class="bg-image hover-zoom ripple rounded ripple-surface me-md-3 mb-3 mb-md-0">
                                        <img src="{{ asset('storage/' . $product->thumbnail->url) }}"
                                            class="w-100" />
                                        <a href="{{ route('productDetail', ['id'=>$product->id]) }}">
                                            <div class="hover-overlay">
                                                <div class="mask"
                                                    style="background-color: rgba(253, 253, 253, 0.15);">
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-md-4 col-sm-6">
                                    <h5><a href="{{ route('productDetail', ['id'=>$product->id]) }}" style="color: inherit">{{ $product->name }}</a></h5>
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
                                    <div class="mt-4">
                                        <button class="btn btn-primary shadow-0" type="button">Add to cart</button>
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

    <!-- Pagination -->
    <nav id="pagination" aria-label="Page navigation example" class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @php
                $totalPages = ceil(count($newProducts) / 5);
            @endphp
            @for ($i = 1; $i <= $totalPages; $i++)
                <li class="page-item{{ $i === 1 ? ' active' : '' }}">
                    <a class="page-link" href="#"
                        data-page="{{ $i }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- Pagination -->