<header>
    <!-- Jumbotron -->
    <div class="p-3 text-center bg-white border-bottom">
        <div class="container">
            <div class="row gy-3">
                <!-- Left elements -->
                <div class="col-lg-2 col-sm-4 col-4">
                    <a href="https://mdbootstrap.com/" class="float-start">
                        <img src="https://mdbootstrap.com/img/logo/mdb-transaprent-noshadows.png" height="35" />
                    </a>
                </div>
                <!-- Left elements -->

                <!-- Center elements -->
                <div class="order-lg-last col-lg-5 col-sm-8 col-8">
                    <div class="d-flex float-end">
                        @if (Auth::guard('web')->check())
                            <a href="{{ route('myAccount') }}"
                                class="me-1 border rounded py-1 px-3 nav-link d-flex align-items-center"> <i
                                    class="fas fa-user-alt m-1 me-md-2"></i>
                                <p class="d-none d-md-block mb-0">{{ Auth::guard('web')->user()->name }}</p>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="me-1 border rounded py-1 px-3 nav-link d-flex align-items-center"> <i
                                    class="fas fa-user-alt m-1 me-md-2"></i>
                                <p class="d-none d-md-block mb-0">Sign in</p>
                            </a>
                        @endif
                        <a href="{{ route('myAccount') }}"
                            class="me-1 border rounded py-1 px-3 nav-link d-flex align-items-center"> <i
                                class="fas fa-heart m-1 me-md-2"></i>
                            <p class="d-none d-md-block mb-0">Wishlist</p>
                        </a>
                        <a href="{{ route('cart') }}"
                            class="border rounded py-1 px-3 nav-link d-flex align-items-center"> <i
                                class="fas fa-shopping-cart m-1 me-md-2"></i>
                            <p class="d-none d-md-block mb-0">My cart
                                ({{ cart()->getContent() ? count(cart()->getContent()) : 0 }})</p>
                        </a>
                    </div>
                </div>
                <!-- Center elements -->

                <!-- Right elements -->
                <div class="col-lg-5 col-md-12 col-12">
                    <div class="input-group float-center">
                        <div class="form-outline">
                            <input type="search" id="form1" class="form-control" />
                            <label class="form-label" for="form1">Search</label>
                        </div>
                        <button type="button" class="btn btn-primary shadow-0">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <!-- Right elements -->
            </div>
        </div>
    </div>
    <!-- Jumbotron -->

    @if (request()->routeIs('index'))
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <!-- Container wrapper -->
            <div class="container justify-content-center justify-content-md-between">
                <!-- Toggle button -->
                <button class="navbar-toggler border py-2 text-dark" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarLeftAlignExample" aria-controls="navbarLeftAlignExample"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarLeftAlignExample">
                    <!-- Left links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-dark" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">Hot offers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">Gift boxes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">Projects</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">Menu item</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="#">Menu name</a>
                        </li>
                        <!-- Navbar dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown"
                                role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                Others
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="#">Action</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Another action</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!-- Left links -->
                </div>
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
    @elseif(request()->routeIs('productDetail'))
        <!-- Heading -->
        <div class="bg-primary">
            <div class="container py-4">
                <!-- Breadcrumb -->
                <nav class="d-flex">
                    <h6 class="mb-0">
                        <a href="{{ route('index') }}" class="text-white-50">Home</a>
                        <span class="text-white-50 mx-2"> > </span>
                        <a href="{{ route('library') }}"
                            class="text-white{{ request()->routeIs('library') ? '' : '-50' }}">{!! request()->routeIs('cart') ? '<u>Library</u>' : 'Library' !!}</a>
                        @if (request()->routeIs('productDetail'))
                            <span class="text-white-50 mx-2"> > </span>
                            <a href="{{ route('productDetail', ['id', $productDetail->id]) }}"
                                class="text-white{{ request()->routeIs('productDetail') ? '' : '-50' }}"><u>Data</u></a>
                        @endif
                    </h6>
                </nav>
                <!-- Breadcrumb -->
            </div>
        </div>
        <!-- Heading -->
    @elseif(request()->routeIs('cart') || request()->routeIs('order') || request()->routeIs('payment'))
        <!-- Heading -->
        <div class="bg-primary">
            <div class="container py-4">
                <!-- Breadcrumb -->
                <nav class="d-flex">
                    <h6 class="mb-0">
                        <a href="{{ route('index') }}" class="text-white-50">Home</a>
                        <span class="text-white-50 mx-2"> > </span>
                        <a href="{{ route('cart') }}"
                            class="text-white{{ request()->routeIs('cart') ? '' : '-50' }}">{!! request()->routeIs('cart') ? '<u>2. Shopping cart</u>' : '2. Shopping cart' !!}</a>
                        <span class="text-white-50 mx-2"> > </span>
                        <a href="{{ route('order') }}"
                            class="text-white{{ request()->routeIs('order') ? '' : '-50' }}">{!! request()->routeIs('order') ? '<u>3. Order info</u>' : '3. Order info' !!}</a>
                        <span class="text-white-50 mx-2"> > </span>
                        <a href="{{ route('payment') }}"
                            class="text-white{{ request()->routeIs('payment') ? '' : '-50' }}">{!! request()->routeIs('payment') ? '<u>4. Payment</u>' : '4. Payment' !!}</a>
                    </h6>
                </nav>
                <!-- Breadcrumb -->
            </div>
        </div>
        <!-- Heading -->
    @elseif(request()->routeIs('myAccount'))
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <!-- Container wrapper -->
            <div class="container justify-content-center justify-content-md-between">
                <!-- Toggle button -->
                <button class="navbar-toggler border py-2 text-dark" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarLeftAlignExample" aria-controls="navbarLeftAlignExample"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarLeftAlignExample">
                    <!-- Left links -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#profile-section">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#all-orders-section">All Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#shipped-orders-section">Shipped
                                Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#completed-orders-section">Completed
                                Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#cancelled-orders-section">Cancelled
                                Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="logout-link" href="https://www.youtube.com/">Logout</a>
                        </li>
                    </ul>
                    <!-- Left links -->
                </div>
            </div>
            <!-- Container wrapper -->
        </nav>
    @endif

</header>
