@extends('admin.layout.layout')

@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Admin list</h4>
                    <h6>Manage your Admin</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admins.create') }}" class="btn btn-added">
                        <img src="{{ asset('admin/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Admin
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success" id="alert">
                    {{ session('success') }}
                    <button type="button" class="close-alert" id="close-alert"
                        style="position: absolute; top: 50%; right: 0; transform: translateY(-50%);">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif (session('alert'))
                <div class="alert alert-danger" id="alert">
                    {{ session('alert') }}
                    <button type="button" class="close-alert" id="close-alert"
                        style="position: absolute; top: 50%; right: 0; transform: translateY(-50%);">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif ($errors->has('common'))
                <div class="alert alert-danger" id="alert" style="position: relative;">
                    <ul>
                        @foreach ($errors->get('common') as $error)
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
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">
                                <a class="btn btn-filter" id="filter_search">
                                    <img src="{{ asset('admin/assets/img/icons/filter.svg') }}" alt="img">
                                    <span><img src="{{ asset('admin/assets/img/icons/closes.svg') }}" alt="img"></span>
                                </a>
                            </div>
                            <div class="search-input">
                                <a class="btn btn-searchset"><img
                                        src="{{ asset('admin/assets/img/icons/search-white.svg') }}" alt="img"></a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                            src="{{ asset('admin/assets/img/icons/pdf.svg') }}" alt="img"></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                            src="{{ asset('admin/assets/img/icons/excel.svg') }}" alt="img"></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                            src="{{ asset('admin/assets/img/icons/printer.svg') }}" alt="img"></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter Admin Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter Admin Description">
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                    <div class="form-group">
                                        <a class="btn btn-filters ms-auto"><img
                                                src="{{ asset('admin/assets/img/icons/search-whites.svg') }}"
                                                alt="img"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Admin name</th>
                                    <th>Role</th>
                                    <th>Permission</th>
                                    <th>Create At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ implode(', ', $admin->roles->pluck('name')->toArray()) }}</td>
                                        <td>{{ ucwords(str_replace('_', ' ', implode(', ', $admin->allPermissions()->toArray()))) }} </td>
                                        <td>
                                            {{-- {{ $admin->created_at->format('H:i:s d/m/Y') }} --}}
                                        </td>
                                        <td>
                                            <a class="me-3" href="{{ route('admins.edit', ['id' => $admin->id]) }}">
                                                <img src="{{ asset('admin/assets/img/icons/edit.svg') }}" alt="img">
                                            </a>

                                            <a class="me-3"
                                                href="#"onclick="event.preventDefault(); deleteAdmin('{{ route('admins.destroy', ['id' => $admin->id]) }}')">
                                                <img src="{{ asset('admin/assets/img/icons/delete.svg') }}" alt="img">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <form action="" method="post" id="delete-form">
        @csrf
        @method('delete')
    </form>

@endsection

@push('custom-script')
    <script>
        $(document).ready(function() {

            $('#close-alert').on('click', function() {
                $('#alert').hide();
            });
        });


        function deleteAdmin(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set the correct action for the delete form using jQuery
                    $('#delete-form').attr('action', url);
                    $('#delete-form').submit();
                }
            });
        }
    </script>
@endpush
