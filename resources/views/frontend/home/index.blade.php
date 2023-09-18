@extends('frontend.layout.layout')

@section('content')
    <!-- Jumbotron -->
    <div class="bg-primary text-white py-5">
        <div class="container py-5">
            <h1>
                Best products & <br />
                brands in our store
            </h1>
            <p>
                Trendy Products, Factory Prices, Excellent Service
            </p>
            <a href="{{ route('list') }}">
                <button type="button" class="btn btn-outline-light">
                    Learn more
                </button>
            </a>
            <a href="{{ route('list') }}">
                <button type="button" class="btn btn-light shadow-0 text-primary pt-2 border border-white">
                    <span class="pt-1">Purchase now</span>
                </button>
            </a>
        </div>
    </div>
    <!-- Jumbotron -->

    <!-- category -->
    <section>
        <div class="container pt-5">
            <nav class="row gy-4">
                @foreach ($categoriesIndex as $index => $category)
                    @if ($index % 4 == 0)
                        <div class="col-lg-6 col-md-12">
                            <div class="row">
                    @endif
                    <div class="col-3">
                        <a href="{{ route('listByCategory', ['id' => $category->id]) }}"
                            class="text-center d-flex flex-column justify-content-center">
                            <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2"
                                data-mdb-ripple-color="dark">
                                {{-- <i class="fas fa-couch fa-xl fa-fw"></i> --}}
                                <img src="{{ asset('storage/' . $category->thumbnail->url) }}" width="30px"
                                    height="30px">
                            </button>
                            <div class="text-dark">{{ $category->name }}</div>
                        </a>
                    </div>
                    @if (($index + 1) % 4 == 0 || $index == count($categoriesIndex) - 1)
        </div>
        </div>
        @endif
        @endforeach
        </nav>
        </div>
    </section>
    <!-- category -->

    <!-- Products -->
    <section>
        <div class="container my-5">
            <header class="mb-4">
                <h3>New products</h3>
            </header>
            <div class="row">
                @foreach ($newProducts as $newProduct)
                    <div class="col-lg-3 col-md-6 col-sm-6 d-flex">
                        <div class="card w-100 my-2 shadow-2-strong">
                            <a href="{{ route('productDetail', ['id' => $newProduct->id]) }}" class="text-product">
                                <img src="{{ asset('storage/' . $newProduct->thumbnail->url) }}" class="card-img-top"
                                    style="aspect-ratio: 1 / 1" />
                            </a>
                            <div class="card-body d-flex flex-column">
                                <a href="{{ route('productDetail', ['id' => $newProduct->id]) }}" class="text-product">
                                    <h5 class="card-title">{{ $newProduct->name }}</h5>
                                </a>
                                <p class="card-text">{{ number_format($newProduct->cart_price, 0, ',', '.') }} VND</p>
                                <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                    <a href="{{ route('addToCart', ['id' => $newProduct->id]) }}"
                                        class="btn btn-primary shadow-0 me-1 addToCartButton">Add to cart</a>
                                    <a href="" class="btn btn-light border px-2 pt-2 icon-hover wishlistButton"
                                        data-product-id="{{ $newProduct->id }}"
                                        data-current-action="{{ $wishlists ? (in_array($newProduct->id, $wishlists) ? 'remove' : 'add') : 'add' }}">
                                        <i
                                            class="fas fa-heart fa-lg
                                            {{ $wishlists ? (in_array($newProduct->id, $wishlists) ? 'text-primary' : 'text-secondary') : 'text-secondary' }}
                                            px-1 icon-wishlist"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Products -->

    <!-- Feature -->
    <section class="mt-5" style="background-color: #f5f5f5;">
        <div class="container text-dark pt-3">
            <header class="pt-4 pb-3">
                <h3>Why choose us</h3>
            </header>

            <div class="row mb-4">
                <div class="col-lg-4 col-md-6">
                    <figure class="d-flex align-items-center mb-4">
                        <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                            <i class="fas fa-camera-retro fa-2x fa-fw text-primary floating"></i>
                        </span>
                        <figcaption class="info">
                            <h6 class="title">Reasonable prices</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
                        </figcaption>
                    </figure>
                    <!-- itemside // -->
                </div>
                <!-- col // -->
                <div class="col-lg-4 col-md-6">
                    <figure class="d-flex align-items-center mb-4">
                        <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                            <i class="fas fa-star fa-2x fa-fw text-primary floating"></i>
                        </span>
                        <figcaption class="info">
                            <h6 class="title">Best quality</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
                        </figcaption>
                    </figure>
                    <!-- itemside // -->
                </div>
                <!-- col // -->
                <div class="col-lg-4 col-md-6">
                    <figure class="d-flex align-items-center mb-4">
                        <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                            <i class="fas fa-plane fa-2x fa-fw text-primary floating"></i>
                        </span>
                        <figcaption class="info">
                            <h6 class="title">Worldwide shipping</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
                        </figcaption>
                    </figure>
                    <!-- itemside // -->
                </div>
                <!-- col // -->
                <div class="col-lg-4 col-md-6">
                    <figure class="d-flex align-items-center mb-4">
                        <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                            <i class="fas fa-users fa-2x fa-fw text-primary floating"></i>
                        </span>
                        <figcaption class="info">
                            <h6 class="title">Customer satisfaction</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
                        </figcaption>
                    </figure>
                    <!-- itemside // -->
                </div>
                <!-- col // -->
                <div class="col-lg-4 col-md-6">
                    <figure class="d-flex align-items-center mb-4">
                        <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                            <i class="fas fa-thumbs-up fa-2x fa-fw text-primary floating"></i>
                        </span>
                        <figcaption class="info">
                            <h6 class="title">Happy customers</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
                        </figcaption>
                    </figure>
                    <!-- itemside // -->
                </div>
                <!-- col // -->
                <div class="col-lg-4 col-md-6">
                    <figure class="d-flex align-items-center mb-4">
                        <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
                            <i class="fas fa-box fa-2x fa-fw text-primary floating"></i>
                        </span>
                        <figcaption class="info">
                            <h6 class="title">Thousand items</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
                        </figcaption>
                    </figure>
                    <!-- itemside // -->
                </div>
                <!-- col // -->
            </div>
        </div>
        <!-- container end.// -->
    </section>
    <!-- Feature -->

    <!-- Blog -->
    <section class="mt-5 mb-4">
        <div class="container text-dark">
            <header class="mb-4">
                <h3>Blog posts</h3>
            </header>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <article>
                        <a href="#" class="img-fluid">
                            <img class="rounded w-100"
                                src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/posts/1.webp"
                                style="object-fit: cover;" height="160" />
                        </a>
                        <div class="mt-2 text-muted small d-block mb-1">
                            <span>
                                <i class="fa fa-calendar-alt fa-sm"></i>
                                23.12.2022
                            </span>
                            <a href="#">
                                <h6 class="text-dark">How to promote brands</h6>
                            </a>
                            <p>When you enter into any new area of science, you almost reach</p>
                        </div>
                    </article>
                </div>
                <!-- col.// -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <article>
                        <a href="#" class="img-fluid">
                            <img class="rounded w-100"
                                src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/posts/2.webp"
                                style="object-fit: cover;" height="160" />
                        </a>
                        <div class="mt-2 text-muted small d-block mb-1">
                            <span>
                                <i class="fa fa-calendar-alt fa-sm"></i>
                                13.12.2022
                            </span>
                            <a href="#">
                                <h6 class="text-dark">How we handle shipping</h6>
                            </a>
                            <p>When you enter into any new area of science, you almost reach</p>
                        </div>
                    </article>
                </div>
                <!-- col.// -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <article>
                        <a href="#" class="img-fluid">
                            <img class="rounded w-100"
                                src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/posts/3.webp"
                                style="object-fit: cover;" height="160" />
                        </a>
                        <div class="mt-2 text-muted small d-block mb-1">
                            <span>
                                <i class="fa fa-calendar-alt fa-sm"></i>
                                25.11.2022
                            </span>
                            <a href="#">
                                <h6 class="text-dark">How to promote brands</h6>
                            </a>
                            <p>When you enter into any new area of science, you almost reach</p>
                        </div>
                    </article>
                </div>
                <!-- col.// -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <article>
                        <a href="#" class="img-fluid">
                            <img class="rounded w-100"
                                src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/posts/4.webp"
                                style="object-fit: cover;" height="160" />
                        </a>
                        <div class="mt-2 text-muted small d-block mb-1">
                            <span>
                                <i class="fa fa-calendar-alt fa-sm"></i>
                                03.09.2022
                            </span>
                            <a href="#">
                                <h6 class="text-dark">Success story of sellers</h6>
                            </a>
                            <p>When you enter into any new area of science, you almost reach</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog -->
