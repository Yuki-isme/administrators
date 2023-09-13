<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    {{-- <base href="{{ asset('frontend') }}"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Material Design for Bootstrap</title>
    <link rel="icon" href="{{ asset('frontend/img/mdb-favicon.ico') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <!-- Select 2 -->
    <link href="{{ asset('frontend/select2/css/select2.min.css') }}" rel="stylesheet" />
    <!-- Alert -->
    <link href="{{ asset('frontend/css/alertify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('frontend/css/default.min.css') }}" rel="stylesheet" />
    <!-- Alert -->
    <link href="{{ asset('frontend/css/slick.css') }}" rel="stylesheet" />
    <!-- MDB -->
    <link rel="stylesheet" href="{{ asset('frontend/css/mdb.min.css') }}" />
    <!-- Custom styles -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />

</head>

<body>
    <!--Main Navigation-->
    @include('frontend.layout.components.header')

    <main>
        @yield('content')
    </main>

    @include('frontend.layout.components.footer')
    <!-- MDB -->
    <script type="text/javascript" src="{{ asset('frontend/js/mdb.min.js') }}"></script>
    <!-- Jquery -->
    <script type="text/javascript" src="{{ asset('admin/assets/js/jquery-3.6.0.min.js') }}"></script>
    <!-- Select 2 -->
    <script type="text/javascript" src="{{ asset('frontend/select2/js/select2.min.js') }}"></script>
    <!-- Alert -->
    <script type="text/javascript" src="{{ asset('frontend/js/alertify.min.js') }}"></script>
    <!-- Slick -->
    <script type="text/javascript" src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <!-- Custom scripts -->
    <script type="text/javascript" src="{{ asset('frontend/js/script.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Bắt sự kiện khi nút được bấm
            $('#button-search').on('click', function() {
                // Lấy giá trị từ input
                var query = $('#search-product').val();

                // Kiểm tra nếu giá trị không rỗng
                if (query.trim() !== '') {
                    // Gán giá trị vào trường input ẩn trong form
                    $('#search-form input[name="q"]').val(query);

                    // Tự động submit form
                    $('#search-form').submit();
                }
            });
        });


        var timeoutId;

        $('#search-product').on('input', function() {
            // Lấy giá trị của ô input
            var query = $(this).val();

            // Kiểm tra nếu ô input rỗng, thì ẩn phần search-results và kết thúc
            if (query.trim() === '') {
                $('#search-results').hide();
                return;
            }

            // Gửi Ajax request khi người dùng nhập
            clearTimeout(timeoutId);
            timeoutId = setTimeout(function() {
                sendAjaxRequest(query);
            }, 50); // Sử dụng timeout để đợi người dùng nhập xong

            // Ẩn phần search-results khi bấm ra ngoài
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#search-product').length) {
                    $('#search-results').hide();
                }
            });
        });

        // Gửi Ajax request
        function sendAjaxRequest(query) {
            $.ajax({
                url: '{{ route('search') }}',
                method: 'GET',
                data: {
                    q: query
                },
                success: function(response) {
                    // Hiển thị kết quả tìm kiếm trong phần search-results
                    $('#search-results').html(response);

                    // Nếu có kết quả tìm kiếm, hiển thị phần search-results
                    if (response.trim() !== '') {
                        $('#search-results').show();
                    } else {
                        // Nếu không có kết quả tìm kiếm, ẩn phần search-results
                        $('#search-results').hide();
                    }
                }
            });
        }

        // Sử dụng sự kiện focus để gửi Ajax khi bấm trở lại ô input nếu có giá trị
        $('#search-product').on('focus', function() {
            var query = $(this).val();
            if (query.trim() !== '') {
                sendAjaxRequest(query);
            }
        });
    </script>
    @stack('custom-script')
</body>

</html>
