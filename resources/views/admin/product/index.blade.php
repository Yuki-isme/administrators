@extends('admin.layout.layout')

@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product list</h4>
                    <h6>Manage your product</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('products.create') }}" class="btn btn-added">
                        <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add product
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success" id="alert">
                    {{ session('success') }}
                    <button type="button" class="close-alert" id="close-alert"
                        style="position: absolute; top: 50%; right: 0; transform: translateY(-50%);">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif (session('alert'))
                <div class="alert alert-danger" id="alert">
                    {{ session('alert') }}
                    <button type="button" class="close-alert" id="close-alert"
                        style="position: absolute; top: 50%; right: 0; transform: translateY(-50%);">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger" id="alert" style="position: relative;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close-alert" id="close-alert"
                        style="position: absolute; top: 50%; right: 0; transform: translateY(-50%);">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            {{-- <div class="search-path">
                                <a class="btn btn-filter" id="filter_search">
                                    <img src="{{ asset('admin/assets/img/icons/filter.svg') }}" alt="img">
                                    <span><img src="{{ asset('admin/assets/img/icons/closes.svg') }}" alt="img"></span>
                                </a>
                            </div> --}}
                            <div class="search-input">
                                <a class="btn btn-searchset"><img
                                        src="{{ asset('admin/assets/img/icons/search-white.svg') }}" alt="img"></a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    {{-- <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"> --}}
                                        <img src="{{ asset('admin/assets/img/icons/pdf.svg') }}" alt="img">
                                    {{-- </a> --}}
                                </li>
                                <li>
                                    {{-- <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"> --}}
                                        <img src="{{ asset('admin/assets/img/icons/excel.svg') }}" alt="img">
                                    {{-- </a> --}}
                                </li>
                                <li>
                                    {{-- <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"> --}}
                                        <img src="{{ asset('admin/assets/img/icons/printer.svg') }}" alt="img">
                                    {{-- </a> --}}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter product Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter product Description">
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                    <div class="form-group">
                                        <a class="btn btn-filters ms-auto"><img
                                                src="{{ asset('admin/assets/img/icons/search-whites.svg') }}"
                                                alt="img"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Product name</th>
                                    <th>SKU</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Sale Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Create At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td class="productimgname">
                                            <a href="{{ route('products.show', ['id' => $product->id]) }}" class="product-img">
                                                <img src="{{ asset('storage/' . $product->thumbnail->url) }}"
                                                    alt="product">
                                            </a>
                                            <a href="{{ route('products.show', ['id' => $product->id]) }}">{{ $product->name }}</a>
                                        </td>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->brand->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->sale_price }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            <a href="{{ route('products.update', ['id' => $product->id]) }}"
                                                data-visbility="{{ $product->is_active }}" class="change-status">
                                                @if ($product->is_active)
                                                    <i class="ion-checkmark-round" data-bs-toggle="tooltip"
                                                        aria-label="ion-checkmark-round"
                                                        data-bs-original-title="ion-checkmark-round"></i>
                                                @else
                                                    <i class="ion-close-round" data-bs-toggle="tooltip"
                                                        aria-label="ion-close-round"
                                                        data-bs-original-title="ion-close-round"></i>
                                                @endif
                                            </a>
                                        </td>
                                        <td>{{ $product->created_at->format('H:i:s d/m/Y') }}</td>
                                        <td>
                                            <a class="me-3"
                                                href="{{ route('products.show', ['id' => $product->id]) }}">
                                                <img src="{{ asset('admin/assets/img/icons/eye.svg') }}" alt="img">
                                            </a>
                                            <a class="me-3"
                                                href="{{ route('products.edit', ['id' => $product->id]) }}">
                                                <img src="{{ asset('admin/assets/img/icons/edit.svg') }}" alt="img">
                                            </a>

                                            <a
                                                href="#"onclick="event.preventDefault(); deleteproduct('{{ route('products.destroy', ['id' => $product->id]) }}')">
                                                <img src="{{ asset('admin/assets/img/icons/delete.svg') }}"
                                                    alt="img">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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

        //change status active
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

        //delete product
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
