<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Sign in | Sign up</title>
    <link rel="icon" href="img/mdb-favicon.ico" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="{{ asset('frontend/css/mdb.min.css') }}" />
    <!-- Custom styles -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />

    <style>
        .alert {
            max-width: 100%;
            margin: 0 auto;
            position: relative;
            margin-bottom: 20px;
        }

        .close-alert {
            border: none;
            background-color: transparent;
            color: inherit;
            font-size: 1.5rem;
            position: absolute;
            top: 50%;
            right: 1000;
            transform: translateY(-50%);
        }
    </style>
</head>

<body>
    <!--Main Navigation-->
    <header>
        <!-- Background image -->
        <div id="intro" class="bg-image shadow-2-strong">
            <div class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-md-8">
                            <div class="bg-white rounded-5 shadow-5-strong p-5">
                                <ul class="nav nav-tabs mb-4">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('login') }}">Sign In</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">Sign Up</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="signin-form">
                                        <!-- Sign In form content -->
                                        <form action="{{ route('auth') }}" method="POST">
                                            @csrf
                                            <div class="form-outline mb-4">
                                                <input name="username" type="text" id="form1Example1"
                                                    class="form-control" required />
                                                <label class="form-label" for="form1Example1">Login Name</label>
                                            </div>

                                            <div class="form-outline mb-4">
                                                <input name="password" type="password" id="form1Example2"
                                                    class="form-control" required />
                                                <label class="form-label" for="form1Example2">Password</label>
                                            </div>
                                            @if ($errors->has('login'))
                                                <div class="alert alert-danger" id="alert"
                                                    style="position: relative;">
                                                    <p class="close-alert" style="font-size: 14px">
                                                        {{ $errors->first('login') }}</p>
                                                    <button type="button" class="close-alert" id="close-alert"
                                                        style="position: absolute; top: 50%; right: 0; transform: translateY(-50%);">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            {{-- <div class="row mb-4">
                                                <div class="col d-flex justify-content-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="form1Example3" checked />
                                                        <label class="form-check-label" for="form1Example3">Remember
                                                            me</label>
                                                    </div>
                                                </div>

                                                <div class="col text-center">
                                                    <a href="#!">Forgot password?</a>
                                                </div>
                                            </div> --}}

                                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                                            <a href="{{ route('index')}}" class="btn btn-light btn-block">Back</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Background image -->
    </header>
    <!--Main Navigation-->

    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <!-- MDB -->
    <script type="text/javascript" src="{{ asset('frontend/js/mdb.min.js') }}"></script>
    <!-- Custom scripts -->
    <script type="text/javascript" src="{{ asset('frontend/js/script.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#close-alert').on('click', function() {
                $('#alert').hide();
            });
        });
    </script>
</body>

</html>
