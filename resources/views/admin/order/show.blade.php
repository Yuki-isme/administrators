@extends('admin.layout.layout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Order Details</h4>
                    <h6>Full details of a order</h6>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="productdetails">
                                <ul class="product-bar">
                                    <li>
                                        <h4>Order Code</h4>
                                        <h6>{{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}</h6>
                                    </li>
                                    <li>
                                        <h4>Name</h4>
                                        <h6>{{ $order->name }}</h6>
                                    </li>
                                    <li>
                                        <h4>Phone</h4>
                                        <h6>{{ $order->phone_number }}</h6>
                                    </li>
                                    <li>
                                        <h4>Email</h4>
                                        <h6>{{ $order->email }}</h6>
                                    </li>
                                    <li>
                                        <h4>Address</h4>
                                        <h6>{{ $order->house . ', ' . $order->street . ', ' . $order->ward->name . ', ' . $order->district->name . ', ' . $order->province->name }}
                                        </h6>
                                    </li>
                                    <li>
                                        <h4>Note</h4>
                                        <h6>{{ $order->note }}</h6>
                                    </li>
                                    <li>
                                        <h4>Payment Method</h4>
                                        <h6>{{ $order->payment_method }}</h6>
                                    </li>
                                    <li>
                                        <h4>Payment Status</h4>
                                        <h6>{{ $order->payment_status }}</h6>
                                    </li>
                                    <li>
                                        <h4>Note Order</h4>
                                        <h6>{{ $order->note_order }}</h6>
                                    </li>
                                    <li>
                                        <h4>Total</h4>
                                        <h6>{{ number_format($order->total, 0, ',', '.') }} VND</h6>
                                    </li>
                                    <li>
                                        <h4><span style="font-weight: bold">Products</span></h4>
                                        <h6>
                                            <div class="search-set">
                                                <div class="search-input">
                                                    <a class="btn btn-searchset"><img
                                                            src="{{ asset('admin/assets/img/icons/search-white.svg') }}"
                                                            alt="img"></a>
                                                </div>
                                            </div>
                                        </h6>
                                    </li>
                                </ul>

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
                                            <th>Price</th>
                                            <th>Discount</th>
                                            <th>Amount</th>
                                            <th>Total</th>
                                            <th>Total discount</th>
                                            <th>Last Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td>
                                                    <label class="checkboxs">
                                                        <input type="checkbox">
                                                        <span class="checkmarks"></span>
                                                    </label>
                                                </td>
                                                <td class="productimgname">
                                                    <a href="{{ route('products.show', ['id' => $item->product_id]) }}"
                                                        class="product-img">
                                                        <img src="{{ asset('storage/' . $item->product->thumbnail->url) }}"
                                                            alt="product">
                                                    </a>
                                                    <a
                                                        href="{{ route('products.show', ['id' => $item->product_id]) }}">{{ $item->product_name }}</a>
                                                </td>
                                                <td>{{ $item->price + $item->discount }}</td>
                                                <td>{{ $item->discount }}</td>
                                                <td>{{ $item->amount }}</td>
                                                <td>{{ $item->price * $item->amount + $item->discount * $item->amount }}
                                                </td>
                                                <td>{{ $item->discount * $item->amount }}</td>
                                                <td>{{ $item->price * $item->amount }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
    </script>
@endpush
