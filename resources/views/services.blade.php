<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container my-3">

        <div class="d-flex justify-content-between mb-3">
            <h3 class="">All Services</h3>
            <a href="javascript:history.back()" class="text-decoration-none">
                < Back</a>
        </div>

        <div class="shadow-sm" style="border-radius: 10px; background-color: rgb(231, 222, 222)">
            <div class="row d-flex justify-content-evenly text-center p-3">
                @foreach ($services as $service)
                    <div class="col-lg-2 col-md-2 col-sm-4 col-4 m-1 bg-white p-3" style="border-radius: 10px;">
                        <a style="text-decoration: none" href="{{ route('service-page', $service->slug) }}">
                            <img src="{{ asset($service->cover_image) }}"
                                style="width: 100%; object-fit: contain; height: 40px" alt="">
                        </a>
                        <h6 class="" style="font-size: 13px">{{ ucfirst($service->name) }}</h6>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
