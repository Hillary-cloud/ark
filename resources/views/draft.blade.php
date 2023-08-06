<base href="/public">
@extends('layouts.base')
@section('content')

    <div class="container-fluid p-5" >
        <div class="card w-100 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3>Draft</h3>
                <a href="javascript:history.back()" class="text-decoration-none">< Back</a>
            </div>
        </div>
        @php
                use App\Models\Advert;
            @endphp
            @if (Advert::where(['user_id' => auth()->user()->id, 'draft' => true])->count() < 1)
                <p class="text-danger text-center">No draft found</p>
            @else
        <div class="row mx-auto w-100 ">
            @foreach ($adverts as $advert)
            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                
            <div class="card w-100 mt-3 shadow-lg">  
                <div class="card-header d-flex justify-content-between">
                    <p>{{ucfirst($advert->lodge->name)}}</p>
                    <p>{{ucfirst($advert->school_area->name)}}</p>
                </div>             
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        @if ($advert->cover_image)
                        <img class="my-auto" src="{{ asset($advert->cover_image) }}" style="object-fit: cover; height: 200px" class="img-fluid" width="50%" alt="">
                        @endif
                      
                        <div class="my-auto">
                            <a href="{{route('payment-page', $advert->uuid)}}"><button class="btn btn-light btn-outline-success btn-sm ">Post ad</button></a>
                            <a href="{{route('delete-draft', $advert->uuid)}}"><button class="btn btn-danger btn-sm">Delete</button></a>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                        <p>{{ucfirst($advert->location->state)}}</p>
                        <p>&#8358 {{number_format($advert->combined_price)}}</p>
                </div>
                
            </div>
             
            </div>
            @endforeach  
        </div>
        @endif
    </div>
@endsection