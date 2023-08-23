@extends('frontend.layout.layout')

@section('content')
    <section class="bg-light py-5">
        <div class="container mt-5">
            <div class="tab-content">
                <div id="profile-section" class="tab-pane fade show active">
                    <div class="row justify-content-start">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Profile Settings</h5>
                                    <form>
                                        <!-- Profile form fields -->
                                        <div class="form-outline mb-4">
                                            <input type="text" id="name" class="form-control" />
                                            <label class="form-label" for="name">Name</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="email" id="email" class="form-control" />
                                            <label class="form-label" for="email">Email</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" id="password" class="form-control" />
                                            <label class="form-label" for="password">Password</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="password" id="confirm-password" class="form-control" />
                                            <label class="form-label" for="confirm-password">Confirm Password</label>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="all-orders-section" class="tab-pane fade">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card border mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Code Orders: 1</h5>
                                    <form>
                                        <!-- All Orders form fields for Order 1 -->
                                        <div class="form-outline mb-4">
                                            <input type="text" id="name1" class="form-control" />
                                            <label class="form-label" for="name1">Name</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="tel" id="phone1" class="form-control" />
                                            <label class="form-label" for="phone1">Phone Number</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <textarea id="address1" class="form-control"></textarea>
                                            <label class="form-label" for="address1">Address</label>
                                        </div>

                                        <h6 class="card-subtitle mb-3">Order Details</h6>

                                        <div class="row mb-3">
                                            <div class="col-4">Name</div>
                                            <div class="col-4">Price</div>
                                            <div class="col-4">Quantity</div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-4">Product 1</div>
                                            <div class="col-4">$10</div>
                                            <div class="col-4">2</div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-4">Product 2</div>
                                            <div class="col-4">$20</div>
                                            <div class="col-4">1</div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-4">Product 3</div>
                                            <div class="col-4">$15</div>
                                            <div class="col-4">3</div>
                                        </div>

                                        <div class="text-end mb-4">
                                            <strong>Total: $95</strong>
                                        </div>

                                        <button type="button" class="btn btn-danger">Cancel</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card border mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Code Orders: 2</h5>
                                    <form>
                                        <!-- All Orders form fields for Order 2 -->
                                        <div class="form-outline mb-4">
                                            <input type="text" id="name2" class="form-control" />
                                            <label class="form-label" for="name2">Name</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input type="tel" id="phone2" class="form-control" />
                                            <label class="form-label" for="phone2">Phone Number</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <textarea id="address2" class="form-control"></textarea>
                                            <label class="form-label" for="address2">Address</label>
                                        </div>

                                        <h6 class="card-subtitle mb-3">Order Details</h6>

                                        <div class="row mb-3">
                                            <div class="col-4">Name</div>
                                            <div class="col-4">Price</div>
                                            <div class="col-4">Quantity</div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-4">Product 1</div>
                                            <div class="col-4">$10</div>
                                            <div class="col-4">2</div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-4">Product 2</div>
                                            <div class="col-4">$20</div>
                                            <div class="col-4">1</div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-4">Product 3</div>
                                            <div class="col-4">$15</div>
                                            <div class="col-4">3</div>
                                        </div>

                                        <div class="text-end mb-4">
                                            <strong>Total: $95</strong>
                                        </div>

                                        <button type="button" class="btn btn-danger">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="shipped-orders-section" class="tab-pane fade">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Shipped Orders</h5>
                                    <form>
                                        <!-- Shipped Orders form fields -->
                                        Shipped Orders
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="completed-orders-section" class="tab-pane fade">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Completed Orders</h5>
                                    <form>
                                        <!-- Completed Orders form fields -->
                                        Completed Orders
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="cancelled-orders-section" class="tab-pane fade">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Cancelled Orders</h5>
                                    <form>
                                        <!-- Cancelled Orders form fields -->
                                        Cancelled Orders
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
