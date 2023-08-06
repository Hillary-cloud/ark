<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container w-75 mx-auto my-3">
        <div class="card p-2">
            <div class="d-flex justify-content-between">
                <h3>Re-list Ad</h3>
                <a href="javascript:history.back()" class="text-decoration-none">< Back</a>
            </div>
        </div>

        <div class="card shadow-sm my-2 p-3">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="my-2">
                        <p><strong>Cover Image</strong></p> 
                        <img src="{{asset($advert->cover_image)}}" class="img-fluid" style="object-fit: cover; width:15vw; height:15vh" alt="">
                    </div>
                    
                    @if ($advert->other_images)
                    <p><strong>Other Images</strong></p>
                        @foreach ($advert->other_images as $images)
                            <img src="{{asset($images)}}" class="img-fluid mb-2" style="object-fit: cover; width:8vw; height:8vh" alt="">
                        @endforeach
                    @endif
                    <p><strong>Lodge</strong> - {{ ucfirst($advert->lodge->name)}}</p>
                    <p><strong>School Area</strong> - {{ ucfirst($advert->school_area->name)}}</p>
                    <p><strong>School</strong> - {{ ucfirst($advert->School->name)}}</p>
                    <p><strong>Location</strong> - {{ ucfirst($advert->location->state)}}</p>
                    <p><strong>Description</strong> - {{ ucfirst($advert->description)}}</p>
                    <p><strong>Name</strong> - {{ ucfirst($advert->seller_name)}}</p>
                    
                    
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <form action="{{route('update-relist',$advert->uuid)}}" method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="price" class="form-label">Price (&#8358):</label>
                            <input type="number" name="price" id="price" value="{{ $advert->price }}"
                                class="form-control" step="0.01">
                            @error('price')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    
                    <div class="mb-3">
                        <label for="agent_fee" class="form-label">Agent fee (&#8358):</label>
                        <input type="number" name="agent_fee" id="agent_fee" value="{{ $advert->agent_fee }}"
                            class="form-control" step="0.01">
                        @error('agent_fee')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="negotiable" value="{{ $advert->negotiable }}"
                            id="negotiable" class="form-check-input">
                        <label for="negotiable" class="form-check-label">Negotiable</label>
                        @error('negotiable')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone number:</label>
                        <input type="text" name="phone_number" id="phone_number"
                            value="{{ $advert->phone_number }}"
                            class="form-control">
                            <p class="text-muted fst-italic">NB: Provide your active phone number as people will reach out to you through it.</p>
                        @error('phone_number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class=" btn btn-primary btn-lg mx-auto w-100">Re-list ad</button>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection