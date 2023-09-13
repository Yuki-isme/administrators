@extends('frontend.layout.layout')

@section('content')
    <section class="bg-light">
        <div class="container mt-5">
            <div class="tab-content">
                <div id="profile-section" class="tab-pane fade show active">
                    <div class="row justify-content-start">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Profile Settings</h5>
                                    <form>
                                        <!-- Profile form fields -->
                                        <div class="form-outline mb-4">
                                            <input type="text" id="name" class="form-control" name="name"
                                                value="{{ $user->name }}" />
                                            <label class="form-label" for="name">Name</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="email" id="email" class="form-control" name="email"
                                                value="{{ $user->email }}" />
                                            <label class="form-label" for="email">Email</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="text" id="phone" class="form-control" name="phone"
                                                value="{{ $user->phone }}" />
                                            <label class="form-label" for="phone">Phone</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" id="password" class="form-control" name="password" />
                                            <label class="form-label" for="password">Password</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" id="confirm-password" class="form-control"
                                                name="confirm" />
                                            <label class="form-label" for="confirm-password">Confirm Password</label>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="all-orders-section" class="tab-pane fade">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            @foreach ($orders as $order)
                                <div class="card border mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Code Orders: {{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}
                                        </h5>
                                        <!-- All Orders form fields for Order 1 -->
                                        <div class="form-outline mb-3">
                                            <p style="color:black">Name: {{ $order->name }}</p>
                                            <p style="color:black">Phone: {{ $order->phone_number }}</p>
                                            <p style="color:black">Email: {{ $order->email }}</p>
                                            <p style="color:black">Address:
                                                {{ $order->house . ', ' . $order->street . ', ' . $order->ward->name . ', ' . $order->district->name . ', ' . $order->province->name }}
                                            </p>
                                            <p style="color:black">Note: {{ $order->note }}</p>
                                            <p style="color:black">Payment method: {{ $order->payment_method }}</p>
                                            <p style="color:black">Payment status: {{ $order->payment_status }}</p>
                                            <p style="color:black">Status: {{ $order->status->name }}</p>
                                        </div>
                                        <hr>
                                        <h6 class="card-subtitle mb-3">Products List</h6>
                                        <table width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th style="text-align: right;">Price</th>
                                                    <th style="text-align: right;">Discount</th>
                                                    <th style="text-align: right;">Amount</th>
                                                    <th style="text-align: right;">Total Price</th>
                                                    <th style="text-align: right;">Total Discount</th>
                                                    <th style="text-align: right;">Last Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->items as $item)
                                                    <tr>
                                                        <td>{{ $item->product_name }}</td>
                                                        <td style="text-align: right;">
                                                            {{ number_format($item->price + $item->discount, 0, ',', '.') }}
                                                            đ
                                                        </td>
                                                        <td style="text-align: right;">
                                                            {{ number_format($item->discount, 0, ',', '.') }} đ
                                                        </td>
                                                        <td style="text-align: right;">{{ $item->amount }}
                                                        </td>
                                                        <td style="text-align: right;">
                                                            {{ number_format(($item->price + $item->discount) * $item->amount, 0, ',', '.') }}
                                                            đ
                                                        </td>
                                                        <td style="text-align: right;">
                                                            {{ number_format($item->discount * $item->amount, 0, ',', '.') }}
                                                            đ
                                                        </td>
                                                        <td style="text-align: right;">
                                                            {{ number_format($item->price * $item->amount, 0, ',', '.') }}
                                                            đ
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="6"></td>
                                                    <td style="text-align: right;">
                                                        {{ number_format($order->total, 0, ',', '.') }} VND</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <div style="float: right">
                                            @if ($order->payment_method == 'Thanh toán qua VN Pay' && $order->payment_status == 'Chưa thanh toán')
                                                <button type="button" class="btn btn-primary">Repayment</button>
                                            @endif
                                            @if ($order->status_id == 8 || $order->status_id == 5 || $order->status_id == 6)
                                                <button type="button" class="btn btn-success">Re-order</button>
                                            @endif
                                            @if ($order->status_id < 3)
                                                <button type="button" class="btn btn-danger">Cancel</button>
                                            @endif
                                            @if ($order->status_id == 7)
                                                <button type="button" class="btn btn-warning">No order
                                                    cancellation</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div id="shipping-orders-section" class="tab-pane fade">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            @foreach ($orders as $order)
                                @if ($order->status_id < 6 && $order->status_id > 2)
                                    <div class="card border mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Code Orders:
                                                {{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}
                                            </h5>
                                            <!-- All Orders form fields for Order 1 -->
                                            <div class="form-outline mb-3">
                                                <p style="color:black">Name: {{ $order->name }}</p>
                                                <p style="color:black">Phone: {{ $order->phone_number }}</p>
                                                <p style="color:black">Email: {{ $order->email }}</p>
                                                <p style="color:black">Address:
                                                    {{ $order->house . ', ' . $order->street . ', ' . $order->ward->name . ', ' . $order->district->name . ', ' . $order->province->name }}
                                                </p>
                                                <p style="color:black">Note: {{ $order->note }}</p>
                                                <p style="color:black">Payment method: {{ $order->payment_method }}</p>
                                                <p style="color:black">Payment status: {{ $order->payment_status }}</p>
                                                <p style="color:black">Status: {{ $order->status->name }}</p>
                                            </div>
                                            <hr>
                                            <h6 class="card-subtitle mb-3">Products List</h6>
                                            <table width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th style="text-align: right;">Price</th>
                                                        <th style="text-align: right;">Discount</th>
                                                        <th style="text-align: right;">Amount</th>
                                                        <th style="text-align: right;">Total Price</th>
                                                        <th style="text-align: right;">Total Discount</th>
                                                        <th style="text-align: right;">Last Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->items as $item)
                                                        <tr>
                                                            <td>{{ $item->product_name }}</td>
                                                            <td style="text-align: right;">
                                                                {{ number_format($item->price + $item->discount, 0, ',', '.') }}
                                                                đ
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ number_format($item->discount, 0, ',', '.') }} đ
                                                            </td>
                                                            <td style="text-align: right;">{{ $item->amount }}
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ number_format(($item->price + $item->discount) * $item->amount, 0, ',', '.') }}
                                                                đ
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ number_format($item->discount * $item->amount, 0, ',', '.') }}
                                                                đ
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ number_format($item->price * $item->amount, 0, ',', '.') }}
                                                                đ
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td style="text-align: right;">
                                                            {{ number_format($order->total, 0, ',', '.') }} VND</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <br>
                                            <div style="float: right">
                                                @if ($order->payment_method == 'Thanh toán qua VN Pay' && $order->payment_status == 'Chưa thanh toán')
                                                    <button type="button" class="btn btn-primary">Repayment</button>
                                                @endif
                                                @if ($order->status_id == 8 || $order->status_id == 5 || $order->status_id == 6)
                                                    <button type="button" class="btn btn-success">Re-order</button>
                                                @endif
                                                @if ($order->status_id < 3)
                                                    <button type="button" class="btn btn-danger">Cancel</button>
                                                @endif
                                                @if ($order->status_id == 7)
                                                    <button type="button" class="btn btn-warning">No order
                                                        cancellation</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div id="completed-orders-section" class="tab-pane fade">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            @foreach ($orders as $order)
                                @if ($order->status_id == 6)
                                    <div class="card border mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Code Orders:
                                                {{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}
                                            </h5>
                                            <!-- All Orders form fields for Order 1 -->
                                            <div class="form-outline mb-3">
                                                <p style="color:black">Name: {{ $order->name }}</p>
                                                <p style="color:black">Phone: {{ $order->phone_number }}</p>
                                                <p style="color:black">Email: {{ $order->email }}</p>
                                                <p style="color:black">Address:
                                                    {{ $order->house . ', ' . $order->street . ', ' . $order->ward->name . ', ' . $order->district->name . ', ' . $order->province->name }}
                                                </p>
                                                <p style="color:black">Note: {{ $order->note }}</p>
                                                <p style="color:black">Payment method: {{ $order->payment_method }}</p>
                                                <p style="color:black">Payment status: {{ $order->payment_status }}</p>
                                                <p style="color:black">Status: {{ $order->status->name }}</p>
                                            </div>
                                            <hr>
                                            <h6 class="card-subtitle mb-3">Products List</h6>
                                            <table width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th style="text-align: right;">Price</th>
                                                        <th style="text-align: right;">Discount</th>
                                                        <th style="text-align: right;">Amount</th>
                                                        <th style="text-align: right;">Total Price</th>
                                                        <th style="text-align: right;">Total Discount</th>
                                                        <th style="text-align: right;">Last Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->items as $item)
                                                        <tr>
                                                            <td>{{ $item->product_name }}</td>
                                                            <td style="text-align: right;">
                                                                {{ number_format($item->price + $item->discount, 0, ',', '.') }}
                                                                đ
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ number_format($item->discount, 0, ',', '.') }} đ
                                                            </td>
                                                            <td style="text-align: right;">{{ $item->amount }}
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ number_format(($item->price + $item->discount) * $item->amount, 0, ',', '.') }}
                                                                đ
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ number_format($item->discount * $item->amount, 0, ',', '.') }}
                                                                đ
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ number_format($item->price * $item->amount, 0, ',', '.') }}
                                                                đ
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td style="text-align: right;">
                                                            {{ number_format($order->total, 0, ',', '.') }} VND</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <br>
                                            <div style="float: right">
                                                @if ($order->payment_method == 'Thanh toán qua VN Pay' && $order->payment_status == 'Chưa thanh toán')
                                                    <button type="button" class="btn btn-primary">Repayment</button>
                                                @endif
                                                @if ($order->status_id == 8 || $order->status_id == 5 || $order->status_id == 6)
                                                    <button type="button" class="btn btn-success">Re-order</button>
                                                @endif
                                                @if ($order->status_id < 3)
                                                    <button type="button" class="btn btn-danger">Cancel</button>
                                                @endif
                                                @if ($order->status_id == 7)
                                                    <button type="button" class="btn btn-warning">No order
                                                        cancellation</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div id="cancelled-orders-section" class="tab-pane fade">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            @foreach ($orders as $order)
                                @if ($order->status_id > 6)
                                    <div class="card border mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Code Orders:
                                                {{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}
                                            </h5>
                                            <!-- All Orders form fields for Order 1 -->
                                            <div class="form-outline mb-3">
                                                <p style="color:black">Name: {{ $order->name }}</p>
                                                <p style="color:black">Phone: {{ $order->phone_number }}</p>
                                                <p style="color:black">Email: {{ $order->email }}</p>
                                                <p style="color:black">Address:
                                                    {{ $order->house . ', ' . $order->street . ', ' . $order->ward->name . ', ' . $order->district->name . ', ' . $order->province->name }}
                                                </p>
                                                <p style="color:black">Note: {{ $order->note }}</p>
                                                <p style="color:black">Payment method: {{ $order->payment_method }}</p>
                                                <p style="color:black">Payment status: {{ $order->payment_status }}</p>
                                                <p style="color:black">Status: {{ $order->status->name }}</p>
                                            </div>
                                            <hr>
                                            <h6 class="card-subtitle mb-3">Products List</h6>
                                            <table width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th style="text-align: right;">Price</th>
                                                        <th style="text-align: right;">Discount</th>
                                                        <th style="text-align: right;">Amount</th>
                                                        <th style="text-align: right;">Total Price</th>
                                                        <th style="text-align: right;">Total Discount</th>
                                                        <th style="text-align: right;">Last Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->items as $item)
                                                        <tr>
                                                            <td>{{ $item->product_name }}</td>
                                                            <td style="text-align: right;">
                                                                {{ number_format($item->price + $item->discount, 0, ',', '.') }}
                                                                đ
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ number_format($item->discount, 0, ',', '.') }} đ
                                                            </td>
                                                            <td style="text-align: right;">{{ $item->amount }}
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ number_format(($item->price + $item->discount) * $item->amount, 0, ',', '.') }}
                                                                đ
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ number_format($item->discount * $item->amount, 0, ',', '.') }}
                                                                đ
                                                            </td>
                                                            <td style="text-align: right;">
                                                                {{ number_format($item->price * $item->amount, 0, ',', '.') }}
                                                                đ
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="6"></td>
                                                        <td style="text-align: right;">
                                                            {{ number_format($order->total, 0, ',', '.') }} VND</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <br>
                                            <div style="float: right">
                                                @if ($order->payment_method == 'Thanh toán qua VN Pay' && $order->payment_status == 'Chưa thanh toán')
                                                    <button type="button" class="btn btn-primary">Repayment</button>
                                                @endif
                                                @if ($order->status_id == 8 || $order->status_id == 5 || $order->status_id == 6)
                                                    <button type="button" class="btn btn-success">Re-order</button>
                                                @endif
                                                @if ($order->status_id < 3)
                                                    <button type="button" class="btn btn-danger">Cancel</button>
                                                @endif
                                                @if ($order->status_id == 7)
                                                    <button type="button" class="btn btn-warning">No order
                                                        cancellation</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('custom-script')
    <script type="text/javascript">
        $(document).ready(function() {
            $("a.nav-link").click(function(e) {
                e.preventDefault();

                // Kiểm tra nếu liên kết được nhấp là "Logout"
                if ($(this).attr("id") === "logout" || $(this).attr("id") === "home") {
                    window.location.href = $(this).attr("href");
                } else {
                    var targetSection = $(this).attr("href");

                    // Loại bỏ lớp 'active' khỏi tất cả các liên kết
                    $("a.nav-link").removeClass("active");

                    // Thêm lớp 'active' cho liên kết được nhấp
                    $(this).addClass("active");

                    // Loại bỏ lớp 'show active' khỏi tất cả các tab-pane
                    $(".tab-pane").removeClass("show active");

                    // Hiển thị tab-pane tương ứng và cập nhật màu chữ
                    $(targetSection).addClass("show active");
                }
            });
        });
    </script>
@endpush
