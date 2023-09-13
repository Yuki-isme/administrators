@extends('frontend.layout.layout')

@section('content')
    <!-- cart + summary -->
    <section class="bg-light my-5">
        <div class="container">
            <div class="row">
                <!-- cart -->
                <div class="col-lg-12">
                    <div class="card border shadow-0">
                        <div class="m-4">
                            <h4 class="card-title mb-4">Your wishlist</h4>
                            <div id="wishlist-update">
                                @foreach ($products as $product)
                                    <div class="row gy-3 mb-4">
                                        <div class="col-lg-5">
                                            <div class="me-lg-5">
                                                <div class="d-flex">
                                                    <img src="{{ asset('storage/' . $product->thumbnail->url) }}"
                                                        class="border rounded me-3" style="width: 96px; height: 96px" />
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
                                        <div
                                            class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                                            <div class="">
                                                <select style="width: 100px" class="form-select me-4">
                                                    @for ($i = 1; $i <= $product->stock; $i++)
                                                        <option>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div style="display: flex; justify-content: center;">
                                                <div class="h6">
                                                    {{ number_format($product->cart_price, 0, ',', '.') }} VND
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
                                            <div class="float-md-end">
                                                <a href=""
                                                    class="btn btn-light border px-2 icon-hover wishlistUpdate"
                                                    data-product-id="{{ $product->id }}"
                                                    data-current-action="{{ $wishlists ? (in_array($product->id, $wishlists) ? 'remove' : 'add') : 'add' }}">
                                                    <i
                                                        class="fas fa-heart fa-lg
                                                        {{ $wishlists ? (in_array($product->id, $wishlists) ? 'text-primary' : 'text-secondary') : 'text-secondary' }}
                                                        px-1 icon-wishlist"></i>
                                                </a>
                                                <a href="{{ route('addToCart', ['id' => $product->id]) }}"
                                                    class="btn btn-outline-primary addToCartButton">ADD TO CART</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- @else
                                <div class="row gy-3 mb-4">

                                </div> --}}

                        </div>

                    </div>
                </div>
                <!-- cart -->
            </div>
        </div>
    </section>
    <!-- cart + summary -->
    <section>
        <div class="container my-5">
            <header class="mb-4">
                <h3>Recommended items</h3>
            </header>

            <div class="row">
                @foreach ($similarProducts as $similarProduct)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card px-4 border shadow-0 mb-4 mb-lg-0">
                            <div class="mask px-2" style="height: 50px">
                                <div class="d-flex justify-content-between">
                                    <h6>
                                        {{-- <span class="badge bg-danger pt-1 mt-3 ms-2">New</span> --}}
                                    </h6>
                                    <a href="#" class="wishlistUpdate" data-product-id="{{ $similarProduct->id }}"
                                        data-current-action="{{ $wishlists ? (in_array($similarProduct->id, $wishlists) ? 'remove' : 'add') : 'add' }}"><i
                                            class="fas fa-heart {{ $wishlists ? (in_array($similarProduct->id, $wishlists) ? 'text-primary' : 'text-secondary') : 'text-secondary' }} fa-lg float-end pt-3 m-2"></i></a>
 

                                </div>
                            </div>
                            <a href="#" class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset('storage/' . $similarProduct->thumbnail->url) }}"
                                    style="width: 200px; height: 200px" class="card-img-top rounded-2" />
                            </a>
                            <div class="card-body d-flex flex-column pt-3 border-top">
                                <a href="#" class="nav-link">{{ $similarProduct->name }}</a>
                                <div class="price-wrap mb-2">
                                    <strong class="">{{ $similarProduct->cart_price }}</strong>
                                    <del class="">{{ $similarProduct->price }}</del>
                                </div>
                                <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                    <a href="{{ route('addToCart', ['id' => $similarProduct->id]) }}" class="btn btn-outline-primary w-100 addToCartButton">Add to cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Recommended -->
@endsection

@push('custom-script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.addToCartButton', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('href'),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#cart-amount').text('My cart' + ' (' + response.count + ')');
                            alertify.success(response.message, {
                                'cssClass': 'ajs-success'
                            });
                        } else {
                            alertify.error(response.message, {
                                'cssClass': 'ajs-error'
                            });

                        }
                    }
                });
            });
        });

        $(document).ready(function() {
            $(document).on('click', '.wishlistUpdate', function(e) {
                e.preventDefault();
                var isUserLoggedIn = {{ Auth::guard('web')->check() ? 'true' : 'false' }};
                // Kiểm tra xem người dùng đã đăng nhập chưa
                if (!isUserLoggedIn) {
                    // Nếu chưa đăng nhập, chuyển hướng sang trang đăng nhập
                    window.location.href = '{{ route('wishlist') }}';
                    return;
                }
                var iconElement = $(this).find('i');

                var productId = $(this).data('product-id');
                var url = '{{ route('wishlistUpdate', ['id' => ':productId']) }}';
                url = url.replace(':productId', productId);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            alertify.success(response.message, {
                                'cssClass': 'ajs-success'
                            });
                            iconElement.toggleClass('text-primary text-secondary');
                            $('#wishlist-update').html(response.view);
                        } else {
                            alertify.error(response.message, {
                                'cssClass': 'ajs-error'
                            });
                        }
                    }.bind(this) // Chắc chắn rằng "this" trỏ đúng đối tượng
                });
            });
        });

        $(document).ready(function() {
            $(document).on('click', '.wishlistButton', function(e) {
                e.preventDefault();
                var isUserLoggedIn = {{ Auth::guard('web')->check() ? 'true' : 'false' }};
                // Kiểm tra xem người dùng đã đăng nhập chưa
                if (!isUserLoggedIn) {
                    // Nếu chưa đăng nhập, chuyển hướng sang trang đăng nhập
                    window.location.href = '{{ route('wishlist') }}';
                    return;
                }

                var productId = $(this).data('product-id');
                var currentAction = $(this).data('current-action');
                var iconElement = $(this).find('i');

                var url = currentAction === 'add' ? '{{ route('addWishlist', ['id' => ':productId']) }}' :
                    '{{ route('removeWishlist', ['id' => ':productId']) }}';
                url = url.replace(':productId', productId);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            alertify.success(response.message, {
                                'cssClass': 'ajs-success'
                            });

                            // Thay đổi href và class của nút
                            if (currentAction === 'add') {
                                $(this).attr('href',
                                    '{{ route('removeWishlist', ['id' => ':productId']) }}'
                                    .replace(':productId', productId));
                                $(this).data('current-action', 'remove');
                            } else {
                                $(this).attr('href',
                                    '{{ route('addWishlist', ['id' => ':productId']) }}'
                                    .replace(':productId', productId));
                                $(this).data('current-action', 'add');
                            }

                            // Thay đổi màu văn bản
                            iconElement.toggleClass('text-primary text-secondary');
                        } else {
                            alertify.error(response.message, {
                                'cssClass': 'ajs-error'
                            });
                        }
                    }.bind(this) // Chắc chắn rằng "this" trỏ đúng đối tượng
                });
            });
        });
    </script>
@endpush
