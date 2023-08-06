<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container">
        <div class="card my-3 p-2">
            <div class="d-flex justify-content-between">
                <h3>Bookmarked Ads</h3>
                <a href="javascript:history.back()" class="text-decoration-none">< Back</a>
            </div>
        </div>

        <div class="row d-flex justify-content-start" id="filtered-results">
            @if ($bookmarkedAds->isEmpty())
            <p class="text-danger text-center">You have no bookmark yet</p>
            @else
            @foreach ($bookmarkedAds as $bookmark)
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                <a href="{{route('property-detail',$bookmark->advert->uuid)}}" class="text-decoration-none">
                    <div class="card shadow-lg">
                        <img src="{{asset($bookmark->advert->cover_image)}}" class="card-img-top w-100" style="object-fit: cover; height:25vh" alt="">
                    </a>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-tittle fw-bold text-dark ">{{ucfirst($bookmark->advert->lodge->name)}}</h4>                                
                            </div>
                            
                            <div class="d-flex justify-content-between">
                            <p class="card-text fw-bold bg-success p-2 rounded-pill text-light w-52 text-center">&#8358 {{number_format($bookmark->advert->combined_price)}}</p>
                            <p class="card-text "><small class="text-muted">{{ucfirst($bookmark->advert->location->state)}}</small></p>
                        </div>
                        
                            <div class="d-flex justify-content-between mb-0">
                                <p class="card-text fw-bold text-dark">{{ucfirst($bookmark->advert->school->name)}}</p>
                                <p class="card-text text-dark">{{ucfirst($bookmark->advert->school_area->name)}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                            <p class="card-text "><small class="text-muted">Listed {{($bookmark->advert->created_at)->diffForHumans()}}</small></p>
                            {{-- <i class="bi bi-eye" style="font-size: 25px"></i> --}}
                            </div>
                        </div>
                    </div>
            </div>
            
            @endforeach
            
            @endif
            
        </div>
    </div>
@endsection