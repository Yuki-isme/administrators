@extends('frontend.layout.layout')

@section('content')
    <!-- sidebar + content -->
    <section class="">
        <div class="container">
            <div class="row">
                <!-- sidebar -->
                <div class="col-lg-3">
                    <!-- Toggle button -->
                    <button class="btn btn-outline-secondary mb-3 w-100 d-lg-none" type="button" data-mdb-toggle="collapse"
                        data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span>Show filter</span>
                    </button>
                    <!-- Collapsible wrapper -->
                    <div class="collapse card d-lg-block mb-5" id="navbarSupportedContent">
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            {{-- <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button text-dark bg-light" type="button"
                                        data-mdb-toggle="collapse" data-mdb-target="#panelsStayOpen-collapseOne"
                                        aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        Related items
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne">
                                    <div class="accordion-body">
                                        <ul class="list-unstyled">
                                            <li><a href="#" class="text-dark">Electronics </a></li>
                                            <li><a href="#" class="text-dark">Home items </a></li>
                                            <li><a href="#" class="text-dark">Books, Magazines </a></li>
                                            <li><a href="#" class="text-dark">Men's clothing </a></li>
                                            <li><a href="#" class="text-dark">Interiors items </a></li>
                                            <li><a href="#" class="text-dark">Underwears </a></li>
                                            <li><a href="#" class="text-dark">Shoes for men </a></li>
                                            <li><a href="#" class="text-dark">Accessories </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCategory">
                                    <button class="accordion-button text-dark bg-light" type="button"
                                        data-mdb-toggle="collapse" data-mdb-target="#panelsStayOpen-collapseCategory"
                                        aria-expanded="true" aria-controls="panelsStayOpen-collapseCategory">
                                        Categories
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseCategory" class="accordion-collapse collapse show"
                                    aria-labelledby="headingCategory">
                                    <div class="accordion-body">
                                        <div>
                                            <!-- Checked checkbox -->
                                            @foreach ($categories as $index => $category)
                                                <div class="form-check {{ $index >= 5 ? 'hidden-category' : '' }}">
                                                    <input class="form-check-input category-checkbox" type="checkbox"
                                                        {{ isset($category_check) && $category_check == $category->id ? 'checked' : '' }}
                                                        value="{{ $category->id }}"
                                                        id="flexCheckChecked{{ $index + 1 }}" />
                                                    <label class="form-check-label"
                                                        for="flexCheckChecked{{ $index + 1 }}">{{ $category->name }}</label>
                                                </div>
                                            @endforeach
                                            @if (count($categories) > 5)
                                                <div id="showAllCategories" class="show-all-categories">
                                                    <label class="form-check-label" id="allCategoriesLabel">All
                                                        Categories</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button text-dark bg-light" type="button"
                                        data-mdb-toggle="collapse" data-mdb-target="#panelsStayOpen-collapseTwo"
                                        aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                                        Brands
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show"
                                    aria-labelledby="headingTwo">
                                    <div class="accordion-body">
                                        <div>
                                            <!-- Default checkbox -->
                                            @foreach ($brands as $index => $brand)
                                                <div class="form-check {{ $index >= 5 ? 'hidden-brand' : '' }}">
                                                    <input class="form-check-input brand-checkbox" type="checkbox"
                                                        {{ isset($brand_check) && $brand_check == $brand->id ? 'checked' : '' }}
                                                        value="{{ $brand->id }}"
                                                        id="flexCheckDefault{{ $index + 1 }}" />
                                                    <label class="form-check-label"
                                                        for="flexCheckDefault{{ $index + 1 }}">{{ $brand->name }}</label>
                                                </div>
                                            @endforeach
                                            @if (count($brands) > 5)
                                                <div id="showAllBrands" class="show-all-brands">
                                                    <label class="form-check-label">All Brands</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <span class="badge badge-secondary float-end">30</span> --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button text-dark bg-light" type="button"
                                        data-mdb-toggle="collapse" data-mdb-target="#panelsStayOpen-collapseThree"
                                        aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        Price
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show"
                                    aria-labelledby="headingThree">
                                    <div class="accordion-body">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <p class="mb-0">
                                                    Min
                                                </p>
                                                <div class="form-outline">
                                                    <input type="number" id="minPrice" class="form-control" />
                                                    <label class="form-label" for="minPrice">VND</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-0">
                                                    Max
                                                </p>
                                                <div class="form-outline">
                                                    <input type="number" id="maxPrice" class="form-control" />
                                                    <label class="form-label" for="maxPrice">VND</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button text-dark bg-light" type="button"
                                        data-mdb-toggle="collapse" data-mdb-target="#panelsStayOpen-collapseFour"
                                        aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                                        Size
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show"
                                    aria-labelledby="headingThree">
                                    <div class="accordion-body">
                                        <input type="checkbox" class="btn-check border justify-content-center"
                                            id="btn-check1" checked autocomplete="off" />
                                        <label class="btn btn-white mb-1 px-1" style="width: 60px;"
                                            for="btn-check1">XS</label>
                                        <input type="checkbox" class="btn-check border justify-content-center"
                                            id="btn-check2" checked autocomplete="off" />
                                        <label class="btn btn-white mb-1 px-1" style="width: 60px;"
                                            for="btn-check2">SM</label>
                                        <input type="checkbox" class="btn-check border justify-content-center"
                                            id="btn-check3" checked autocomplete="off" />
                                        <label class="btn btn-white mb-1 px-1" style="width: 60px;"
                                            for="btn-check3">LG</label>
                                        <input type="checkbox" class="btn-check border justify-content-center"
                                            id="btn-check4" checked autocomplete="off" />
                                        <label class="btn btn-white mb-1 px-1" style="width: 60px;"
                                            for="btn-check4">XXL</label>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button text-dark bg-light" type="button"
                                        data-mdb-toggle="collapse" data-mdb-target="#panelsStayOpen-collapseFive"
                                        aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
                                        Ratings
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse show"
                                    aria-labelledby="headingThree">
                                    <div class="accordion-body">
                                        <!-- Default checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault" checked />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <i class="fas fa-star text-warning"></i><i
                                                    class="fas fa-star text-warning"></i><i
                                                    class="fas fa-star text-warning"></i><i
                                                    class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-warning"></i>
                                            </label>
                                        </div>
                                        <!-- Default checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault" checked />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <i class="fas fa-star text-warning"></i><i
                                                    class="fas fa-star text-warning"></i><i
                                                    class="fas fa-star text-warning"></i><i
                                                    class="fas fa-star text-warning"></i>
                                                <i class="fas fa-star text-secondary"></i>
                                            </label>
                                        </div>
                                        <!-- Default checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault" checked />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <i class="fas fa-star text-warning"></i><i
                                                    class="fas fa-star text-warning"></i><i
                                                    class="fas fa-star text-warning"></i><i
                                                    class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-secondary"></i>
                                            </label>
                                        </div>
                                        <!-- Default checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault" checked />
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <i class="fas fa-star text-warning"></i><i
                                                    class="fas fa-star text-warning"></i><i
                                                    class="fas fa-star text-secondary"></i><i
                                                    class="fas fa-star text-secondary"></i>
                                                <i class="fas fa-star text-secondary"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <!-- sidebar -->
                <!-- content -->

                <div class="col-lg-9">

                    <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
                        <strong class="d-block py-2"
                            id="countProduct">{{ $count = isset($products) ? count($products) : 0 }} Items found
                        </strong>
                        <div class="ms-auto">
                            <select id="sortProduct" class="form-select d-inline-block w-auto border pt-1">
                                <option value="price_asc">Prices ascending</option>
                                <option value="price_desc">Prices descending</option>
                                <option value="latest">Latest</option> <!-- Thêm lựa chọn Latest -->
                                <option value="oldest">Oldest</option>
                            </select>
                        </div>
                    </header>
                    <div id="products-pagination">
                        <div id="products-container">
                            @foreach ($products as $product)
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
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('custom-script')
    <script>
        const itemsPerPage = 5;
        var globalTotalPage = Math.ceil({{$count}}/itemsPerPage);

        function initializePagination() {
            
            let currentPage = 1; // Trang hiện tại mặc định
            const totalPages = globalTotalPage;
            const maxVisiblePages = 7; // Số trang tối đa hiển thị

            // Hiển thị ban đầu chỉ 1 sản phẩm đầu tiên
            $('.product').hide();
            $('.product:lt('+ itemsPerPage +')').show();

            // Tạo danh sách các trang
            function generatePageNumbers(currentPage) {
                const pages = [];
                for (let i = 1; i <= totalPages; i++) {
                    pages.push(i);
                }

                if (totalPages <= maxVisiblePages) {
                    return pages; // Nếu tổng số trang ít hơn hoặc bằng maxVisiblePages, hiển thị tất cả.
                } else if (currentPage <= Math.ceil(maxVisiblePages / 2)) {
                    return pages.slice(0, maxVisiblePages); // Ở đầu danh sách, hiển thị 7 trang đầu.
                } else if (currentPage >= totalPages - Math.floor(maxVisiblePages / 2)) {
                    return pages.slice(totalPages - maxVisiblePages); // Ở cuối danh sách, hiển thị 7 trang cuối.
                } else {
                    return pages.slice(currentPage - Math.floor(maxVisiblePages / 2) - 1, currentPage + Math.floor(
                        maxVisiblePages / 2)); // Hiển thị 7 trang xung quanh trang hiện tại.
                }
            }

            function updatePagination(currentPage) {
                const pages = generatePageNumbers(currentPage);
                const paginationList = $('#pagination .pagination');
                const prevButton = $('#pagination .page-link.prev-page-link');
                const nextButton = $('#pagination .page-link.next-page-link');
                const firstButton = $('#pagination .page-link.first-page-link');
                const lastButton = $('#pagination .page-link.last-page-link');

                paginationList.empty();

                // Nút "First"
                if (currentPage > 1) {
                    paginationList.append(`
                <li class="page-item">
                    <a class="page-link first-page-link" href="#" aria-label="First" data-page="1">
                        <span aria-hidden="true">&laquo;&laquo;</span>
                    </a>
                </li>
            `);
                } else {
                    paginationList.append(`
                <li class="page-item disabled">
                    <span class="page-link">&laquo;&laquo;</span>
                </li>
            `);
                }

                // Nút "Previous"
                if (currentPage > 1) {
                    paginationList.append(`
                <li class="page-item">
                    <a class="page-link prev-page-link" href="#" aria-label="Previous" data-page="${currentPage - 1}">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            `);
                } else {
                    paginationList.append(`
                <li class="page-item disabled">
                    <span class="page-link">&laquo;</span>
                </li>
            `);
                }

                pages.forEach((page) => {
                    const activeClass = currentPage === page ? 'active' : '';
                    paginationList.append(`
                <li class="page-item ${activeClass}">
                    <a class="page-link" href="#" data-page="${page}">${page}</a>
                </li>
            `);
                });

                // Nút "Next"
                if (currentPage < totalPages) {
                    paginationList.append(`
                <li class="page-item">
                    <a class="page-link next-page-link" href="#" aria-label="Next" data-page="${currentPage + 1}">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            `);
                } else {
                    paginationList.append(`
                <li class="page-item disabled">
                    <span class="page-link">&raquo;</span>
                </li>
            `);
                }

                // Nút "Last"
                if (currentPage < totalPages) {
                    paginationList.append(`
                <li class="page-item">
                    <a class="page-link last-page-link" href="#" aria-label="Last" data-page="${totalPages}">
                        <span aria-hidden="true">&raquo;&raquo;</span>
                    </a>
                </li>
            `);
                } else {
                    paginationList.append(`
                <li class="page-item disabled">
                    <span class="page-link">&raquo;&raquo;</span>
                </li>
            `);
                }

                // Sự kiện khi bấm vào số trang
                $('#pagination .page-link').on('click', function(e) {
                    e.preventDefault();
                    const page = $(this).data('page');
                    const start = (page - 1) * itemsPerPage;
                    const end = start + itemsPerPage;

                    // Ẩn tất cả sản phẩm và hiển thị các sản phẩm thuộc trang đã chọn
                    $('.product').hide();
                    $('.product').slice(start, end).show();

                    // Cập nhật trang hiện tại và thanh phân trang
                    currentPage = page;
                    updatePagination(currentPage);
                });
            }

            // Mặc định hiển thị trang đầu tiên
            updatePagination(1);
        }

        // Gọi hàm để khởi tạo lại phân trang sau khi cập nhật danh sách sản phẩm
        initializePagination();

        $(document).ready(function() {
            // Ẩn danh sách category và brand ban đầu
            $(".hidden-category").hide();
            $(".hidden-brand").hide();

            // Biến để theo dõi category và brand hiện tại được chọn
            var selectedCategory = $('.category-checkbox:checked').val() || null;
            var selectedBrand = $('.brand-checkbox:checked').val() || null;

            var minPrice = parseFloat($("#minPrice").val()) || null;
            var maxPrice = parseFloat($("#maxPrice").val()) || null;

            var selectedSortOption = $("#sortProduct").val();

            // Function để gửi AJAX request với category và brand, min và max
            function sendAjaxRequest() {
                $.ajax({
                    url: "{{ route('listByCategoryBrand') }}",
                    type: "POST",
                    data: {
                        category_id: selectedCategory,
                        brand_id: selectedBrand,
                        min_price: minPrice,
                        max_price: maxPrice,
                        sort_option: selectedSortOption,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        // Xử lý phản hồi từ máy chủ (cập nhật danh sách sản phẩm, vv.)
                        //console.log(response.sort_option);
                        $('#countProduct').text(response.count + ' Items found');
                        $("#products-pagination").html(response.html);
                        globalTotalPage = Math.ceil(response.count / itemsPerPage);
                        initializePagination();


                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            // Xử lý sự kiện khi checkbox category thay đổi trạng thái
            $(".category-checkbox").change(function() {
                var newCategory = $(this).prop("checked") ? $(this).val() : null;

                // Kiểm tra xem đã chọn category khác hoặc bỏ chọn category hiện tại
                if (newCategory !== selectedCategory) {
                    selectedCategory = newCategory;
                    // Hủy chọn tất cả các checkbox category khác
                    $(".category-checkbox").not(this).prop("checked", false);
                    sendAjaxRequest();
                }
            });

            // Xử lý sự kiện khi checkbox brand thay đổi trạng thái
            $(".brand-checkbox").change(function() {
                var newBrand = $(this).prop("checked") ? $(this).val() : null;

                // Kiểm tra xem đã chọn brand khác hoặc bỏ chọn brand hiện tại
                if (newBrand !== selectedBrand) {
                    selectedBrand = newBrand;
                    // Hủy chọn tất cả các checkbox brand khác
                    $(".brand-checkbox").not(this).prop("checked", false);
                    sendAjaxRequest();
                }
            });

            $("#minPrice, #maxPrice").change(function() {
                // Lấy giá trị của min và max
                minPrice = parseFloat($("#minPrice").val()) || null;
                maxPrice = parseFloat($("#maxPrice").val()) || null;

                // Kiểm tra xem max > min
                if (maxPrice > minPrice) {
                    // Gửi AJAX request với min và max
                    sendAjaxRequest();
                }
            });

            // Sự kiện khi select box thay đổi lựa chọn
            $("#sortProduct").change(function() {
                var newSortOption = $(this).val();

                // Kiểm tra xem đã thay đổi lựa chọn sắp xếp
                if (newSortOption !== selectedSortOption) {
                    selectedSortOption = newSortOption;
                    // Gửi AJAX request với lựa chọn sắp xếp mới
                    sendAjaxRequest();
                }
            });

            // Xử lý sự kiện khi nhấn vào "All Categories"
            $("#showAllCategories").click(function() {

                $(".hidden-category").toggle();
                // Cập nhật nội dung của label
                var allCategoriesLabel = $("#allCategoriesLabel");
                if (allCategoriesLabel.text() === "All Categories") {
                    allCategoriesLabel.text("Shortlist");
                } else {
                    allCategoriesLabel.text("All Categories");
                }

            });

            // Xử lý sự kiện khi nhấn vào "All Brands"
            $("#showAllBrands").click(function() {

                $(".hidden-brand").toggle();
                // Cập nhật nội dung của label
                var allBrandsLabel = $("#allBrandsLabel");
                if (allBrandsLabel.text() === "All Brands") {
                    allBrandsLabel.text("Shortlist");
                } else {
                    allBrandsLabel.text("All Brands");
                }
            });
        });
    </script>
@endpush
