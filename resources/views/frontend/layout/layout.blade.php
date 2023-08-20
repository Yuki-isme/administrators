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
  <!-- Custom scripts -->
  <script type="text/javascript" src="{{ asset('frontend/js/script.js') }}"></script>
</body>

</html>
