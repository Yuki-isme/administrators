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

                    <!-- Checkout -->
                    <div class="card shadow-0 border">
                        <div class="p-4">
                            <h5 class="card-title mb-3">Order Info</h5>
                            <form action="{{ route("checkout") }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <p class="mb-0">Name</p>
                                        <div class="form-outline">
                                            <input type="text" id="typeText" placeholder="Type here"
                                                class="form-control" name="name" value="{{ $user->name ?? '' }}" required/>
                                        </div>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <p class="mb-0">Phone</p>
                                        <div class="form-outline">
                                            <input type="tel" id="typePhone" name="phone_number"
                                                value="{{ $user->phone ?? '' }}" class="form-control" required/>
                                        </div>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <p class="mb-0">Email</p>
                                        <div class="form-outline">
                                            <input type="email" id="typeEmail" placeholder="example@gmail.com"
                                                class="form-control" name="email" value="{{ $user->email ?? '' }}" required/>
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

                                    <div class="col-sm-4 mb-3">
                                        <p class="mb-0">Province / City</p>
                                        <select id="province_id" name="province_code" class="form-select select2" required>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->code }}"
                                                    {{ isset($user->info->province_code) && $user->info->province_code == $province->code ? 'selected' : '' }}>
                                                    {{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4 mb-3">
                                        <p class="mb-0">District / Town</p>
                                        <select id="district_id" name="district_code" class="form-select select2" required>

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
                                            <input type="text" id="typeText" placeholder="Type here" name="house"
                                                class="form-control" value="{{ $user->info->house ?? '' }}" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-6 mb-3">
                                        <p class="mb-0">Street Name</p>
                                        <div class="form-outline">
                                            <input type="text" id="typeText" class="form-control" placeholder="Type here" name="street"
                                                value="{{ $user->info->street ?? '' }}" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="1"
                                        id="flexCheckDefault1" name="save"/>
                                    <label class="form-check-label" for="flexCheckDefault1">Save this address</label>
                                </div>

                                <div class="mb-3">
                                    <p class="mb-0">Message to seller</p>
                                    <div class="form-outline">
                                        <textarea class="form-control" id="textAreaExample1" placeholder="Type here" rows="2" name="note" required>{{ $user->info->note ?? '' }}</textarea>
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
                            <p class="mb-2">{{ $total }} đ</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Discount:</p>
                            <p class="mb-2">{{ $discount ?? 0 }} đ</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Tax:</p>
                            <p class="mb-2">{{ $tax ?? 0 }} đ</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Shipping cost:</p>
                            <p class="mb-2">{{ $ship ?? 0 }} ₫</p>
                        </div>
                        <hr />
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Total price:</p>
                            <p class="mb-2 fw-bold text-danger">{{ $total }} VND</p>
                            {{-- + $ship + $tax - $discount --}}
                        </div>

                        <div class="input-group mt-3 mb-4">
                            <input type="text" class="form-control border" name="" placeholder="Promo code" />
                            <button class="btn btn-light text-primary border">Apply</button>
                        </div>

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
                                            style="height: 96px; width: 96x;" class="img-sm rounded border" />
                                    </div>
                                    <div class="">
                                        <a href="#" class="nav-link">
                                            {{ $item['name'] }}
                                        </a>
                                        <div class="price text-muted">Total: {{ $item['amount'] * $item['price'] }} VND
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
            $('select.select2').select2();

            // Lấy mã quận/huyện từ bảng info (nếu có).
            var userDistrictCode = '{{ isset($user->info->district_code) ? $user->info->district_code : '' }}';
            var userDistrict = '{{ isset($user->info->district_code) ? $user->info->district->name : '' }}';

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
            var userWardCode = '{{ isset($user->info->ward_code) ? $user->info->ward_code : '' }}';
            var userWard = '{{ isset($user->info->ward_code) ? $user->info->ward->name : '' }}';

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
