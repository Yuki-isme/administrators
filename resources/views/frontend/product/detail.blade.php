@extends('frontend.layout.layout')

@section('content')
    <!-- content -->
    <section class="py-5">
        <div class="container">
            <div class="row gx-5">

                <div class="col-lg-6" style="height: 600px;">
                    <div class="slider-for resize-images" style="width: 100%; height: 75%;">
                        <img src="{{ asset('storage/' . $productDetail->thumbnail->url) }}" />
                        @foreach ($productDetail->media as $media)
                            <img src="{{ asset('storage/' . $media->url) }}" />
                        @endforeach
                    </div>

                    <div class="slider-nav">
                        <img src="{{ asset('storage/' . $productDetail->thumbnail->url) }}" />
                        @foreach ($productDetail->media as $media)
                            <img src="{{ asset('storage/' . $media->url) }}" />
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ps-lg-3">
                        <h4 class="title text-dark">
                            {{ $productDetail->name }} <div class="text-muted" style="font-size: 13px">SKU:
                                {{ $productDetail->sku }}</div>
                        </h4>
                        <div class="d-flex flex-row my-3">
                            {{-- <div class="text-warning mb-1 me-2">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ms-1">
                                    4.5
                                </span>
                            </div> --}}

                            <div class="text-muted"> <i class="fas fa-shopping-basket fa-sm mx-1">
                                </i>{{ cart()->countInOrder($productDetail->id) }} orders</div>
                            <span class="text-success ms-2">In stock</span>
                        </div>

                        <div class="mb-3">
                            <span class="h5"
                                style="color: rgb(190, 12, 12)">{{ number_format($productDetail->cart_price, 0, ',', '.') }}
                                VND</span>
                            <span class="text-muted">/per box</span>
                        </div>

                        <div class="row">
                            <dt class="col-3">Category</dt>
                            <dd class="col-9">{{ $productDetail->category->parent->name }} >
                                {{ $productDetail->category->name }}</dd>

                            <dt class="col-3">Brand</dt>
                            <dd class="col-9">{{ $productDetail->brand->name }}</dd>



                            {{-- @foreach ($productDetail->attributeValue as $attribute)
                                <dt class="col-3">{{ $attribute->attribute->name }}</dt>
                                <dd class="col-9">{{ $attribute->value }}</dd>
                            @endforeach --}}
                        </div>

                        <hr />

                        <div class="row">
                            <p>{!! $productDetail->description !!}</p>
                        </div>

                        <hr />

                        <div class="row mb-4">
                            {{-- <div class="col-md-4 col-6">
                                <label class="mb-2">Size</label>
                                <select class="form-select border border-secondary" style="height: 35px;">
                                    <option>Small</option>
                                    <option>Medium</option>
                                    <option>Large</option>
                                </select>
                            </div> --}}
                            <!-- col.// -->
                            <div class="col-md-4 col-6 mb-3">
                                <label class="mb-2 d-block">Quantity: {{ $productDetail->stock }}</label>
                                <div class="input-group mb-3" style="width: 170px;">
                                    <button class="btn btn-white border border-secondary px-3" type="button"
                                        id="button-addon1" data-mdb-ripple-color="dark">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="text" class="form-control text-center border border-secondary"
                                        aria-label="Example text with button addon" aria-describedby="button-addon1"
                                        max="{{ $productDetail->stock }}" min="1" id="quantityInput"
                                        value="{{ $productDetail->stock > 0 ? 1 : 0 }}" inputmode="numeric"
                                        pattern="[0-9]*" />
                                    <button class="btn btn-white border border-secondary px-3" type="button"
                                        id="button-addon2" data-mdb-ripple-color="dark">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                        <a href="{{ route('buyNow', ['id' => $productDetail->id]) }}" class="btn btn-warning shadow-0"
                            id="buyNowLink"> Buy now </a>
                        <a href="{{ route('addToCart', ['id' => $productDetail->id]) }}" class="btn btn-primary shadow-0"
                            id="addToCartButton"> <i class="me-1 fa fa-shopping-basket"></i>
                            Add to cart </a>
                        <a href="" class="btn btn-light border px-2 pt-2 icon-hover wishlistButton"
                            data-product-id="{{ $productDetail->id }}"
                            data-current-action="{{ $wishlists ? (in_array($productDetail->id, $wishlists) ? 'remove' : 'add') : 'add' }}">
                            <i
                                class="fas fa-heart fa-lg
                                {{ $wishlists ? (in_array($productDetail->id, $wishlists) ? 'text-primary' : 'text-secondary') : 'text-secondary' }}
                                px-1 icon-wishlist"></i>
                            Save </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- content -->

    <section class="bg-light border-top py-4">
        <div class="container">
            <div class="row gx-4">
                <div class="col-lg-8 mb-4">
                    <div class="border rounded-2 px-3 py-2 bg-white">
                        <!-- Pills navs -->
                        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                            <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100 active"
                                    id="ex1-tab-1" data-mdb-toggle="pill" href="#ex1-pills-1" role="tab"
                                    aria-controls="ex1-pills-1" aria-selected="true">Specification</a>
                            </li>
                            <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100" id="ex1-tab-2"
                                    data-mdb-toggle="pill" href="#ex1-pills-2" role="tab" aria-controls="ex1-pills-2"
                                    aria-selected="false">Content</a>
                            </li>
                            {{-- <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100" id="ex1-tab-3"
                                    data-mdb-toggle="pill" href="#ex1-pills-3" role="tab"
                                    aria-controls="ex1-pills-3" aria-selected="false">Shipping info</a>
                            </li> --}}
                            {{-- <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100" id="ex1-tab-4"
                                    data-mdb-toggle="pill" href="#ex1-pills-4" role="tab"
                                    aria-controls="ex1-pills-4" aria-selected="false">Seller profile</a>
                            </li> --}}
                        </ul>
                        <!-- Pills navs -->

                        <!-- Pills content -->
                        <div class="tab-content" id="ex1-content">
                            <div class="tab-pane fade show active" id="ex1-pills-1" role="tabpanel"
                                aria-labelledby="ex1-tab-1">
                                {{-- <p>
                                    {!! $productDetail->content !!}
                                </p> --}}
                                {{-- <div class="row mb-2">
                                    <div class="col-12 col-md-6">
                                        <ul class="list-unstyled mb-0">
                                            <li><i class="fas fa-check text-success me-2"></i>Some great feature name here
                                            </li>
                                            <li><i class="fas fa-check text-success me-2"></i>Lorem ipsum dolor sit amet,
                                                consectetur</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Duis aute irure dolor in
                                                reprehenderit</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Optical heart sensor</li>
                                        </ul>
                                    </div>
                                    <div class="col-12 col-md-6 mb-0">
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Easy fast and ver good</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Some great feature name here
                                            </li>
                                            <li><i class="fas fa-check text-success me-2"></i>Modern style and design</li>
                                        </ul>
                                    </div>
                                </div> --}}
                                <table class="table border mt-3 mb-2">
                                    @foreach ($productDetail->attributeValue as $attribute)
                                        <tr>
                                            <th class="py-2">{{ $attribute->attribute->name }}</th>
                                            <td class="py-2">{{ $attribute->value }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="tab-pane fade mb-2" id="ex1-pills-2" role="tabpanel"
                                aria-labelledby="ex1-tab-2">
                                <p>
                                    {!! $productDetail->content !!}
                                </p>
                            </div>
                            {{-- <div class="tab-pane fade mb-2" id="ex1-pills-3" role="tabpanel"
                                aria-labelledby="ex1-tab-3">
                                Another tab content or sample information now <br />
                                Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                                ut aliquip ex ea
                                commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                                dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                                culpa qui officia deserunt
                                mollit anim id est laborum.
                            </div>
                            <div class="tab-pane fade mb-2" id="ex1-pills-4" role="tabpanel"
                                aria-labelledby="ex1-tab-4">
                                Some other tab content or sample information now <br />
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                laboris nisi ut
                                aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                                esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                                sunt in culpa qui
                                officia deserunt mollit anim id est laborum.
                            </div> --}}
                        </div>
                        <!-- Pills content -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="px-0 border rounded-2 shadow-0">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Similar items</h5>
                                <div class="similar-scroll">
                                    @foreach ($similarProducts as $similarProduct)
                                        <div class="d-flex similar-product">
                                            <a href="{{ route('productDetail', ['id' => $similarProduct->id]) }}" class="me-3">
                                                <img src="{{ asset('storage/' . $similarProduct->thumbnail->url) }}" style="min-width: 96px; height: 96px;"
                                                    class="img-md img-thumbnail" />
                                            </a>
                                            <div class="product-details">
                                                <div class="name-price">
                                                    <a href="{{ route('productDetail', ['id' => $similarProduct->id]) }}" class="nav-link mb-1">{{ $similarProduct->name }}</a>
                                                    <span class="text-success">{{ $similarProduct->cart_price }}</span>
                                                </div>
                                                <div class="buttons">
                                                    <a href="{{ route('addToCart', ['id' => $similarProduct->id]) }}" class="btn btn-primary shadow-0 me-1 addToCartButton">Add to cart</a>
                                                    <a href="" class="btn btn-light border px-2 pt-2 icon-hover wishlistButton"
                                                        data-product-id="{{ $similarProduct->id }}"
                                                        data-current-action="{{ $wishlists ? (in_array($similarProduct->id, $wishlists) ? 'remove' : 'add') : 'add' }}">
                                                        <i class="fas fa-heart fa-lg
                                                            {{ $wishlists ? (in_array($similarProduct->id, $wishlists) ? 'text-primary' : 'text-secondary') : 'text-secondary' }}
                                                            px-1 icon-wishlist"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('custom-script')
    <script>
        $(document).ready(function() {
            $("#buyNowLink").on("click", function(e) {
                e.preventDefault();
                var url = $(this).attr("href");
                // Tạo một biểu mẫu (form) ẩn
                var form = document.createElement("form");
                form.setAttribute("method", "POST");
                form.setAttribute("action",url); // Sử dụng biến productId ở đây

                // Tạo một input để gửi token CSRF nếu cần
                var csrfTokenInput = document.createElement("input");
                csrfTokenInput.setAttribute("type", "hidden");
                csrfTokenInput.setAttribute("name", "_token");
                csrfTokenInput.setAttribute("value", "{{ csrf_token() }}");

                // Thêm input và form vào DOM
                document.body.appendChild(form);
                form.appendChild(csrfTokenInput);

                // Gửi biểu mẫu
                form.submit();
            });
        });

        $(document).ready(function() {
            $('#addToCartButton').on('click', function(e) {
                e.preventDefault();

                // Lấy giá trị số lượng từ input
                var quantity = $('#quantityInput').val();

                // Lấy href của nút "Add to cart"
                var addToCartUrl = $(this).attr('href');

                $.ajax({
                    url: addToCartUrl,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        amount: quantity, // Gửi giá trị số lượng
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
            $('.addToCartButton').on('click', function(e) {
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
            $('.wishlistButton').on('click', function(e) {
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

        $(document).ready(function() {
            // Khởi tạo Slider chính
            $('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.slider-nav'
            });

            // Khởi tạo Slider điều hướng
            $('.slider-nav').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                asNavFor: '.slider-for',
                dots: false,
                centerMode: true,
                focusOnSelect: true,
            });
        });

        $(document).ready(function() {
            const quantityInput = $("#quantityInput");
            const maxStock = parseInt(quantityInput.attr("max"));

            // Xử lý sự kiện khi người dùng thay đổi giá trị input
            quantityInput.on("input", function() {
                let currentValue = quantityInput.val().replace(/[^0-9]/g,
                    ""); // Loại bỏ tất cả các ký tự không phải số

                // Kiểm tra nếu giá trị nhập vào lớn hơn giới hạn (stock)
                if (currentValue > maxStock) {
                    // Thiết lập giá trị nhập vào bằng giới hạn
                    currentValue = maxStock;
                } else if (currentValue < 1) {
                    // Kiểm tra nếu giá trị nhập vào nhỏ hơn 1
                    // Thiết lập giá trị nhập vào bằng 1
                    currentValue = 1;
                }

                quantityInput.val(currentValue); // Cập nhật lại giá trị của input
            });

            // Xử lý sự kiện khi nhấn nút tăng (+)
            $("#button-addon2").on("click", function() {
                let currentValue = parseInt(quantityInput.val());

                // Kiểm tra nếu giá trị hiện tại nhỏ hơn giá trị tối đa (max)
                if (currentValue < maxStock) {
                    // Tăng giá trị lên 1 và cập nhật lại giá trị của input
                    currentValue++;
                    quantityInput.val(currentValue);
                }
            });

            // Xử lý sự kiện khi nhấn nút giảm (-)
            $("#button-addon1").on("click", function() {
                let currentValue = parseInt(quantityInput.val());

                // Kiểm tra nếu giá trị hiện tại lớn hơn 1
                if (currentValue > 1) {
                    // Giảm giá trị đi 1 và cập nhật lại giá trị của input
                    currentValue--;
                    quantityInput.val(currentValue);
                }
            });
        });
    </script>
@endpush
