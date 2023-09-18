@extends('admin.layout.layout')

@section('content')

    <div class="page-wrapper">

        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product {{ isset($tag) ? 'Edit' : 'Add' }} Tag</h4>
                    <h6>{{ isset($tag) ? 'Edit' : 'Add' }} Tag</h6>
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
                        action="{{ isset($tag) ? route('tags.update', $tag->id) : route('tags.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @isset($tag)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Tag Name</label>
                                    <input type="text" name="name" value="{{ $tag->name ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-lg-8 col-sm-8 col-12">
                                <div class="form-group">
                                    <label>Product</label>
                                    <select id="admins" name="products[]" class="disabled-results form-control form-small"
                                        multiple>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ isset($tag) && in_array($product->id, $tag->products->pluck('id')->toArray()) ? 'Selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-submit me-2" value="Submit">
                                    <a href="{{ route('tags.index') }}" class="btn btn-cancel">Cancel</a>
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
