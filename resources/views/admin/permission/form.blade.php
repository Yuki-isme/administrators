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
                        action="{{ isset($permission) ? route('permissions.update', $permission->id) : route('permissions.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @isset($permission)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-lg-11 col-sm-11 col-12">
                                <div class="form-group">
                                    <label>Permission Name</label>
                                    <input type="text" name="name" value="{{ $permission->name ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label>Is Active</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" role="switch"
                                            value="1"
                                            {{ isset($permission) ? ($permission->is_active == 1 ? 'checked' : '') : 'checked' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" required>{{ $permission->description ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="custom-file-container" data-upload-id="myFirstImage">
                                        <label>Upload (Single File) <a href="javascript:void(0)"
                                                class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                        <label class="custom-file-container__custom-file">
                                            <input name="thumbnail" type="file"
                                                class="custom-file-container__custom-file__custom-file-input"
                                                accept="image/*">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>
                                        <div class="custom-file-container__image-preview"></div>
                                    </div>
                                </div>
                            </div>
                            @isset($permission)
                                <div class="col-lg-12">
                                    <div class="product-list">
                                        <ul class="row">
                                            <li class="ps-0">
                                                <div class="productviews">
                                                    <div class="productviewsimg">
                                                        <img src="{{ asset('admin/assets/img/permission/' . $permission->path_img) }}"alt="product"width="40"
                                                            height="40">
                                                    </div>
                                                    <div class="productviewscontent">
                                                        <div class="productviewsname">
                                                            <p>{{ $permission->path_img }}</p>
                                                        </div>
                                                        <a href="javascript:void(0);" class="hideset">x</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endisset
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
                            <div class="col-lg-11 col-sm-11 col-12">
                                <div class="form-group">
                                    <label>Permission Name</label>
                                    <input type="text" name="name" value="{{ $permission->name ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label>Is Active</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" role="switch"
                                            value="1"
                                            {{ isset($permission) ? ($permission->is_active == 1 ? 'checked' : '') : 'checked' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" required>{{ $permission->description ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="custom-file-container" data-upload-id="myFirstImage">
                                        <label>Upload (Single File) <a href="javascript:void(0)"
                                                class="custom-file-container__image-clear"
                                                title="Clear Image">x</a></label>
                                        <label class="custom-file-container__custom-file">
                                            <input name="thumbnail" type="file"
                                                class="custom-file-container__custom-file__custom-file-input"
                                                accept="image/*">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>
                                        <div class="custom-file-container__image-preview"></div>
                                    </div>
                                </div>
                            </div>
                            @isset($permission)
                                <div class="col-lg-12">
                                    <div class="product-list">
                                        <ul class="row">
                                            <li class="ps-0">
                                                <div class="productviews">
                                                    <div class="productviewsimg">
                                                        <img src="{{ asset('admin/assets/img/permission/' . $permission->path_img) }}"alt="product"width="40"
                                                            height="40">
                                                    </div>
                                                    <div class="productviewscontent">
                                                        <div class="productviewsname">
                                                            <p>{{ $permission->path_img }}</p>
                                                        </div>
                                                        <a href="javascript:void(0);" class="hideset">x</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endisset
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
