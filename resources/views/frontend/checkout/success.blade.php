@extends('frontend.layout.layout')

@section('content')
    <section class="bg-light py-5 my-5">
        <div class="container">
            <div class="d-flex flex-column align-items-center">
                <h1 class="text-center mb-4">Success</h1>
                <a href="{{ route('list') }}" class="btn btn-success text-white">Continue shopping</a>
            </div>
        </div>
    </section>
@endsection
