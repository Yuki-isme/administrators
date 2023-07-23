@extends('admin.layout.layout')

@section('content')

    <div class="page-wrapper">

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product {{ isset($category) ? 'Edit' : 'Add' }} Category</h4>
                    <h6>{{ isset($category) ? 'Edit' : 'Add' }} Category</h6>
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
                        action="{{ isset($category) ? ( isset($sub) ? route('categories.sub_update', $category->id) : route('categories.update', $category->id) ) : ( isset($sub) ? route('categories.sub_store') : route('categories.store') ) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @isset($category)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" name="name" value="{{ $category->name ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Slug</label>
                                    <input type="text" name="slug" value="{{ $category->slug ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Parent Category</label>
                                    <select name="parent_id" class="disabled-results form-control form-small">
                                        <option value="0">No Parent</option>
                                        @isset($sub)
                                            @foreach ($parents as $parent)
                                                <option value="{{ $parent->id }}" {{ isset($category) && $category->parent_id == $parent->id ? 'Selected' : '' }} {{ $parent->is_active == 0 ? 'Disabled' : '' }}> {{ $parent->name }} </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label>Is Active</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" role="switch" value="1"
                                            {{ isset($category) ? ($category->is_active == 1 ? 'checked' : '') : 'checked' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" required>{{ $category->description ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Product Image</label>
                                    <div class="image-upload">
                                        <input type="file" name="img">
                                        <div class="image-uploads">
                                            <img src="{{ asset('admin/assets/img/icons/upload.svg') }}" alt="img"
                                                required>
                                            <h4>Drag and drop a file to upload</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @isset($category)
                                <div class="col-lg-12">
                                    <div class="product-list">
                                        <ul class="row">
                                            <li class="ps-0">
                                                <div class="productviews">
                                                    <div class="productviewsimg">
                                                        <img src="{{ asset('admin/assets/img/category/' . $category->path_img) }}"alt="product"width="40"
                                                            height="40">
                                                    </div>
                                                    <div class="productviewscontent">
                                                        <div class="productviewsname">
                                                            <p>{{ $category->path_img }}</p>
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
                                    <a href="{{ isset($sub) ? route('categories.sub_index') : route('categories.index') }}" class="btn btn-cancel">Cancel</a>
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
