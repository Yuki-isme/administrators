@extends('frontend.layout.layout')

@section('content')
    <section class="bg-light">
        <div class="container mt-5">
            <div class="tab-content">

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
    </section>
@endsection

@push('custom-script')

@endpush
