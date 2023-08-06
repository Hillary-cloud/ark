<base href="/public">
@extends('layouts.base')
@section('content')

<style>

.other-image {
    cursor: pointer;
}

/* CSS for the modal */
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
}

.modal-image {
    max-width: 80%;
    max-height: 80%;
    padding-top: 100px;
}

/* CSS to center the modal image */
.modal-image {
    display: block;
    margin: auto;
}

</style>

    <div class="container my-5">
        <div class="card my-2">
            <div class="d-flex justify-content-between p-2">
                <h2 class="fw-bold">{{ucfirst($advert->lodge->name)}}</h2>
                <p class=""><a href="javascript:history.back()" class="text-decoration-none">< Back</a><span class="text-muted">/{{ucfirst($advert->school_area->name)}}</span></p>
            </div>
        </div>
            <img src="{{asset($advert->cover_image)}}" class="img-fluid mx-auto d-block" style="width: 100%; object-fit:cover; height:500px" alt="">
        <h4 class=" fw-bold text-success mt-4">More</h4>
        <div class="row align-items-start mb-5">
            @foreach ($advert->other_images as $images)
            <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                    <img src="{{asset($images)}}" style="width:100%; object-fit:cover; height: 15vh;" class="img-fluid other-image" alt="">
                
            </div>
            @endforeach

        </div>
        <h1 class="display-4">{{ucfirst($advert->lodge->name)}} for rent</h1>

        <div class="card p-4 shadow-lg">
            <h2 class="fw-bolder text-success">Quick Summary</h2>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-2 ">
                    <p><span class="" >Price -</span> &#8358 {{number_format($advert->combined_price)}} per annum</p>
                    @if ($advert->negotiable == true)
                    <p class="text-muted fst-italic"> Price is negotiable</p>
                    @else
                    <p class="text-muted fst-italic"> Price is not negotiable</p>
                    @endif
                    <p><span class="">School Area -</span> {{ucfirst($advert->school_area->name)}}</p>
                    <p><span class="">School -</span> {{ucfirst($advert->school->name)}}</p>
                    <p><span class="">State -</span> {{ucfirst($advert->location->state)}}</p>
                    <p><span class="">Time Listed -</span> {{($advert->created_at)->diffForHumans()}}</p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <h4 class="fw-bold">Description</h4>
                    <p>{{ucfirst($advert->description)}}
                    </p>
                    @auth
                    <h5 class="bg-success rounded-pill text-center p-2 text-light"> {{$advert->phone_number}}</h5>
                    <h5 class="bg-primary rounded-pill text-center p-2 text-light">Seller - {{ucfirst($advert->seller_name)}}</h5>
                    @else
                    <a href="{{url('login')}}" class="text-center btn btn-success btn-lg fw-bold rounded-pill"><i class="bi bi-telephone"></i> CONTACT SELLER</a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="card p-4 m-3 shadow-sm">
            <h4>Safety tips</h4>
            <ul>
                <li>Don't pay in advance, including for delivery</li>
                <li>Meet the seller at a safe public place</li>
                <li>Inspect the property and ensure it's exactly what you want</li>
                <li>Only pay when you are satisfied</li>
            </ul>
        </div>
        <a href="{{route('postAd')}}" class="btn btn-outline-success btn-light fw-bold" >POST AD SIMILAR TO THIS</a>
        
        <div class="card p-3 my-3">
        <h2 class="fw-bolder text-warning">Related Ads</h2>

            <div class="row">
                @foreach ($adverts as $advert)
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
            <a href="{{route('property-detail',$advert->uuid)}}" class="text-decoration-none">
                <div class="card shadow-lg">
                    <img src="{{asset($advert->cover_image)}}" class="card-img-top w-100" style="object-fit: cover; height:25vh" alt="">
                </a>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-tittle fw-bold text-dark ">{{ucfirst($advert->lodge->name)}}</h4>
                            @auth
                            <i class="bi bi-bookmark" style="font-size: 25px"></i>
                            @endauth
                            
                        </div>
                        
                        <div class="d-flex justify-content-between">
                        <p class="card-text fw-bold bg-success p-2 rounded-pill text-light w-52 text-center">&#8358 {{number_format($advert->combined_price)}}</p>
                        <p class="card-text "><small class="text-muted">{{ucfirst($advert->location->state)}}</small></p>
                    </div>
                    
                        <div class="d-flex justify-content-between mb-0">
                            <p class="card-text fw-bold text-dark">{{ucfirst($advert->school->name)}}</p>
                            <p class="card-text text-dark">{{ucfirst($advert->school_area->name)}}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                        <p class="card-text "><small class="text-muted">Listed {{($advert->created_at)->diffForHumans()}}</small></p>
                        {{-- <i class="bi bi-eye" style="font-size: 25px"></i> --}}
                        </div>
                    </div>
                </div>
        </div>
        
        @endforeach
            </div>
        </div>
    </div>

<script src="{{asset('js/image_modal.js')}}"></script>

<!-- Modal for displaying large image -->
<div class="modal">
    <img src="" class="modal-image" alt="Other Image">
</div>

@endsection
