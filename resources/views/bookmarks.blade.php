<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container" style="margin-bottom:50px;">
        <div class="card my-3 p-2">
            <div class="d-flex justify-content-between">
                <h3>Saved Ads</h3>
                <a href="javascript:history.back()" class="text-decoration-none">
                    < Back</a>
            </div>
        </div>

        <div class="row d-flex justify-content-start" id="filtered-results">
            @if ($bookmarkedAds->isEmpty())
                <p class="text-danger text-center">You have no saved ad</p>
            @else
                @foreach ($bookmarkedAds as $bookmark)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                        @if ($bookmark->advert->lodge_id !== null)
                            <a href="{{ route('lodge-detail', $bookmark->advert->uuid) }}" class="text-decoration-none">
                            @else
                                <a href="{{ route('service-detail', $bookmark->advert->uuid) }}"
                                    class="text-decoration-none">
                        @endif
                        <div class="card shadow-lg" style="border-radius: 10px">
                            <img src="{{ asset($bookmark->advert->cover_image) }}" class="card-img-top w-100"
                                style="object-fit: cover; height:25vh" alt="">
                            </a>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    @if ($bookmark->advert->lodge_id !== null)
                                        <h4 class="card-tittle fw-bold text-dark ">
                                            {{ ucfirst($bookmark->advert->lodge->name) }}</h4>
                                    @else
                                        <h4 class="card-tittle fw-bold text-dark ">
                                            {{ ucfirst($bookmark->advert->service->name) }}</h4>
                                    @endif

                                    {{-- <a href="{{route('delete-bookmark',$bookmark->id)}}"><button class="btn btn-danger btn-sm">Delete</button></a>                               --}}
                                    <a href="{{ route('delete-bookmark', $bookmark->id) }}"
                                        onclick="event.preventDefault(); {{ route('delete-bookmark', $bookmark->id) }}"
                                        ><i class="bi bi-x-circle" style="color: black"></i></a>
                                </div>

                                <div class="d-flex justify-content-between">
                                    @if ($bookmark->advert->lodge_id !== null)
                                        <p class="text-success fw-bold">&#8358
                                            {{ number_format($bookmark->advert->combined_price) }}</p>
                                    @else
                                        @if ($bookmark->advert->on_contact == true)
                                            <p class="text-success fw-bold">Price on contact</p>
                                        @else
                                            <p class="text-success fw-bold ">&#8358
                                                {{ number_format($bookmark->advert->combined_price) }}</p>
                                        @endif
                                    @endif
                                
                                    <p class="card-text "><small
                                            class="text-muted">{{ ucfirst($bookmark->advert->location->state) }}</small>
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between mb-0">
                                    <p class="card-text fw-bold text-dark">{{ ucfirst($bookmark->advert->school->name) }}
                                    </p>
                                    <p class="card-text text-dark">{{ ucfirst($bookmark->advert->school_area->name) }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="card-text "><small class="text-muted">Listed
                                            {{ \Carbon\Carbon::parse($bookmark->advert->list_date)->diffForHumans() }}</small>
                                    </p>
                                    <i class="bi bi-eye"> {{ $bookmark->advert->view_count }}</i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
@endsection
