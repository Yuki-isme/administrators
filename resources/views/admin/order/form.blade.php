@extends('admin.layout.layout')

@section('content')

    <div class="page-wrapper">

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product {{ isset($order) ? 'Edit' : 'Add' }} Order</h4>
                    <h6>{{ isset($order) ? 'Edit' : 'Add' }} Order</h6>
                </div>
            </div>

            @if ($errors->any())
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
                    <form method="post"
                        action="{{ isset($order) ? route('orders.update', $order->id) : route('orders.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @isset($order)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ $order->name ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone_number" value="{{ $order->phone_number ?? '' }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" value="{{ $order->email ?? '' }}" required>
                                </div>
                            </div>


                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select name="payment_method" class="disabled-results form-control form-small">
                                        <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
                                        <option value="Thanh toán qua VN Pay">Thanh toán qua VN Pay</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <select name="payment_status" class="disabled-results form-control form-small">
                                        <option value="Chưa thanh toán">Chưa thanh toán</option>
                                        <option value="Đã thanh toán">Đã thanh toán</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status_id" class="disabled-results form-control form-small">
                                        @foreach ($statuses as $status)
                                            @php
                                                if (isset($order)) {
                                                    $isDisabled = in_array($status->id, $statusDisabledMap[$order->status_id]);
                                                }
                                            @endphp

                                            <option value="{{ $status->id }}"
                                                {{ isset($order) ? ($status->id == $order->status_id ? 'selected' : '') : '' }}
                                                {{ isset($order) ? ($isDisabled ? 'disabled' : '') : '' }}>
                                                {{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Province</label>
                                    <select id="province_id" name="province_code"
                                        class="disabled-results form-control form-small">
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->code }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>District</label>
                                    <select id="district_id" name="district_code"
                                        class="disabled-results form-control form-small">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Ward</label>
                                    <select id="ward_id" name="ward_code"
                                        class="disabled-results form-control form-small">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Street</label>
                                    <input type="text" name="street" value="{{ $order->street ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>House Number</label>
                                    <input type="text" name="house" value="{{ $order->house ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea class="form-control" name="note">{{ $order->note ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Note Oder</label>
                                    <textarea class="form-control" name="note_order">{{ $order->note_oder ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Add Product</label>
                                    <select id="add_product" class="disabled-results form-control form-small"
                                        name="products[]" multiple>
                                        @if (isset($order->items))
                                            @foreach ($order->items as $item)
                                                <option value="{{ $item->product_id }}" selected>
                                                    {{ $item->product_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12" id="table-update">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product name</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                            @if (isset($order))
                                                <th>Price Order</th>
                                                <th>Discount Order</th>
                                            @endif
                                            <th>Amount</th>
                                            <th>Total</th>
                                            <th>Total discount</th>
                                            @if (isset($order))
                                                <th>Total Order</th>
                                                <th>Total Discount Order</th>
                                            @endif
                                            <th>Last Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($order->items))
                                            @php
                                                $sumTotal = 0;
                                            @endphp
                                            @foreach ($order->items as $item)
                                                <tr id="product-{{ $item->product_id }}">
                                                    <td class="productimgname">
                                                        <a
                                                            href="{{ route('products.show', ['id' => $item->product_id]) }}"class="product-img"><img
                                                                src="{{ asset('storage/' . $item->product->thumbnail->url) }}"alt="product"></a>
                                                        <a
                                                            href="{{ route('products.show', ['id' => $item->product_id]) }}">{{ $item->product_name }}</a>
                                                    </td>
                                                    <td>{{ number_format($item->product->price, 0, ',', '.') }}
                                                    </td>
                                                    <td>{{ number_format($item->product->price - $item->product->cart_price, 0, ',', '.') }}
                                                    </td>
                                                    @if (isset($order))
                                                        <td>{{ number_format($item->price + $item->discount, 0, ',', '.') }}
                                                        </td>
                                                        <td>{{ number_format($item->discount, 0, ',', '.') }}</td>
                                                    @endif
                                                    <td>
                                                        <select
                                                            class="disabled-results form-control form-small product-amount"
                                                            name="amounts[]" data-product-id="{{ $item->product_id }}"
                                                            data-price="{{ $item->product->price }}"
                                                            data-discount="{{ $item->product->price - $item->product->cart_price }}"
                                                            data-amount-order="{{ $item->amount }}"
                                                            data-price-order="{{ $item->price }}"
                                                            data-discount-order="{{ $item->discount }}">
                                                            @if ($item->product->stock > 0)
                                                                @for ($i = 1; $i <= $item->product->stock + $item->amount; $i++)
                                                                    <option value="{{ $i }}"
                                                                        {{ $i == $item->amount ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            @else
                                                                @for ($i = 1; $i <= $item->amount; $i++)
                                                                    <option value="{{ $i }}"
                                                                        {{ $i == $item->amount ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td class="total-price">
                                                        0
                                                    </td>
                                                    <td class="total-discount">
                                                        0
                                                    </td>
                                                    @if (isset($order))
                                                        <td class="total-price-order">
                                                            {{ number_format($item->price * $item->amount + $item->discount * $item->amount, 0, ',', '.') }}
                                                        </td>
                                                        <td class="total-discount-order">
                                                            {{ number_format($item->discount * $item->amount, 0, ',', '.') }}
                                                        </td>
                                                    @endif
                                                    @php
                                                        $sumTotal += $item->price * $item->amount;
                                                    @endphp
                                                    <td class="last-total">
                                                        {{ number_format($item->price * $item->amount, 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        <a
                                                            class="me-3"href="{{ route('products.show', ['id' => $item->product_id]) }}">
                                                            <img
                                                                src="{{ asset('admin/assets/img/icons/eye.svg') }}"alt="img"></a>
                                                        <a href="#" class="delete-product"
                                                            data-product-id="{{ $item->product_id }}"><img
                                                                src="{{ asset('admin/assets/img/icons/delete.svg') }}"alt="img"></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="{{ $order ? 10 : 6 }}" style="font-weight: bold;">Sum</td>
                                            <td id="sum-total">{{ number_format($sumTotal, 0, ',', '.') }}</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-12" style="margin-top: 2%">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-submit me-2" value="Submit">
                                    <a href="{{ route('orders.index') }}" class="btn btn-cancel">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script>
        $(document).ready(function() {

            $('#close-alert').on('click', function() {
                $('#alert').hide();
            });
        });

        $(document).ready(function() {
            $('select.select2').select2();

            // Lấy mã quận/huyện từ bảng info (nếu có).
            var userDistrictCode = '{{ $order->district_code ?? '' }}';
            var userDistrict = '{{ $order->district->name ?? '' }}';

            // Thiết lập Select2 cho quận/huyện
            $('#district_id').select2({
                ajax: {
                    url: '{{ route('getDistricts') }}',
                    data: function(params) {
                        var query = {
                            term: params.term,
                            province_code: $('#province_id').val(),
                            _token: '{{ csrf_token() }}'
                        };

                        return query;
                    },
                    dataType: 'json',
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.code,
                                    text: item.name
                                };
                            })
                        };
                    }
                }
            });

            // Thiết lập giá trị mặc định cho quận/huyện nếu có dữ liệu từ info.
            if (userDistrictCode) {
                $('#district_id').append('<option value="' + userDistrictCode + '">' + userDistrict + '</option>');
            }

            // Lấy mã xã/phường từ bảng info (nếu có).
            var userWardCode = '{{ $order->ward_code ?? '' }}';
            var userWard = '{{ $order->ward->name ?? '' }}';

            // Thiết lập Select2 cho xã/phường
            $('#ward_id').select2({
                ajax: {
                    url: '{{ route('getWards') }}',
                    data: function(params) {
                        var query = {
                            term: params.term,
                            district_code: $('#district_id').val(),
                            _token: '{{ csrf_token() }}'
                        };

                        return query;
                    },
                    dataType: 'json',
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.code,
                                    text: item.name
                                };
                            })
                        };
                    }
                }
            });

            // Thiết lập giá trị mặc định cho xã/phường nếu có dữ liệu từ info.
            if (userWardCode) {
                $('#ward_id').append('<option value="' + userWardCode + '">' + userWard + '</option>');
            }
        });

        $(document).ready(function() {
            $('#add_product').select2({
                ajax: {
                    url: '{{ route('products.getProducts') }}',
                    data: function(params) {
                        var query = {
                            q: params.term,
                            page: params.page || 1,
                            _token: '{{ csrf_token() }}'
                        };
                        return query;
                    },
                    dataType: 'json',
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.data.map(function(product) {
                                return {
                                    id: product.id,
                                    text: product.name,
                                    image: product.image,
                                    name: product.name,
                                    price: product.price,
                                    discount: product.discount,
                                    stock: product.stock
                                };
                            }),
                            pagination: {
                                more: params.page < data.lastPage
                            }
                        };
                    }
                },
                templateResult: function(product) {
                    if (!product.image) return product.text;
                    return $(
                        '<div class="productimgname"><img src="' +
                        product.image +
                        '" class="img-thumbnail" alt="Image" style="with:25px;height:25px" /> ' +
                        product.name +
                        ' Price: ' +
                        (product.price + product.discount) +
                        ' Discount: ' +
                        product.discount +
                        ' Stock: ' +
                        product.stock +
                        '</div>'
                    );
                },
                escapeMarkup: function(markup) {
                    return markup;
                }
            });

            function sendAjaxRequest() {
                shouldSendAjaxRequest = false;
                $.ajax({
                    url: '{{ route('products.getProductInfo') }}',
                    type: 'GET',
                    data: {
                        order_id: {{ $order->id ?? 0 }},
                        selected_ids: selectedIds, // Sử dụng selectedIds
                        amounts: amounts,
                        product_ids: productIds
                    },
                    success: function(response) {
                        $("#table-update").html(response.table_update);

                        $.each(response.remove_ids, function(index, value) {
                            $('#add_product option[value="' + value + '"]').prop('selected',
                                false);
                        });

                        $('#add_product').trigger('change');

                        $("#table-update select").select2();

                        $(document).find('select.product-amount').on('change',
                            handleProductAmountChange);
                        shouldSendAjaxRequest = true;
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        shouldSendAjaxRequest = true;
                    }
                });
            }

            function addThousandsSeparator(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function getTotalLastTotalValue() {
                var total = 0;
                $(".last-total").each(function() {
                    var value = $(this).text().replace(/\D/g, ''); // Lấy giá trị số, bỏ dấu phân cách
                    total += parseInt(value); // Chuyển giá trị thành số nguyên và cộng vào tổng
                });
                return total;
            }

            function handleProductAmountChange() {
                var selectedOption = $(this).find('option:selected');
                var price = parseInt($(this).data('price'));
                var discount = parseInt($(this).data('discount'));
                var amount = parseInt(selectedOption.val());
                var priceOrder = parseInt($(this).data('price-order'));
                var discountOrder = parseInt($(this).data('discount-order'));
                var amountOrder = parseInt($(this).data('amount-order'));

                if (amount > amountOrder) {
                    var total = price * (amount - amountOrder);
                    var totalDiscount = discount * (amount - amountOrder);
                    var totalOrder = priceOrder * amountOrder;
                    var totalDiscountOrder = discountOrder * amountOrder;
                } else {
                    var total = 0;
                    var totalDiscount = 0;
                    var totalOrder = priceOrder * amount;
                    var totalDiscountOrder = discountOrder * amount;
                }

                var lastTotal =total + totalOrder - totalDiscount - totalDiscountOrder;


                $(this).closest('tr').find('.total-price').text(addThousandsSeparator(total));
                $(this).closest('tr').find('.total-discount').text(addThousandsSeparator(totalDiscount));
                $(this).closest('tr').find('.total-price-order').text(addThousandsSeparator(totalOrder));
                $(this).closest('tr').find('.total-discount-order').text(addThousandsSeparator(totalDiscountOrder));
                $(this).closest('tr').find('.last-total').text( addThousandsSeparator(lastTotal));

                var sumTotal = getTotalLastTotalValue();
                $("#sum-total").text(addThousandsSeparator(sumTotal));
            }

            $(document).on('change', 'select.product-amount', handleProductAmountChange);

            $(document).on('click', 'a.delete-product', function(e) {
                e.preventDefault();
                var productIdToDelete = $(this).data('product-id');
                $('#add_product option[value="' + productIdToDelete + '"]').remove();
                $('#add_product').trigger('change');
                $(this).closest('tr').remove();
            });

            var amounts = [];
            var productIds = [];
            var selectedIds = [];
            var shouldSendAjaxRequest = true;

            $('#add_product').on('change', function() {
                if (shouldSendAjaxRequest) {
                    selectedIds = $(this).val();
                    amounts = [];
                    productIds = [];
                    $('select.product-amount').each(function() {
                        var productId = $(this).data('product-id');
                        var amount = $(this).val();
                        amounts.push(amount);
                        productIds.push(productId);
                    });
                    sendAjaxRequest();
                }
            });
        });
    </script>
@endpush
