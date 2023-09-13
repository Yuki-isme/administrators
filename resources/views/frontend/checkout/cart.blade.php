@extends('frontend.layout.layout')

@section('content')
    <!-- cart + summary -->
    <section class="bg-light my-5">
        <div class="container">
            <div class="row">
                <!-- cart -->
                <div class="col-lg-9">
                    <div class="card border shadow-0">
                        <div class="m-4">
                            <h4 class="card-title mb-4">Your shopping cart</h4>
                            <div id="cart-update">
                                @if (cart()->getContent() && count(cart()->getContent()) > 0)
                                    @foreach (cart()->getContent() as $id => $item)
                                        <div class="row gy-3 mb-4">
                                            <div class="col-lg-5">
                                                <div class="me-lg-5">
                                                    <div class="d-flex">
                                                        <img src="{{ asset('storage/' . $item['img']) }}"
                                                            class="border rounded me-3" style="width: 96px; height: 96px" />
                                                        <div class="">
                                                            <a href="#" class="nav-link">{{ $item['name'] }}</a>
                                                            <p class="text-muted">Yellow, Jeans</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                                                <div class="">
                                                    <select style="width: 100px"
                                                        class="form-select me-4 update-amount-select"
                                                        data-product-id="{{ $id }}" value={{ $item['amount'] }}>
                                                        @for ($i = 1; $i <= $item['stock']; $i++)
                                                            <option {{ $i == $item['amount'] ? 'Selected' : '' }}>
                                                                {{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="">
                                                    <span
                                                        class="h6">{{ number_format($item['price'] * $item['amount'], 0, ',', '.') }}
                                                        VND</span>
                                                    <br />
                                                    <small class="text-muted text-nowrap">
                                                        {{ number_format($item['price'], 0, ',', '.') }} VND / per item
                                                    </small>
                                                </div>
                                            </div>
                                            <div
                                                class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
                                                <div class="float-md-end">
                                                    {{-- <a href="#!"
                                                        class="btn btn-light border px-2 icon-hover-primary"><i
                                                            class="fas fa-heart fa-lg px-1 text-secondary"></i></a> --}}
                                                    <a href="{{ route('deleteItem', ['id' => $id]) }}"
                                                        class="btn btn-light border text-danger icon-hover-danger deleteItem">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            {{-- @else
                                <div class="row gy-3 mb-4">

                                </div> --}}

                        </div>
                        <div class="border-top pt-4 mx-4 mb-4">
                            <p>
                                <i class="fas fa-truck text-muted fa-lg"></i> Free Delivery
                                within 1-2 weeks
                            </p>
                            <p class="text-muted">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                laboris nisi ut aliquip
                            </p>
                        </div>
                    </div>
                </div>
                <!-- cart -->
                <!-- summary -->
                <div class="col-lg-3">
                    {{-- <div class="card mb-3 border shadow-0">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label">Have coupon?</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control border" name=""
                                            placeholder="Coupon code" />
                                        <button class="btn btn-light border">Apply</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                    <div class="card shadow-0 border">
                        <div class="card-body">
                            <div id="total-update">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-2">Total price:</p>
                                    <p class="mb-2">{{ number_format(cart()->getTotal() + cart()->getDiscount(), 0, ',', '.') }} đ</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="mb-2">Discount:</p>
                                    <p class="mb-2 text-danger">{{ number_format(cart()->getDiscount(), 0, ',', '.') }} đ</p>
                                </div>
                                {{-- <div class="d-flex justify-content-between">
                                    <p class="mb-2">TAX:</p>
                                    <p class="mb-2">{{ $tax ?? 0 }} đ</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="mb-2">Shipping Cost:</p>
                                    <p class="mb-2">{{ $ship ?? 0 }} ₫</p>
                                </div> --}}
                                <hr />
                                <div class="d-flex justify-content-between">
                                    <p class="mb-2">Total price:</p>
                                    <p class="mb-2 fw-bold text-success">{{ number_format(cart()->getTotal(), 0, ',', '.') }} VND</p>
                                    {{-- + $ship + $tax - $discount --}}
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('order') }}" class="btn btn-success w-100 shadow-0 mb-2">
                                    Make Purchase
                                </a>
                                <a href="{{ route('list') }}" class="btn btn-light w-100 border mt-2">
                                    Back to shop
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- summary -->
            </div>
        </div>
    </section>
    <!-- cart + summary -->
    <section>
        <div class="container my-5">
            <header class="mb-4">
                <h3>Recommended items</h3>
            </header>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card px-4 border shadow-0 mb-4 mb-lg-0">
                        <div class="mask px-2" style="height: 50px">
                            <div class="d-flex justify-content-between">
                                <h6>
                                    <span class="badge bg-danger pt-1 mt-3 ms-2">New</span>
                                </h6>
                                <a href="#"><i class="fas fa-heart text-primary fa-lg float-end pt-3 m-2"></i></a>
                            </div>
                        </div>
                        <a href="#" class="">
                            <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/7.webp"
                                class="card-img-top rounded-2" />
                        </a>
                        <div class="card-body d-flex flex-column pt-3 border-top">
                            <a href="#" class="nav-link">Gaming Headset with Mic</a>
                            <div class="price-wrap mb-2">
                                <strong class="">$18.95</strong>
                                <del class="">$24.99</del>
                            </div>
                            <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                <a href="#" class="btn btn-outline-primary w-100">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card px-4 border shadow-0 mb-4 mb-lg-0">
                        <div class="mask px-2" style="height: 50px">
                            <a href="#"><i class="fas fa-heart text-primary fa-lg float-end pt-3 m-2"></i></a>
                        </div>
                        <a href="#" class="">
                            <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/5.webp"
                                class="card-img-top rounded-2" />
                        </a>
                        <div class="card-body d-flex flex-column pt-3 border-top">
                            <a href="#" class="nav-link">Apple Watch Series 1 Sport </a>
                            <div class="price-wrap mb-2">
                                <strong class="">$120.00</strong>
                            </div>
                            <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                <a href="#" class="btn btn-outline-primary w-100">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card px-4 border shadow-0">
                        <div class="mask px-2" style="height: 50px">
                            <a href="#"><i class="fas fa-heart text-primary fa-lg float-end pt-3 m-2"></i></a>
                        </div>
                        <a href="#" class="">
                            <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/9.webp"
                                class="card-img-top rounded-2" />
                        </a>
                        <div class="card-body d-flex flex-column pt-3 border-top">
                            <a href="#" class="nav-link">Men's Denim Jeans Shorts</a>
                            <div class="price-wrap mb-2">
                                <strong class="">$80.50</strong>
                            </div>
                            <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                <a href="#" class="btn btn-outline-primary w-100">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card px-4 border shadow-0">
                        <div class="mask px-2" style="height: 50px">
                            <a href="#"><i class="fas fa-heart text-primary fa-lg float-end pt-3 m-2"></i></a>
                        </div>
                        <a href="#" class="">
                            <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/10.webp"
                                class="card-img-top rounded-2" />
                        </a>
                        <div class="card-body d-flex flex-column pt-3 border-top">
                            <a href="#" class="nav-link">Mens T-shirt Cotton Base Layer Slim fit
                            </a>
                            <div class="price-wrap mb-2">
                                <strong class="">$13.90</strong>
                            </div>
                            <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                <a href="#" class="btn btn-outline-primary w-100">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Recommended -->
@endsection

@push('custom-script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.deleteItem', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('href'),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        console.log(response.count);
                        $('#cart-amount').text('My cart' + ' (' + response.count + ')');
                        $('#cart-update').html(response.cart);
                        $('#total-update').html(response.total);
                    }
                });
            });
        });

        $(document).ready(function() {
            $(document).on('change', '.update-amount-select', function(e) {
                e.preventDefault();

                const productId = $(this).data('product-id');
                const amount = $(this).val();

                $.ajax({
                    url: `{{ route('updateAmount', ['id' => ':id']) }}`.replace(':id', productId),
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        amount: amount,
                    },
                    success: function(response) {
                        $('#cart-update').html(response.cart);
                        $('#total-update').html(response.total);
                    }
                });
            });
        });

    </script>
@endpush
