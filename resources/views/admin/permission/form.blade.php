@extends('admin.layout.layout')

@section('content')

    <div class="page-wrapper">

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product {{ isset($permission) ? 'Edit' : 'Add' }} Permission</h4>
                    <h6>{{ isset($permission) ? 'Edit' : 'Add' }} Permission</h6>
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
                        action="{{ route('permissions.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Permission Name</label>
                                    <input type="text" name="set_of_name" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="roles[]" class="disabled-results form-control form-small"
                                        multiple>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" >
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-submit me-2" value="Submit">
                                    <a href="{{ route('permissions.index') }}" class="btn btn-cancel">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="post"
                        action="{{ isset($permission) ? route('permissions.update', $permission->id) : route('permissions.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @isset($permission)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Permission Name</label>
                                    <input type="text" name="name" value="{{ $permission->name ?? '' }}" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="roles[]" class="disabled-results form-control form-small"
                                        multiple>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" >
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-submit me-2" value="Submit">
                                    <a href="{{ route('permissions.index') }}" class="btn btn-cancel">Cancel</a>
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
