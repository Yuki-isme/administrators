@extends('frontend.layout.layout')

@section ('content')
<!-- Jumbotron -->
<div class="bg-primary text-white py-5">
    <div class="container py-5">
      <h1>
        Best products & <br />
        brands in our store
      </h1>
      <p>
        Trendy Products, Factory Prices, Excellent Service
      </p>
      <button type="button" class="btn btn-outline-light">
        Learn more
      </button>
      <button type="button" class="btn btn-light shadow-0 text-primary pt-2 border border-white">
        <span class="pt-1">Purchase now</span>
      </button>
    </div>
  </div>
  <!-- Jumbotron -->

  <!-- category -->
  <section>
    <div class="container pt-5">
      <nav class="row gy-4">
        <div class="col-lg-6 col-md-12">
          <div class="row">
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-couch fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Interior items</div>
              </a>
            </div>
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-basketball-ball fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Sport and travel</div>
              </a>
            </div>
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-ring fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Jewellery</div>
              </a>
            </div>
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-clock fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Accessories</div>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div class="row">
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-car-side fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Automobiles</div>
              </a>
            </div>
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-home fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Home items</div>
              </a>
            </div>
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-guitar fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Musical items</div>
              </a>
            </div>
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-book fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Book, reading</div>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div class="row">
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-baby-carriage fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Kid's toys</div>
              </a>
            </div>
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-paw fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Pet items</div>
              </a>
            </div>
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-tshirt fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Men's clothing</div>
              </a>
            </div>
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-shoe-prints fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Men's clothing</div>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div class="row">
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-mobile fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Smartphones</div>
              </a>
            </div>
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-tools fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Tools</div>
              </a>
            </div>
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-pencil-ruler fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Education</div>
              </a>
            </div>
            <div class="col-3">
              <a href="#" class="text-center d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-outline-secondary mx-auto p-3 mb-2" data-mdb-ripple-color="dark">
                  <i class="fas fa-warehouse fa-xl fa-fw"></i>
                </button>
                <div class="text-dark">Other items</div>
              </a>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </section>
  <!-- category -->

  <!-- Products -->
  <section>
    <div class="container my-5">
      <header class="mb-4">
        <h3>New products</h3>
      </header>

      <div class="row">
        @foreach ($newProducts as $newProduct )
        <div class="col-lg-3 col-md-6 col-sm-6 d-flex">
            <div class="card w-100 my-2 shadow-2-strong">
              <a href="{{ route('frontend.productDetail', ['id' => $newProduct->id]) }}" class="text-product">
                <img src="{{ asset('storage/' . $newProduct->thumbnail->url) }}" class="card-img-top"
                style="aspect-ratio: 1 / 1" />
              <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $newProduct->name }}</h5>
                <p class="card-text">{{ $newProduct->price }} VND</p>
                <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
              </a>
                  <a href="#!" class="btn btn-primary shadow-0 me-1">Add to cart</a>
                  <a href="#!" class="btn btn-light border px-2 pt-2 icon-hover"><i
                      class="fas fa-heart fa-lg text-secondary px-1"></i></a>
                </div>
              </div>
            </div>
          </div>
        @endforeach

      </div>
    </div>
  </section>
  <!-- Products -->

  <!-- Feature -->
  <section class="mt-5" style="background-color: #f5f5f5;">
    <div class="container text-dark pt-3">
      <header class="pt-4 pb-3">
        <h3>Why choose us</h3>
      </header>

      <div class="row mb-4">
        <div class="col-lg-4 col-md-6">
          <figure class="d-flex align-items-center mb-4">
            <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
              <i class="fas fa-camera-retro fa-2x fa-fw text-primary floating"></i>
            </span>
            <figcaption class="info">
              <h6 class="title">Reasonable prices</h6>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
            </figcaption>
          </figure>
          <!-- itemside // -->
        </div>
        <!-- col // -->
        <div class="col-lg-4 col-md-6">
          <figure class="d-flex align-items-center mb-4">
            <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
              <i class="fas fa-star fa-2x fa-fw text-primary floating"></i>
            </span>
            <figcaption class="info">
              <h6 class="title">Best quality</h6>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
            </figcaption>
          </figure>
          <!-- itemside // -->
        </div>
        <!-- col // -->
        <div class="col-lg-4 col-md-6">
          <figure class="d-flex align-items-center mb-4">
            <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
              <i class="fas fa-plane fa-2x fa-fw text-primary floating"></i>
            </span>
            <figcaption class="info">
              <h6 class="title">Worldwide shipping</h6>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
            </figcaption>
          </figure>
          <!-- itemside // -->
        </div>
        <!-- col // -->
        <div class="col-lg-4 col-md-6">
          <figure class="d-flex align-items-center mb-4">
            <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
              <i class="fas fa-users fa-2x fa-fw text-primary floating"></i>
            </span>
            <figcaption class="info">
              <h6 class="title">Customer satisfaction</h6>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
            </figcaption>
          </figure>
          <!-- itemside // -->
        </div>
        <!-- col // -->
        <div class="col-lg-4 col-md-6">
          <figure class="d-flex align-items-center mb-4">
            <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
              <i class="fas fa-thumbs-up fa-2x fa-fw text-primary floating"></i>
            </span>
            <figcaption class="info">
              <h6 class="title">Happy customers</h6>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
            </figcaption>
          </figure>
          <!-- itemside // -->
        </div>
        <!-- col // -->
        <div class="col-lg-4 col-md-6">
          <figure class="d-flex align-items-center mb-4">
            <span class="rounded-circle bg-white p-3 d-flex me-2 mb-2">
              <i class="fas fa-box fa-2x fa-fw text-primary floating"></i>
            </span>
            <figcaption class="info">
              <h6 class="title">Thousand items</h6>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do eiusmor</p>
            </figcaption>
          </figure>
          <!-- itemside // -->
        </div>
        <!-- col // -->
      </div>
    </div>
    <!-- container end.// -->
  </section>
  <!-- Feature -->

  <!-- Blog -->
  <section class="mt-5 mb-4">
    <div class="container text-dark">
      <header class="mb-4">
        <h3>Blog posts</h3>
      </header>

      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <article>
            <a href="#" class="img-fluid">
              <img class="rounded w-100" src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/posts/1.webp"
                style="object-fit: cover;" height="160" />
            </a>
            <div class="mt-2 text-muted small d-block mb-1">
              <span>
                <i class="fa fa-calendar-alt fa-sm"></i>
                23.12.2022
              </span>
              <a href="#">
                <h6 class="text-dark">How to promote brands</h6>
              </a>
              <p>When you enter into any new area of science, you almost reach</p>
            </div>
          </article>
        </div>
        <!-- col.// -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <article>
            <a href="#" class="img-fluid">
              <img class="rounded w-100" src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/posts/2.webp"
                style="object-fit: cover;" height="160" />
            </a>
            <div class="mt-2 text-muted small d-block mb-1">
              <span>
                <i class="fa fa-calendar-alt fa-sm"></i>
                13.12.2022
              </span>
              <a href="#">
                <h6 class="text-dark">How we handle shipping</h6>
              </a>
              <p>When you enter into any new area of science, you almost reach</p>
            </div>
          </article>
        </div>
        <!-- col.// -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <article>
            <a href="#" class="img-fluid">
              <img class="rounded w-100" src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/posts/3.webp"
                style="object-fit: cover;" height="160" />
            </a>
            <div class="mt-2 text-muted small d-block mb-1">
              <span>
                <i class="fa fa-calendar-alt fa-sm"></i>
                25.11.2022
              </span>
              <a href="#">
                <h6 class="text-dark">How to promote brands</h6>
              </a>
              <p>When you enter into any new area of science, you almost reach</p>
            </div>
          </article>
        </div>
        <!-- col.// -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <article>
            <a href="#" class="img-fluid">
              <img class="rounded w-100" src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/posts/4.webp"
                style="object-fit: cover;" height="160" />
            </a>
            <div class="mt-2 text-muted small d-block mb-1">
              <span>
                <i class="fa fa-calendar-alt fa-sm"></i>
                03.09.2022
              </span>
              <a href="#">
                <h6 class="text-dark">Success story of sellers</h6>
              </a>
              <p>When you enter into any new area of science, you almost reach</p>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>
  <!-- Blog -->
@endsection
