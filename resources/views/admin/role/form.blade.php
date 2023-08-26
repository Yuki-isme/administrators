@extends('admin.layout.layout')

@section('content')

    <div class="page-wrapper">

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product {{ isset($role) ? 'Edit' : 'Add' }} Role</h4>
                    <h6>{{ isset($role) ? 'Edit' : 'Add' }} Role</h6>
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
                        action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @isset($role)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Role Name</label>
                                    <input type="text" name="name" value="{{ $role->name ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Permission</label>
                                    <select id="permissions" name="permissions[]" class="disabled-results form-control form-small" multiple>
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}"
                                                {{ isset($role) && in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'Selected' : '' }}>
                                                {{ $permission->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>User</label>
                                    <select id="admins" name="admins[]" class="disabled-results form-control form-small"
                                        multiple>
                                        @foreach ($admins as $admin)
                                            <option value="{{ $admin->id }}" {{ isset($role) && in_array($admin->id, $role->admins->pluck('id')->toArray()) ? 'Selected' : '' }}>
                                                {{ $admin->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-submit me-2" value="Submit">
                                    <a href="{{ route('roles.index') }}" class="btn btn-cancel">Cancel</a>
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
