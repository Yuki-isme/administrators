@extends('frontend.layout.layout')

@section('content')
    <section class="bg-light">
        <div class="container mt-5">
            <div class="tab-content">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        @if (count($orders) > 0)
                            @foreach ($orders as $order)
                                <div class="card border mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Code Orders: {{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}
                                        </h5>
                                        <!-- All Orders form fields for Order 1 -->
                                        <div class="mb-3">
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
                                                        <td><a class="nav-link"
                                                                href="{{ route('productDetail', ['id' => $item->product_id]) }}"><img
                                                                    class="img-md img-thumbnail"
                                                                    style="width: 40px; height: 40px"
                                                                    src="{{ asset('storage/' . $item->product->thumbnail->url) }}">
                                                                {{ $item->product_name }}</a></td>
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
                                            @if (
                                                $order->payment_method == 'Thanh toán qua VN Pay' &&
                                                    $order->payment_status == 'Chưa thanh toán' &&
                                                    $order->status_id < 3)
                                                <button data-order-id="{{ $order->id }}"
                                                    data-order-total="{{ $order->total }}"
                                                    class="btn btn-primary repayment">Repayment</button>
                                            @endif
                                            {{-- @if ($order->status_id == 8 || $order->status_id == 5 || $order->status_id == 6)
                                                <button data-order-id="{{ $order->id }}"
                                                    class="btn btn-success re-order">Re-order</button>
                                            @endif --}}
                                            @if ($order->status_id < 3)
                                                <button data-order-id="{{ $order->id }}" type="button"
                                                    class="btn btn-danger cancel-order">Cancel</button>
                                            @endif
                                            @if ($order->status_id == 7)
                                                <button data-order-id="{{ $order->id }}" type="button"
                                                    class="btn btn-warning undo-cancel-order">Undo Cancel Order</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <section class="bg-light py-5 my-5">
                                <div class="container">
                                    <div class="d-flex flex-column align-items-center">
                                        <h1 class="text-center mb-4">No order</h1>
                                        <a href="{{ route('list') }}" class="btn btn-success text-white">Buy now</a>
                                    </div>
                                </div>
                            </section>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('repayment') }}" method="post" id="repayment_form">
            @csrf
            <input type="hidden" name="order_id" id="repayment_id">
            <input type="hidden" name="order_total" id="repayment_total">
        </form>
        <form action="{{ route('reorder') }}" method="post" id="reorder_form">
            @csrf
            <input type="hidden" name="order_id" id="reorder_id">
        </form>
        <form action="{{ route('customerCancel') }}" method="post" id="cancel_form">
            @csrf
            <input type="hidden" name="order_id" id="cancel_order_id">
        </form>
        <form action="{{ route('customerUndoCancel') }}" method="post" id="undo_cancel_form">
            @csrf
            <input type="hidden" name="order_id" id="undo_cancel_order_id">
        </form>
    </section>
@endsection

@push('custom-script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.repayment', function(e) {
                $('#repayment_id').val($(this).data('order-id'));
                $('#repayment_total').val($(this).data('order-total'));
                $('#repayment_form').submit();
            })
        });

        $(document).ready(function() {
            $(document).on('click', '.reorder', function(e) {
                $('#reorder_id').val($(this).data('order-id'));
                $('#reorder_form').submit();
            })
        });

        $(document).ready(function() {
            $(document).on('click', '.cancel-order', function(e) {
                Swal.fire({
                    title: 'Hủy đơn hàng này ?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Set the correct action for the delete form using jQuery
                        $('#cancel_order_id').val($(this).data('order-id'));
                        $('#cancel_form').submit();
                    }
                });
            })
        });

        $(document).ready(function() {
            $(document).on('click', '.undo-cancel-order', function(e) {
                Swal.fire({
                    title: 'Hoàn tác hủy đơn hàng này ?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Set the correct action for the delete form using jQuery
                        $('#undo_cancel_order_id').val($(this).data('order-id'));
                        $('#undo_cancel_form').submit();
                    }
                });
            })
        });
    </script>
@endpush
