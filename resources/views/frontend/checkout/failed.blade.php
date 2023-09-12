@extends('frontend.layout.layout')

@section('content')
    <section class="bg-light py-5 my-5">
        <div class="container">
            <div class="d-flex flex-column align-items-center">
                <h1 class="text-center mb-4">Order failed</h1>
                <a href="{{ route('order') }}" class="btn btn-warning text-white">Please try again later</a>
            </div>
        </div>
    </section>
@endsection
