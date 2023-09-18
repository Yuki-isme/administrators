@extends('admin.layout.layout')

@section('content')
    <div class="page-wrapper">

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product {{ isset($user) ? 'Edit' : 'Add' }} Admin</h4>
                    <h6>{{ isset($user) ? 'Edit' : 'Add' }} Admin</h6>
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
                        action="{{ isset($user) ? route('admins.update', $user->id) : route('admins.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @isset($user)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ $user->name ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>User Name Log In</label>
                                    <input type="text" name="username" value="{{ $user->username ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" value="{{ $user->phone ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" value="{{ $user->email ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm">
                                </div>
                            </div>
                            @if (isset($user))
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Address list</label>
                                        <select name="" class="disabled-results form-control form-small">

                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-submit me-2" value="Submit">
                                    <a href="{{ route('admins.index') }}" class="btn btn-cancel">Cancel</a>
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
    </script>
@endpush
