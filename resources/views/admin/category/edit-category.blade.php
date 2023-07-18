@extends('admin.layout.layout')

@section('content')
    <div class="page-wrapper">

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Add Category</h4>
                    <h6>Edit Category</h6>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" id="error-alert" style="position: relative;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close-alert" id="close-error-alert"
                        style="position: absolute; top: 50%; right: 0; transform: translateY(-50%);">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Đặt phương thức PUT để cập nhật dữ liệu -->
                        <div class="row">
                            <div class="col-lg-5 col-sm-5 col-12">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" name="name" value="{{ $category->name }}">
                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-5 col-12">
                                <div class="form-group">
                                    <label>Slug</label>
                                    <input type="text" name="slug" value="{{ $category->slug }}">
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label>Is Active</label>
                                    <div class="checkbox">
                                        <label>
                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" @if($category->is_active == 1) checked @endif>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description">{{ $category->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Product Image</label>
                                    <div class="image-upload">
                                        <input type="file" name="img">
                                        <div class="image-uploads">
                                            <img src="{{ asset('admin/assets/img/icons/upload.svg') }}" alt="img">
                                            <h4>Drag and drop a file to upload</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="product-list">
                                    <ul class="row">
                                        <li class="ps-0">
                                            <div class="productviews">
                                                <div class="productviewsimg">
                                                    <img src="{{ asset('admin/assets/img/category/' . $category->path_img) }}"alt="product"width="40" height="40">
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
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-submit me-2" value="Submit">
                                    <a href="{{ route('categories.index') }}" class="btn btn-cancel">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection
