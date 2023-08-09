@extends('admin.layout.layout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Details</h4>
                    <h6>Full details of a product</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="bar-code-view">
                                <img src="{{ asset('admin/assets/img/barcode1.png') }}" alt="barcode">
                                <a class="printimg">
                                    <img src="{{ asset('admin/assets/img/icons/printer.svg') }}" alt="print">
                                </a>
                            </div>
                            <div class="productdetails">
                                <ul class="product-bar">
                                    <li>
                                        <h4>Product</h4>
                                        <h6>{{ $product->name }}</h6>
                                    </li>
                                    <li>
                                        <h4>Slug</h4>
                                        <h6>{{ $product->slug }}</h6>
                                    </li>
                                    <li>
                                        <h4>Category</h4>
                                        <h6>{{ $product->category->parent->name }}</h6>
                                    </li>
                                    <li>
                                        <h4>Sub Category</h4>
                                        <h6>{{ $product->category->name }}</h6>
                                    </li>
                                    <li>
                                        <h4>Brand</h4>
                                        <h6>{{ $product->brand->name }}</h6>
                                    </li>
                                    <li>
                                        <h4>Unit</h4>
                                        <h6>Piece</h6>
                                    </li>
                                    <li>
                                        <h4>SKU</h4>
                                        <h6>PT0001</h6>
                                    </li>
                                    <li>
                                        <h4>Minimum Qty</h4>
                                        <h6>5</h6>
                                    </li>
                                    <li>
                                        <h4>Quantity</h4>
                                        <h6>50</h6>
                                    </li>
                                    <li>
                                        <h4>Tax</h4>
                                        <h6>0.00 %</h6>
                                    </li>
                                    <li>
                                        <h4>Discount Type</h4>
                                        <h6>Percentage</h6>
                                    </li>
                                    <li>
                                        <h4>Price</h4>
                                        <h6>1500.00</h6>
                                    </li>
                                    <li>
                                        <h4>Status</h4>
                                        <h6>Active</h6>
                                    </li>
                                    <li>
                                        <h4>Description</h4>
                                        <h6>{{ $product->description }}</h6>
                                    </li>
                                    <li>
                                        <h4>Content</h4>
                                        <h6>{{ $product->content }}</h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="slider-product-details">
                                <div class="owl-carousel owl-theme product-slide">
                                    <div class="slider-product">
                                        <img src="{{ asset('admin/assets/img/product/product69.jpg') }}" alt="img">
                                        <h4>macbookpro.jpg</h4>
                                        <h6>581kb</h6>
                                    </div>
                                    <div class="slider-product">
                                        <img src="{{ asset('admin/assets/img/product/product69.jpg') }}" alt="img">
                                        <h4>macbookpro.jpg</h4>
                                        <h6>581kb</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <form action="" method="post" id="delete-form">
        @csrf
        @method('delete')
    </form>
@endsection

@push('custom-script')
    <script>
        $(document).ready(function() {

            $('#close-alert').on('click', function() {
                $('#alert').hide();
            });
        });

        $(document).ready(function() {
            $('.change-status').on('click', function(e) {
                e.preventDefault();
                const statusIcon = [
                    '<i class="ion-close-round" data-bs-toggle="tooltip" aria-label="ion-close-round" data-bs-original-title="ion-close-round"></i>',
                    '<i class="ion-checkmark-round" data-bs-toggle="tooltip" aria-label="ion-checkmark-round" data-bs-original-title="ion-checkmark-round"></i>'
                ]
                let url = $(this).attr('href')
                let is_active = $(this).attr('data-visbility');
                let _this = $(this)
                $.ajax({
                    type: 'PUT',
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_active: is_active == 1 ? '0' : 1,
                    },
                    dataType: 'json',

                    success: function(data) {
                        console.log(_this)
                        _this.attr('data-visbility', data.is_active);
                        _this.empty();
                        _this.html(statusIcon[data.is_active]);
                    },
                    error: function(data) {
                        console.log(data, 1)
                    }
                });
            });
        });

        function deleteproduct(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set the correct action for the delete form using jQuery
                    $('#delete-form').attr('action', url);
                    $('#delete-form').submit();
                }
            });
        }
    </script>
@endpush
