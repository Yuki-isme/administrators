@extends('admin.layout.layout')

@section('content')
    {{-- {{dd($product->tags)}} --}}
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
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" name="name" value="{{ $product->name ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select id="parent_id" name="parent_id"
                                        class="disabled-results form-control form-small">

                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->is_active == 0 ? 'Disabled' : '' }}> {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Sub Category</label>
                                    <select id="category_id" name="category_id"
                                        class="disabled-results form-control form-small">
                                        <option value="0">No category</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Brand</label>
                                    <select name="brand_id" class="disabled-results form-control form-small">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ isset($product) && $product->brand_id == $brand->id ? 'Selected' : '' }}
                                                {{ $brand->is_active == 0 ? 'Disabled' : '' }}> {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Tags</label>
                                    <select id="tags" name="tags[]"
                                        class="disabled-results form-control form-small"multiple>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>SKU</label>
                                    <input type="text" name="sku" value="{{ $product->sku ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Stock</label>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input class="form-control" type="number" name="stock"
                                                value="{{ $product->stock ?? '' }}">
                                            <span class="input-group-text">Item</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Price</label>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input class="form-control"
                                                type="number" name="price" value="{{ $product->price ?? '' }}"
                                                >
                                            <span class="input-group-text">VND</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label>Sale Price</label>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input class="form-control"
                                                type="number" name="sale_price" value="{{ $product->sale_price ?? '' }}"
                                                >
                                            <span class="input-group-text">VND</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label>Feature</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_feature"
                                                    role="switch" value="1"
                                                    {{ isset($product) ? ($product->feature == 1 ? 'checked' : '') : 'checked' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label>Active</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_active"
                                                    role="switch" value="1"
                                                    {{ isset($product) ? ($product->is_active == 1 ? 'checked' : '') : 'checked' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label>Hot</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_hot"
                                                    role="switch" value="1"
                                                    {{ isset($product) ? ($product->is_hot == 1 ? 'checked' : '') : 'checked' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-12">
                                <div class="form-group d-flex justify-content-center align-items-center h-100">
                                    <div class="col-lg-12 text-center"> <!-- Thêm class text-center -->
                                        <div class="input-group">
                                            <button type="button" class="btn btn-info me-2" id="addAttributeField">Add
                                                Attribute</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="attributeFields" class="row">
                                @if (isset($product))
                                    @foreach ($product->attributeValue as $attribute)
                                        <div class="col-lg-6 col-sm-6 col-12 attributeField row">
                                            <div class="col-lg-4 col-sm-4 col-12">
                                                <div class="form-group">
                                                    <label for="attributesData[{{ $loop->index }}][name]">Attribute
                                                        Name:</label>
                                                    <input type="text"
                                                        name="attributesData[{{ $loop->index }}][name]"
                                                        value="{{ $attribute->attribute->name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="attributesData[{{ $loop->index }}][value]">Attribute
                                                        Value:</label>
                                                    <input type="text"
                                                        name="attributesData[{{ $loop->index }}][value]"
                                                        value="{{ $attribute->value }}" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-2 col-12">
                                                <div class="form-group">
                                                    <label>Remove:</label>
                                                    <button type="button"
                                                        class="removeAttributeField btn btn-danger">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" id="desccription" name="description">{{ $product->description ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea class="form-control" id="content" name="content">{{ $product->content ?? '' }}</textarea>
                                </div>
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
                                                accept="image/*" {{ isset($product) ? '' : 'required' }}>

                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>
                                        <div class="custom-file-container__image-preview"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="custom-file-container" data-upload-id="mySecondImage">
                                        <label>Upload catalog (Allow Multiple)
                                            <a href="javascript:void(0)" class="custom-file-container__image-clear"
                                                title="Clear Image">x</a></label>
                                        <label class="custom-file-container__custom-file">
                                            <input name="catalog[]" type="file"
                                                class="custom-file-container__custom-file__custom-file-input" multiple
                                                accept="image/*" {{ isset($product) ? '' : 'required' }} />

                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>
                                        <div class="custom-file-container__image-preview"></div>
                                    </div>
                                </div>
                            </div>

                            @isset($product)
                                <div class="col-lg-12">
                                    <div class="product-list">
                                        <ul class="row">
                                            <li class="ps-0" data-media-id="{{ $product->thumbnail->id }}">
                                                <div class="productviews">
                                                    <div class="productviewsimg">
                                                        <img src="{{ asset('storage/' . $product->thumbnail->url) }}"
                                                            alt="product" width="40" height="40">
                                                    </div>
                                                    <div class="productviewscontent">
                                                        <div class="productviewsname">
                                                            <p>{{ $product->thumbnail->title }}</p>
                                                            <input type="hidden" name="thumbnail_update"
                                                                value="{{ $product->thumbnail->id }}">
                                                        </div>
                                                        <a href="javascript:void(0);" class="hideset">x</a>
                                                    </div>
                                                </div>
                                            </li>
                                            @foreach ($product->media as $media)
                                                <li class="ps-0" data-media-id="{{ $media->id }}">
                                                    <div class="productviews">
                                                        <div class="productviewsimg">
                                                            <img src="{{ asset('storage/' . $media->url) }}" alt="product"
                                                                width="40" height="40">
                                                        </div>
                                                        <div class="productviewscontent">
                                                            <div class="productviewsname">
                                                                <p>{{ $media->title }}</p>
                                                                <input type="hidden" name="catalog_update[]"
                                                                    value="{{ $media->id }}">
                                                            </div>
                                                            <a href="javascript:void(0);" class="hideset">x</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endisset

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-submit me-2" value="Submit">
                                    <a href="{{ route('products.index') }}" class="btn btn-cancel">Cancel</a>

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
            var categorySelect = $('#category_id');

            // Thiết lập Select2 cho sub category
            categorySelect.select2({
                ajax: {
                    url: '{{ route('categories.get-children') }}',
                    data: function(params) {
                        var parentId = $('#parent_id').val();

                        var query = {
                            term: params.term,
                            parent_id: parentId,
                            _token: '{{ csrf_token() }}'
                        };

                        return query;
                    },
                    dataType: 'json',
                    processResults: function(data) {
                        // Thêm tùy chọn "No category" nếu parent_id là 0
                        var parentId = $('#parent_id').val();
                        if (parentId == '0') {
                            categorySelect.empty(); // Xóa toàn bộ tùy chọn hiện có
                            categorySelect.append('<option value="0">No category</option>');
                        }

                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    }
                }
            });

            $('#parent_id').change(function() {
                // Xóa tất cả tùy chọn hiện có trong category_id
                categorySelect.empty();

                // Thêm tùy chọn "No category" nếu parent_id là 0
                var parentId = $('#parent_id').val();
                if (parentId == '0') {
                    categorySelect.append('<option value="0">No category</option>');
                }

                // Triggers a change event to reload the select2 data
                categorySelect.trigger('change');
            });



            var subid = '{{ $product->category_id ?? '' }}';
            var subvalue = '{{ isset($product->category) ? $product->category->name : '' }}';

            if (subid) {
                $.ajax({
                    url: '{{ route('categories.get-parent') }}',
                    data: {
                        childId: subid,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            // Lấy thông tin parent category
                            var parentCategory = response;

                            // Lặp qua tất cả các option trong dropdown
                            $('#parent_id option').each(function() {
                                // Nếu giá trị của option trùng với ID của parent category
                                if ($(this).val() == parentCategory.id) {
                                    // Đặt thuộc tính 'selected' cho option này
                                    $(this).attr('selected', 'selected');
                                }
                            });

                            // Cập nhật select2 cho #parent_id
                            $('#parent_id').select2();

                            // Tạo option cho #category_id
                            var option = new Option(subvalue, subid, true, true);
                            $('#category_id').append(option).trigger('change');
                        }
                    }
                });
            }



        });

        $(document).ready(function() {
            $('#tags').select2({
                tags: true,
                ajax: {
                    url: '{{ route('tags.getTags') }}',
                    data: function(params) {
                        var query = {
                            q: params.term,
                            page: params.page || 1,
                            _token: '{{ csrf_token() }}'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    dataType: 'json',
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.data,
                            pagination: {
                                more: params.page < data.lastPage,
                            }
                        }
                    }
                },
            })

            @if (isset($product))
                var productTags = @json($product->tags->pluck('id'));
                var productTagNames = @json($product->tags->pluck('name'));
                var tagsSelect = $('#tags');

                $.each(productTags, function(index, tagId) {
                    var option = new Option(productTagNames[index], tagId, true, true);
                    tagsSelect.append(option).trigger('change');
                });
            @endif

        })


        $(document).ready(function() {
            let attributeIndex = {{ isset($product) ? count($product->attributeValue) : 1 }};

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
        });



        tinymce.init({
            selector: 'textarea', // change this value according to your HTML
            plugins: 'image wordcount',
            toolbar: 'undo redo | blocks | link image | bold italic | alignleft aligncentre alignright alignjustify | indent outdent | bullist numlist',
            images_upload_url: '{{ route('upload-image') }}'
        });

        // Bắt sự kiện khi bấm vào nút "x"
        $('.hideset').on('click', function() {
            // Lấy media-id từ thuộc tính data-media-id của thẻ cha <li>
            var mediaId = $(this).closest('li').data('media-id');

            // Xóa thẻ <li> khỏi DOM
            $(this).closest('li').remove();

            // Xóa mediaId khỏi mảng catalog_update
            var index = catalogUpdate.indexOf(mediaId);
            if (index !== -1) {
                catalogUpdate.splice(index, 1);
            }
        });
    </script>
@endpush