@endsection

@push('custom-script')
    <script>
        $(document).ready(function() {
            var itemsPerPage = 5; // Số hàng hiển thị trên mỗi trang
            var currentPage = 1; // Trang hiện tại

            // Xác định tổng số trang dựa trên số hàng và số hàng trên mỗi trang
            var totalPage = Math.ceil($('table tbody tr').length / itemsPerPage);

            // Hiển thị trang đầu tiên
            showPage(currentPage);

            // Xử lý khi nhấp vào nút trang trước
            $('.page-link[aria-label="Previous"]').click(function() {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                }
            });

            // Xử lý khi nhấp vào nút trang tiếp theo
            $('.page-link[aria-label="Next"]').click(function() {
                if (currentPage < totalPage) {
                    currentPage++;
                    showPage(currentPage);
                }
            });

            // Xử lý khi nhấp vào một trang cụ thể
            $('.page-link:not([aria-label="Previous"]):not([aria-label="Next"])').click(function() {
                currentPage = parseInt($(this).text());
                showPage(currentPage);
            });

            // Hàm để hiển thị các hàng trên trang hiện tại
            function showPage(pageNumber) {
                $('table tbody tr').hide();
                var startIndex = (pageNumber - 1) * itemsPerPage;
                var endIndex = startIndex + itemsPerPage;
                $('table tbody tr').slice(startIndex, endIndex).show();
                updatePagination();
            }

            // Hàm để cập nhật giao diện phân trang
            function updatePagination() {
                $('.page-item').removeClass('active');
                $('.page-item:contains(' + currentPage + ')').addClass('active');
            }
        });

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
            // Bắt sự kiện khi nút được bấm
            $('#test-alert').on('click', function() {
                // Hiển thị thông báo với lớp CSS tùy chỉnh
                alertify.success('success', {
                    'cssClass': 'ajs-success'
                });
                alertify.warning('warning', {
                    'cssClass': 'ajs-warning'
                });
                alertify.error('error', {
                    'cssClass': 'ajs-error'
                });
            });
        });
    </script>
@endpush
