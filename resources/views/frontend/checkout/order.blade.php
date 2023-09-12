@extends('frontend.layout.layout')

@section('content')
    <section class="bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 mb-4">
                    @if (!Auth::guard('web')->check())
                        <div class="card mb-4 border shadow-0">
                            <div class="p-4 d-flex justify-content-between">
                                <div class="">
                                    <h5>Have an account?</h5>
                                    <p class="mb-0 text-wrap ">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-center flex-column flex-md-row">
                                    <a href="{{ route('login') }}" class="btn btn-primary shadow-0 text-nowrap w-100">Sign
                                        in</a>
                                </div>
                            </div>
                        </div>
                    @endif
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
                    <!-- Checkout -->
                    <div class="card shadow-0 border">
                        <div class="p-4">
                            <h5 class="card-title mb-3">Order Info</h5>
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <div class="row">

                                    <div class="col-12 mb-3">
                                        <p class="mb-0">Name</p>
                                        <div class="form-outline">
                                            <input type="text" class="form-control" placeholder="Your name"
                                                name="name" id="name" required />
                                        </div>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <p class="mb-0">Phone</p>
                                        <div class="form-outline">
                                            <input type="tel" class="form-control" placeholder="Your phone"
                                                name="phone_number" id="phone_number" required />
                                        </div>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <p class="mb-0">Email</p>
                                        <div class="form-outline">
                                            <input type="email" class="form-control" placeholder="example@gmail.com"
                                                name="email" id="email" required />
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4" />

                                <h5 class="card-title mb-3">Payment Methods</h5>

                                <div class="row mb-3">
                                    <div class="col-lg-4 mb-3">
                                        <!-- Default checked radio -->
                                        <div class="form-check h-100 border rounded-3">
                                            <div class="p-3">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                    id="paymentMethod1" value="1" checked />
                                                <label class="form-check-label" for="paymentMethod1">
                                                    Payment on delivery <br />
                                                    <small class="text-muted">Call to confirm order </small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <!-- Default radio -->
                                        <div class="form-check h-100 border rounded-3">
                                            <div class="p-3">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                    id="paymentMethod2" value="2" />
                                                <label class="form-check-label" for="paymentMethod2">
                                                    Pay via vnpay <br />
                                                    <small class="text-muted">Instant order confirmation </small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4" />

                                <h5 class="card-title mb-3">Address</h5>

                                <div class="row">
                                    @if (Auth::guard('web')->check())
                                        <div class="col-12 mb-3">
                                            <p class="mb-0">Address list</p>
                                            <select class="form-select select2" name="info_id" id="address_list">
                                                <option value="0">New Address</option>
                                                @foreach ($user->info as $info)
                                                    <option value="{{ $info->id }}" data-name="{{ $info->name }}"
                                                        data-phone_number="{{ $info->phone_number }}"
                                                        data-email="{{ $info->email }}" data-house="{{ $info->house }}"
                                                        data-street="{{ $info->street }}"
                                                        data-ward_code="{{ $info->ward_code }}"
                                                        data-district_code="{{ $info->district_code }}"
                                                        data-province_code="{{ $info->province_code }}"
                                                        data-note="{{ $info->note }}">
                                                        {{ $info->name . ', ' . $info->phone_number . ', ' . $info->email . ', ' . $info->house . ', ' . $info->street . ', ' . $info->ward->name . ', ' . $info->district->name . ', ' . $info->province->name . ', ' . $info->note }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="col-sm-4 mb-3">
                                        <p class="mb-0">Province / City</p>
                                        <select id="province_id" name="province_code" class="form-select select2" required>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->code }}">{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4 mb-3">
                                        <p class="mb-0">District / Town</p>
                                        <select id="district_id" name="district_code" class="form-select select2"
                                            required>

                                        </select>
                                    </div>

                                    <div class="col-sm-4 mb-3">
                                        <p class="mb-0">Commune / Ward</p>
                                        <select id="ward_id" name="ward_code" class="form-select select2" required>

                                        </select>
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <p class="mb-0">House</p>
                                        <div class="form-outline">
                                            <input type="text" class="form-control" placeholder="Type here"
                                                name="house" id="house" required />
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-6 mb-3">
                                        <p class="mb-0">Street Name</p>
                                        <div class="form-outline">
                                            <input type="text" class="form-control" placeholder="Type here"
                                                name="street" id="street" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="1"
                                        id="flexCheckDefault1" name="save" />
                                    <label class="form-check-label" for="flexCheckDefault1">Save this address</label>
                                </div>

                                <div class="mb-3">
                                    <p class="mb-0">Message to seller</p>
                                    <div class="form-outline">
                                        <textarea class="form-control" placeholder="Type here" rows="2" name="note" id="note" required></textarea>
                                    </div>
                                </div>

                                <div class="float-end">
                                    <a class="btn btn-light border" href="{{ route('cart') }}">Cancel</a>
                                    <input class="btn btn-success shadow-0 border" type="submit" value="Place Order">
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Checkout -->
                </div>
                <div class="col-xl-4 col-lg-4 d-flex justify-content-center justify-content-lg-end">
                    <div class="ms-lg-4 mt-4 mt-lg-0" style="max-width: 320px;">
                        <h6 class="mb-3">Summary</h6>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Total price:</p>
                            <p class="mb-2">{{ number_format($total + $discount, 0, ',', '.') }} đ</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Discount:</p>
                            <p class="mb-2 text-danger">- {{ number_format($discount, 0, ',', '.') }} đ</p>
                        </div>
                        {{-- <div class="d-flex justify-content-between">
                            <p class="mb-2">Tax:</p>
                            <p class="mb-2">{{ $tax ?? 0 }} đ</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Shipping cost:</p>
                            <p class="mb-2">{{ $ship ?? 0 }} ₫</p>
                        </div> --}}
                        <hr />
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Total amount payable:</p>
                            <p class="mb-2 fw-bold text-success">{{ number_format($total, 0, ',', '.') }} VND</p>
                            {{-- + $ship + $tax - $discount --}}
                        </div>

                        {{-- <div class="input-group mt-3 mb-4">
                            <input type="text" class="form-control border" name="" placeholder="Promo code" />
                            <button class="btn btn-light text-primary border">Apply</button>
                        </div> --}}

                        <hr />
                        <h6 class="text-dark my-4">Items in cart</h6>

                        @if (isset($carts))
                            @foreach ($carts as $item)
                                <div class="d-flex align-items-center mb-4">
                                    <div class="me-3 position-relative">
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-secondary">
                                            {{ $item['amount'] }}
                                        </span>
                                        <img src="{{ asset('storage/' . $item['img']) }}"
                                            style="height: 96px; width: 96px;" class="img-sm rounded border" />
                                    </div>
                                    <div class="me-3">
                                        <a href="#" class="nav-link">
                                            {{ $item['name'] }}
                                        </a>
                                        <div class="price text-muted">
                                            Total:{{ number_format($item['amount'] * $item['price'], 0, ',', '.') }} VND
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="d-flex align-items-center mb-4">
                                <div class="me-3 position-relative">

                                </div>
                                <div class="">
                                    <a href="#" class="nav-link">
                                        No Item
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
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

            async function loadDistricts(provinceCode) {
                $('#district_id').empty(); // Xóa tất cả các option hiện tại

                try {
                    const data = await $.ajax({
                        url: '{{ route('getDistricts') }}',
                        data: {
                            province_code: provinceCode,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json'
                    });

                    // Thêm các option mới vào select district
                    data.forEach(function(item) {
                        $('#district_id').append('<option value="' + item.code + '">' + item.name +
                            '</option>');
                    });
                } catch (error) {
                    console.error('Lỗi khi tải danh sách district:', error);
                }
            }

            async function loadWards(districtCode) {
                $('#ward_id').empty(); // Xóa tất cả các option hiện tại

                try {
                    const data = await $.ajax({
                        url: '{{ route('getWards') }}',
                        data: {
                            district_code: districtCode,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json'
                    });

                    // Thêm các option mới vào select ward
                    data.forEach(function(item) {
                        $('#ward_id').append('<option value="' + item.code + '">' + item.name +
                            '</option>');
                    });
                } catch (error) {
                    console.error('Lỗi khi tải danh sách ward:', error);
                }
            }

            $('#address_list').on('change', async function() { // Đặt sự kiện là async
                var selectedOption = $(this).find(':selected');

                if (selectedOption.val() !== '0') {
                    // Lấy các giá trị từ option được chọn
                    var name = selectedOption.data('name');
                    var phone_number = selectedOption.data('phone_number');
                    var email = selectedOption.data('email');
                    var province_code = selectedOption.data('province_code');
                    var district_code = selectedOption.data('district_code');
                    var ward_code = selectedOption.data('ward_code');
                    var house = selectedOption.data('house');
                    var street = selectedOption.data('street');
                    var note = selectedOption.data('note');

                    console.log(name, phone_number, email, province_code, district_code, ward_code,
                        house,
                        street, note);

                    // Cập nhật các trường thông tin với giá trị từ option được chọn
                    $('#name').val(name);
                    $('#phone_number').val(phone_number);
                    $('#email').val(email);
                    $('#province_id').val(province_code).trigger('change');

                    // Sử dụng await để chờ cho các hàm loadDistricts và loadWards hoàn thành
                    await loadDistricts(province_code);
                    $('#district_id').val(district_code).trigger('change');

                    await loadWards(district_code);
                    $('#ward_id').val(ward_code).trigger('change');

                    $('#house').val(house);
                    $('#street').val(street);
                    $('#note').val(note);
                } else {
                    // Nếu chọn "New Address", xóa dữ liệu trong các trường thông tin
                    $('#name').val('');
                    $('#phone_number').val('');
                    $('#email').val('');
                    $('#province_id').val('').trigger('change');
                    $('#district_id').val('').trigger('change');
                    $('#ward_id').val('').trigger('change');
                    $('#house').val('');
                    $('#street').val('');
                    $('#note').val('');
                }
            });

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
        });

        // // Lấy mã quận/huyện từ bảng info (nếu có).
        // var userDistrictCode = '{{ isset($user->info->district_code) ? $user->info->district_code : '' }}';
        // var userDistrict = '{{ isset($user->info->district_code) ? $user->info->district->name : '' }}';
        // // Thiết lập giá trị mặc định cho quận/huyện nếu có dữ liệu từ info.
        // if (userDistrictCode) {
        //     $('#district_id').append('<option value="' + userDistrictCode + '">' + userDistrict + '</option>');
        // }
    </script>
@endpush
