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
                        action="{{ route('orders.update', $order->id) }}"
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
                                        <option value="Thanh toán khi nhận hàng" {{ $order->payment_method == 'Thanh toán khi nhận hàng' ? 'selected' : '' }} {{ $order->payment_method == 'Thanh toán qua VN Pay' ? 'disabled' : ''}}>Thanh toán khi nhận hàng</option>
                                        <option value="Thanh toán qua VN Pay" {{ $order->payment_method == 'Thanh toán qua VN Pay' ? 'selected' : ''}}>Thanh toán qua VN Pay</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <select name="payment_status" class="disabled-results form-control form-small">
                                        <option value="Chưa thanh toán" {{ $order->payment_status == 'Chưa thanh toán' ? 'selected' : ''}} {{ $order->payment_status == 'Đã thanh toán' ? 'disabled' : ''}}>Chưa thanh toán</option>
                                        <option value="Đã thanh toán" {{ $order->payment_status == 'Đã thanh toán' ? 'selected' : ''}}>Đã thanh toán</option>
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
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product name</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                            <th>Amount</th>
                                            <th>Total</th>
                                            <th>Total discount</th>
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
                                                    @if (isset($order))
                                                        <td>{{ number_format($item->price + $item->discount, 0, ',', '.') }}
                                                        </td>
                                                        <td>{{ number_format($item->discount, 0, ',', '.') }}</td>
                                                    @endif
                                                    <td>
                                                        {{ $item->amount }}
                                                    </td>
                                                    <td class="total-price-order">
                                                        {{ number_format($item->price * $item->amount + $item->discount * $item->amount, 0, ',', '.') }}
                                                    </td>
                                                    <td class="total-discount-order">
                                                        {{ number_format($item->discount * $item->amount, 0, ',', '.') }}
                                                    </td>

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
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="6" style="font-weight: bold;">Sum</td>
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
    </script>
@endpush
