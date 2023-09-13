@extends('admin.layout.layout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Order list</h4>
                    <h6>Manage Order</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('orders.create') }}" class="btn btn-added">
                        <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Order
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
            @elseif ($errors->has('common'))
                <div class="alert alert-danger" id="alert" style="position: relative;">
                    <ul>
                        @foreach ($errors->get('common') as $error)
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
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                            src="{{ asset('admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                            src="{{ asset('admin/assets/img/icons/excel.svg') }}" alt="img"></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                            src="{{ asset('admin/assets/img/icons/printer.svg') }}" alt="img"></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter Brand Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter Brand Description">
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
                        <table class="table datanew" id="orders-table">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Order Code</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr data-order-id="{{ $order->id }}">
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a
                                                href="javascript:void(0);">{{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}</a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);">{{ $order->name }}</a>
                                        </td>
                                        <td>{{ $order->phone_number }}</td>
                                        <td>{{ $order->house . ', ' . $order->street . ', ' . $order->ward->name . ', ' . $order->district->name . ', ' . $order->province->name }}
                                        </td>
                                        <td>{{ $order->payment_method }}</td>
                                        <td>{{ $order->payment_status }}</td>
                                        <td>
                                            <select class="disabled-results form-control form-small order-status-select">
                                                @foreach ($statuses as $status)
                                                    @php
                                                        $isDisabled = in_array($status->id, $statusDisabledMap[$order->status_id]);
                                                    @endphp

                                                    <option value="{{ $status->id }}"
                                                        {{ $status->id == $order->status_id ? 'selected' : '' }}
                                                        {{ $isDisabled ? 'disabled' : '' }}>{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>{{ $order->created_at->format('H:i:s d/m/Y') }}</td>
                                        <td>
                                            <a class="me-3" href="{{ route('orders.show', ['id' => $order->id]) }}">
                                                <img src="{{ asset('admin/assets/img/icons/eye.svg') }}" alt="img">
                                            </a>
                                            @if ($order->status_id < 3)
                                                <a class="me-3" href="{{ route('orders.edit', ['id' => $order->id]) }}">
                                                    <img src="{{ asset('admin/assets/img/icons/edit.svg') }}"
                                                        alt="img">
                                                </a>
                                            @endif

                                            @if ($order->status_id == 7)
                                                <a
                                                    href="#"onclick="event.preventDefault(); cancelorder('{{ route('orders.cancel', ['id' => $order->id]) }}')">
                                                    <img src="{{ asset('admin/assets/img/icons/allow.svg') }}"
                                                        alt="img" style="width: 24px; height: 24px">
                                                </a>
                                                <a
                                                    href="#"onclick="event.preventDefault(); notcancel('{{ route('orders.notCancel', ['id' => $order->id]) }}')">
                                                    <img src="{{ asset('admin/assets/img/icons/not-allow.svg') }}"
                                                        alt="img" style="width: 24px; height: 24px">
                                                </a>
                                            @elseif($order->status_id < 3)
                                                <a
                                                    href="#"onclick="event.preventDefault(); cancelorder('{{ route('orders.cancel', ['id' => $order->id]) }}')">
                                                    <img src="{{ asset('admin/assets/img/icons/delete.svg') }}"
                                                        alt="img" style="width: 24px; height: 24px">
                                                </a>
                                            @endif
                                            @if ($order->status_id == 8 || $order->status_id == 6)
                                                <a
                                                    href="#"onclick="event.preventDefault(); cancelorder('{{ route('orders.initialization', ['id' => $order->id]) }}')">
                                                    <img src="{{ asset('admin/assets/img/icons/return1.svg') }}"
                                                        alt="img" style="width: 24px; height: 24px">
                                                </a>
                                            @endif
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
    <form action="" method="post" id="cancel-form">
        @csrf
        @method('put')
    </form>
    <form action="" method="post" id="not-cancel-form">
        @csrf
        @method('put')
    </form>
    <form action="" method="post" id="initialization-form">
        @csrf
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
            $('#orders-table').on('change', '.order-status-select', function() {
                var selectedStatusId = $(this).val();
                var orderId = $(this).closest('tr').data('order-id');
                var selectElement = $(this);

                $.ajax({
                    url: '{{ route('orders.status') }}',
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_id: orderId,
                        status_id: selectedStatusId
                    },
                    success: function(response) {
                        if (response.success) {
                            selectElement.html(response.html);
                        } else {
                            console.error('Update status failed.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', error);
                    }
                });
            });
        });

        function cancelorder(url) {
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
                    $('#cancel-form').attr('action', url);
                    $('#cancel-form').submit();
                }
            });
        }

        function notcancel(url) {
            Swal.fire({
                title: 'Không cho phép hủy?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, not cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set the correct action for the delete form using jQuery
                    $('#not-cancel-form').attr('action', url);
                    $('#not-cancel-form').submit();
                }
            });
        }

        function initialization(url) {
            Swal.fire({
                title: 'khởi tạo đơn hàng ?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set the correct action for the delete form using jQuery
                    $('#initialization').attr('action', url);
                    $('#initialization').submit();
                }
            });
        }
    </script>
@endpush
