<header>
    <!-- Jumbotron -->
    <div class="p-3 text-center bg-white border-bottom">
        <div class="container">
            <div class="row gy-3">
                <!-- Left elements -->
                <div class="col-lg-2 col-sm-4 col-4">
                    <a href="{{ route('index') }}" class="float-start">
                        <img src="{{ asset('frontend/img/mdb-transaprent-noshadows.png') }}" height="35" />
                    </a>
                </div>
                <!-- Left elements -->

                <!-- Center elements -->
                <div class="order-lg-last col-lg-5 col-sm-8 col-8">
                    <div class="d-flex float-end">
                        @if (Auth::guard('web')->check())
                            <a href="{{ route('myAccount') }}"
                                class="me-1 border rounded py-1 px-3 d-flex align-items-center">
                                <i class="fas fa-user-alt m-1 me-md-2"></i>
                                <p class="d-none d-md-block mb-0">{{ Auth::guard('web')->user()->name }}</p>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="me-1 border rounded py-1 px-3 d-flex align-items-center"> <i
                                    class="fas fa-user-alt m-1 me-md-2"></i>
                                <p class="d-none d-md-block mb-0">Sign in</p>
                            </a>
                        @endif
                        <a href="{{ route('index') }}" class="me-1 border rounded py-1 px-3 d-flex align-items-center">
                            <i class="fas fa-heart m-1 me-md-2"></i>
                            <p class="d-none d-md-block mb-0">Wishlist</p>
                        </a>
                        <a href="{{ route('cart') }}" class="border rounded py-1 px-3 d-flex align-items-center"> <i
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
                            <a class="nav-link text-dark" aria-current="page" href="{{ route('index') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" aria-current="page" href="{{ route('list') }}">All
                                Products</a>
                        </li>
                        <!-- Navbar dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" id="navbarDropdown" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                Categories
                            </a>
                            <!-- Dropdown menu -->
                            <nav class="custom-nav-list">
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach ($categories as $category)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('listByCategory', ['id' => $category->id]) }}">{{ $category->name }}</a>
                                            <ul>
                                                @foreach ($category->child as $child)
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('listByCategory', ['id' => $child->id]) }}">{{ $child->name }}</a>
                                                        @if (@isset($child->child))
                                                            <ul>
                                                                @foreach ($child->child as $subChild)
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('listByCategory', ['id' => $subChild->id]) }}">{{ $subChild->name }}</a>
                                                                        @if (@isset($subChild->child))
                                                                            <ul>
                                                                                @foreach ($subChild->child as $subSubChild)
                                                                                    <li>
                                                                                        <a class="dropdown-item"
                                                                                            href="{{ route('listByCategory', ['id' => $subSubChild->id]) }}">{{ $subSubChild->name }}</a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </nav>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown"
                                role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                Brands
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach ($brands as $brand)
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('listByBrand', ['id' => $brand->id]) }}">{{ $brand->name }}</a>
                                    </li>
                                @endforeach
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
    @elseif(request()->routeIs('cart') ||
            request()->routeIs('order') ||
            request()->routeIs('payment') ||
            request()->routeIs('success'))
        <!-- Heading -->
        <div class="bg-primary">
            <div class="container py-4">
                <!-- Breadcrumb -->
                <nav class="d-flex">
                    <h6 class="mb-0">
                        <a href="{{ route('index') }}" class="text-white-50">Home</a>
                        <span class="text-white-50 mx-2"> > </span>
                        <a href="{{ route('cart') }}"
                            class="text-white{{ request()->routeIs('cart') ? '' : '-50' }}">{!! request()->routeIs('cart') ? '<u>Shopping cart</u>' : 'Shopping cart' !!}</a>
                        @if (request()->routeIs('order') || request()->routeIs('success'))
                            <span class="text-white-50 mx-2"> > </span>
                            <a href="{{ route('order') }}"
                                class="text-white{{ request()->routeIs('order') ? '' : '-50' }}">{!! request()->routeIs('order') ? '<u>Order info</u>' : 'Order info' !!}</a>
                            @if (request()->routeIs('success'))
                                <span class="text-white-50 mx-2"> > </span>
                                <a
                                    class="text-white{{ request()->routeIs('success') ? '' : '-50' }}">{!! request()->routeIs('success') ? '<u>Success</u>' : 'Success' !!}</a>
                            @endif
                        @endif
                    </h6>
                </nav>
                <!-- Breadcrumb -->
            </div>
        </div>
        <!-- Heading -->
    @elseif(request()->routeIs('myAccount'))
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-primary custom-nav current-page">
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
                            <a class="nav-link" id="home" href="{{ route('index') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#profile-section">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#all-orders-section">All
                                Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#shipping-orders-section">Shipping
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
                            <a class="nav-link" id="logout" href="{{ route('index') }}">Logout</a>
                        </li>
                    </ul>
                    <!-- Left links -->
                </div>
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
    @elseif(request()->routeIs('listByCategory') || request()->routeIs('listByBrand') || request()->routeIs('list'))
        <!-- Heading -->
        <div class="bg-primary mb-4">
            <div class="container py-4">
                <h3 class="text-white mt-2">
                    {{ request()->routeIs('list') ? 'All Product' : (request()->routeIs('listByCategory') ? $category->name : (request()->routeIs('listByBrand') ? $brand->name : 'Product')) }}
                </h3>
                <!-- Breadcrumb -->
                <nav class="d-flex mb-2">
                    <h6 class="mb-0">
                        <a href="{{ route('index') }}" class="text-white-50">Home</a>
                        <span class="text-white-50 mx-2"> > </span>
                        <a href="" class="text-white"><u>Library</u></a>
                    </h6>
                </nav>
                <!-- Breadcrumb -->
            </div>
        </div>
        <!-- Heading -->
    @endif
</header>
