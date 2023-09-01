@extends('frontend.layout.layout')

@section('content')
    <!-- content -->
    <section class="py-5">
        <div class="container">
            <div class="row gx-5">
                <aside class="col-lg-6" style="height: 600px;">
                    <div class="border rounded-4 mb-3 d-flex justify-content-center main-img" style="height: 400px;">
                        <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="img-feature"
                            src="{{ asset('storage/' . $productDetail->thumbnail->url) }}" />
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <div class="list-image">
                            <span>
                                <img width="60" height="60"
                                    src="{{ asset('storage/' . $productDetail->thumbnail->url) }}"
                                    class="thumbnail selected" />
                            </span>
                            @foreach ($productDetail->media as $media)
                                <span>
                                    <img width="60" height="60" src="{{ asset('storage/' . $media->url) }}"
                                        class="thumbnail" />
                                </span>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <main class="col-lg-6">
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

                            <div class="text-muted"> <i class="fas fa-shopping-basket fa-sm mx-1"> </i>154 orders</div>
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
                                <label class="mb-2 d-block">Quantity</label>
                                <div class="input-group mb-3" style="width: 170px;">
                                    <button class="btn btn-white border border-secondary px-3" type="button"
                                        id="button-addon1" data-mdb-ripple-color="dark">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="text" class="form-control text-center border border-secondary"
                                        aria-label="Example text with button addon" aria-describedby="button-addon1"
                                        max="{{ $productDetail->stock }}" min="1" id="quantityInput" value="1"
                                        inputmode="numeric" pattern="[0-9]*" />
                                    <button class="btn btn-white border border-secondary px-3" type="button"
                                        id="button-addon2" data-mdb-ripple-color="dark">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-warning shadow-0"> Buy now </a>
                        <a href="#" class="btn btn-primary shadow-0"> <i class="me-1 fa fa-shopping-basket"></i>
                            Add to cart </a>
                        <a href="#" class="btn btn-light border border-secondary py-2 icon-hover px-3"> <i
                                class="me-1 fa fa-heart fa-lg"></i> Save </a>
                    </div>
                </main>
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
                                <div class="d-flex mb-3">
                                    <a href="#" class="me-3">
                                        <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/8.webp"
                                            style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                    </a>
                                    <div class="info">
                                        <a href="#" class="nav-link mb-1">
                                            Rucksack Backpack Large <br />
                                            Line Mounts
                                        </a>
                                        <strong class="text-dark"> $38.90</strong>
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <a href="#" class="me-3">
                                        <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/9.webp"
                                            style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                    </a>
                                    <div class="info">
                                        <a href="#" class="nav-link mb-1">
                                            Summer New Men's Denim <br />
                                            Jeans Shorts
                                        </a>
                                        <strong class="text-dark"> $29.50</strong>
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <a href="#" class="me-3">
                                        <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/10.webp"
                                            style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                    </a>
                                    <div class="info">
                                        <a href="#" class="nav-link mb-1"> T-shirts with multiple colors, for men
                                            and lady </a>
                                        <strong class="text-dark"> $120.00</strong>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <a href="#" class="me-3">
                                        <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/11.webp"
                                            style="min-width: 96px; height: 96px;" class="img-md img-thumbnail" />
                                    </a>
                                    <div class="info">
                                        <a href="#" class="nav-link mb-1"> Blazer Suit Dress Jacket for Men, Blue
                                            color </a>
                                        <strong class="text-dark"> $339.90</strong>
                                    </div>
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
            var imgFeature = $('.img-feature');
            var listImg = $('.list-image img');

            listImg.on('click', function(e) {
                // Loại bỏ lớp CSS 'selected' cho tất cả các ảnh
                listImg.removeClass('selected');

                // Thêm lớp CSS 'selected' cho ảnh được chọn
                $(this).addClass('selected');

                imgFeature.attr('src', $(this).attr('src'));
            });
        });

        $(document).ready(function() {
            const quantityInput = $("#quantityInput");
            const maxStock = parseInt(quantityInput.attr("max"));

            // Xử lý sự kiện khi người dùng thay đổi giá trị input
            quantityInput.on("input", function() {
                let currentValue = parseInt(quantityInput.val());

                // Kiểm tra nếu giá trị nhập vào lớn hơn giới hạn (stock)
                if (currentValue > maxStock) {
                    // Thiết lập giá trị nhập vào bằng giới hạn
                    quantityInput.val(maxStock);
                } else if (currentValue < 1) {
                    // Kiểm tra nếu giá trị nhập vào nhỏ hơn 1
                    // Thiết lập giá trị nhập vào bằng 1
                    quantityInput.val(1);
                }
            });

            // Xử lý sự kiện khi nhấn nút tăng (+)
            $("#button-addon2").on("click", function() {
                // Lấy giá trị hiện tại của input
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
                // Lấy giá trị hiện tại của input
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
