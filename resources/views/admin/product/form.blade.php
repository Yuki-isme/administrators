@extends('admin.layout.layout')

@section('content')

    <div class="page-wrapper">

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product {{ isset($product) ? 'Edit' : 'Add' }} product</h4>
                    <h6>{{ isset($product) ? 'Edit' : 'Add' }} product</h6>
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
                        action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @isset($product)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" name="name" value="{{ $product->name ?? '' }}" required>
                                </div>
                            </div>
                            {{-- <div class="col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Slug</label>
                                    <input type="text" name="slug" value="{{ $product->slug ?? '' }}" required>
                                </div>
                            </div> --}}
                            <div class="col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select id="parent_id" name="parent_id"
                                        class="disabled-results form-control form-small">
                                        <option value="0">No category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ isset($product) && $product->category_id == $category->id ? 'Selected' : '' }}
                                                {{ $category->is_active == 0 ? 'Disabled' : '' }}> {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select id="category_id" name="category_id"
                                        class="disabled-results form-control form-small">
                                        <option value="0">No category</option>
                                        {{-- @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ isset($product) && $product->category_id == $category->id ? 'Selected' : '' }}
                                                {{ $category->is_active == 0 ? 'Disabled' : '' }}> {{ $category->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Brand</label>
                                    <select name="brand_id" class="disabled-results form-control form-small">
                                        <option value="0">No brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ isset($product) && $product->brand_id == $brand->id ? 'Selected' : '' }}
                                                {{ $brand->is_active == 0 ? 'Disabled' : '' }}> {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>SKU</label>
                                    <input type="text" name="sku" value="{{ $product->sku ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Stock</label>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input class="form-control" type="number" name="stock"
                                                value="{{ $product->stock ?? '' }}" required>
                                            <span class="input-group-text">$</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label>Price</label>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input class="form-control" aria-label="Amount (to the nearest dollar)"
                                                type="number" name="price" value="{{ $product->price ?? '' }}"
                                                step="0.01" required>
                                            <span class="input-group-text">$</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label>Feature</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_feature" role="switch"
                                            value="1"
                                            {{ isset($product) ? ($product->feature == 1 ? 'checked' : '') : 'checked' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label>Active</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" role="switch"
                                            value="1"
                                            {{ isset($product) ? ($product->is_active == 1 ? 'checked' : '') : 'checked' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-1 col-12">
                                <div class="form-group">
                                    <label>Hot</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_hot" role="switch"
                                            value="1"
                                            {{ isset($product) ? ($product->is_hot == 1 ? 'checked' : '') : 'checked' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" required>{{ $product->description ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea class="form-control" name="content" required>{{ $product->content ?? '' }}</textarea>
                                </div>
                            </div>
                            <div id="attributeFields" class="row">
                                @if (isset($product))
                                    @foreach ($product->attributeValue as $attribute)
                                        <div class="col-lg-6 col-sm-6 col-12 attributeField row">
                                            <div class="col-lg-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="attributesData[{{ $loop->index }}][name]">Attribute Name:</label>
                                                    <input type="text" name="attributesData[{{ $loop->index }}][name]" value="{{ $attribute->attribute->name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="attributesData[{{ $loop->index }}][value]">Attribute Value:</label>
                                                    <input type="text" name="attributesData[{{ $loop->index }}][value]" value="{{ $attribute->value }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-2 col-12">
                                                <div class="form-group">
                                                    <label>Remove:</label>
                                                    <button type="button" class="removeAttributeField btn btn-danger">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="custom-file-container" data-upload-id="myFirstImage">
                                        <label>Upload Image <a href="javascript:void(0)"
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

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="custom-file-container" data-upload-id="myFirstImage">
                                        <label>Upload catalog</label>
                                        <input name="catalog[]" type="file" class="form-control" accept="image/*"
                                            multiple>
                                    </div>
                                </div>
                            </div>

                            @isset($product)
                                <div class="col-lg-12">
                                    <div class="product-list">
                                        <ul class="row">
                                            <li class="ps-0">
                                                <div class="productviews">
                                                    <div class="productviewsimg">
                                                        <img src="{{ asset('admin/assets/img/product/' . $product->path_img) }}"alt="product"width="40"
                                                            height="40">
                                                    </div>
                                                    <div class="productviewscontent">
                                                        <div class="productviewsname">
                                                            <p>{{ $product->path_img }}</p>
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
                                    <a href="{{ route('products.index') }}" class="btn btn-cancel">Cancel</a>
                                    <button type="button" class="btn btn-info me-2" id="addAttributeField"
                                        style="height: 50.6px;">Add Attribute</button>
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

        $(document).ready(function() {
            // $('.select2').select2({
            //     theme: 'bootstrap-5'
            // });

            $('#category_id').select2({
                ajax: {
                    url: '{{ route('categories.get-children') }}',
                    data: function(params) {
                        var query = {
                            parent_id: $('#parent_id').val(),
                            _token: '{{ csrf_token() }}'
                        }

                        return query;
                    },
                    dataType: 'json',
                    processResults: function(data, params) {
                        return {
                            results: data,
                        }
                    }
                },
            })
        })

        $(document).ready(function() {
            let attributeIndex = {{ isset($product) ?  count($product->attributeValue) : 1}};

            $('#addAttributeField').on('click', function() {
                let attributeField = `
                    <div class="col-lg-6 col-sm-6 col-12 attributeField row">
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label for="attributesData[${attributeIndex}][name]">Attribute Name:</label>
                                <input type="text" name="attributesData[${attributeIndex}][name]" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="attributesData[${attributeIndex}][value]">Attribute Value:</label>
                                <input type="text" name="attributesData[${attributeIndex}][value]" required>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-12">
                            <div class="form-group">
                                <label>Remove:</label>
                                <button type="button" class="removeAttributeField btn btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                `;
                $('#attributeFields').append(attributeField);
                attributeIndex++;
            });

            $(document).on('click', '.removeAttributeField', function() {
                $(this).closest('.attributeField').remove();
            });

            // $('#productForm').submit(function(e) {
            //     e.preventDefault();
            //     let formData = new FormData(this);

            //     $.ajax({
            //         url: "{{ route('products.store') }}",
            //         type: "POST",
            //         data: formData,
            //         processData: false,
            //         contentType: false,
            //         success: function(data) {
            //             alert(data.message);
            //         },
            //         error: function(xhr, status, error) {
            //             if (xhr.responseJSON && xhr.responseJSON.error) {
            //                 alert(xhr.responseJSON.error);
            //             } else {
            //                 alert("An error occurred while saving the product.");
            //             }
            //         }
            //     });
            // });
        });
    </script>
@endpush
