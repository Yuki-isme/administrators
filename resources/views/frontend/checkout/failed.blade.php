@extends('frontend.layout.layout')

@section('content')
    <section class="bg-light py-5 my-5">
        <div class="container">
            <div class="text-center">
                <h1 class="text-center mb-4">Payment Failed</h1>
                <h5 class="text-center mb-4">We will contact you</h5>
                <button data-order-id="{{ $order_id }}" data-order-total="{{ $order_total }}" class="btn btn-warning text-white d-inline-block" id="repayment">Repayment</button>
                <a href="{{ route('list') }}" class="btn btn-success text-white d-inline-block ml-2">Continue shopping</a>
            </div>
        </div>
        <form action="{{ route('repayment') }}" method="post" id="repayment_form">
            @csrf
            <input type="hidden" name="order_id" id="repayment_id">
            <input type="hidden" name="order_total" id="repayment_total">
        </form>
    </section>
@endsection
@push('custom-script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.repayment', function(e) {
                $('#repayment_id').val($(this).data('order-id'));
                $('#repayment_total').val($(this).data('order-total'));
                $('#repayment_form').submit();
            })
        });
    </script>
@endpush