<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="description" content="POS - Bootstrap Admin Template" />
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects" />
    <meta name="author" content="Dreamguys - Bootstrap Admin Template" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Login - Pos admin template</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon.jpg') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/all.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}" />
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-logo">
                            <img src="{{ asset('admin/assets/img/logo.png') }}" />
                        </div>
                        <div class="login-userheading">
                            <h3>Sign In</h3>
                            <h4>Please login to your account</h4>
                        </div>
                        <form action="{{ route('admin.auth') }}" method="POST">
                            @csrf
                            <div class="form-login">
                                <label>User Name</label>
                                <div class="form-addons">
                                    <input name="username" type="text" placeholder="Enter your user name" />
                                    <img src="{{ asset('admin/assets/img/icons/mail.svg') }}" />
                                </div>
                            </div>
                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input name="password" type="password" class="pass-input"
                                        placeholder="Enter your password" />
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                            <div class="form-login">
                                <div class="alreadyuser">
                                    <h4>
                                        <a href="forgetpassword.html" class="hover-a">Forgot Password?</a>
                                    </h4>
                                </div>
                            </div>
                            @if ($errors->has('login'))
                                <div class="alert alert-danger" id="alert" style="position: relative;">
                                    <ul>
                                        @foreach ($errors->get('login') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close-alert" id="close-alert"
                                        style="position: absolute; top: 50%; right: 0; transform: translateY(-50%);">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="form-login">
                                <input type="submit" class="btn btn-login" value="Sign In">
                            </div>
                        </form>
                        {{-- <div class="signinform text-center">
                            <h4>
                                Don’t have an account?
                                <a href="signup.html" class="hover-a">Sign Up</a>
                            </h4>
                        </div>
                        <div class="form-setlogin">
                            <h4>Or sign up with</h4>
                        </div>
                        <div class="form-sociallink">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('admin/assets/img/icons/google.png') }}" class="me-2"
                                            alt="google" />
                                        Sign Up using Google
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('admin/assets/img/icons/facebook.png') }}" class="me-2"
                                            alt="google" />
                                        Sign Up using Facebook
                                    </a>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
                <div class="login-img">
                    <img src="{{ asset('admin/assets/img/login.jpg') }}" />
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/feather.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/script.js') }}"></script>

    <script>
        $(document).ready(function() {

            $('#close-alert').on('click', function() {
                $('#alert').hide();
            });
        });
    </script>
</body>

</html>
