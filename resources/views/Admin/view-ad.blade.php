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
                @if ($advert->lodge_id !== null)
                    <h2 class="fw-bold">{{ ucfirst($advert->lodge->name) }}</h2>
                @else
                    <h2 class="fw-bold">{{ ucfirst($advert->service->name) }}</h2>
                @endif

                <p class=""><a href="javascript:history.back()" class="text-decoration-none">
                        < Back</a><span class="text-muted">/{{ ucfirst($advert->school_area->name) }}</span></p>
            </div>
        </div>
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset($advert->cover_image) }}" class="img-fluid col-lg-8 col-md-8 col-sm-12 col-12"
                            style="height: 400px; object-cover:fit; border-radius:10px" alt="Cover Image">
                    </div>
                </div>
                @foreach ($advert->other_images as $images)
                    <div class="carousel-item">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset($images) }}" class="img-fluid col-lg-8 col-md-8 col-sm-12 col-12"
                                style="height: 400px; object-cover:fit; border-radius:10px" alt="Other Image">
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev" style="left: 15%; top: %">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next" style="right: 15%; top: %">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div style="border-radius: 10px; background-color: rgb(231, 222, 222)">
            <h4 class="text-success mt-4 text-center">More Images</h4>
            <div class="row justify-content-center mb-3 p-3">
                @foreach ($advert->other_images as $images)
                    <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                        <img src="{{ asset($images) }}"
                            style="width: 100%; height: 15vh; object-fit: cover; border-radius: 10px;" class="other-image"
                            alt="">
                    </div>
                @endforeach
            </div>
        </div>

        @if ($advert->lodge_id !== null)
            <h1 class="display-4">{{ ucfirst($advert->lodge->name) }} for rent</h1>
        @else
            <h1 class="display-4">{{ ucfirst($advert->service->name) }}</h1>
        @endif

        <div class="card p-4 shadow-lg" style="margin-bottom: 100px">
            <h2 class="fw-bolder text-success">Quick Summary</h2>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-2 ">
                    @if ($advert->lodge_id !== null)
                    <p><span class="">Rent -</span> &#8358 {{ number_format($advert->price) }} per annum </p>
                    <p><span class="">Agent Fee -</span> &#8358 {{ number_format($advert->agent_fee) }}
                    </p>
                        @if ($advert->negotiable == true)
                            <p class="text-muted fst-italic"> Price is negotiable</p>
                        @else
                            <p class="text-muted fst-italic"> Price is not negotiable</p>
                        @endif
                    @else
                        @if ($advert->on_contact == true)
                            <p class="text-muted fst-italic"> Price is contact</p>
                        @else
                            <p><span class="">Price -</span> &#8358 {{ number_format($advert->combined_price) }}</p>
                        @endif
                    @endif

                    <p><span class="">School Area -</span> {{ ucfirst($advert->school_area->name) }}</p>
                    <p><span class="">School -</span> {{ ucfirst($advert->school->name) }}</p>
                    <p><span class="">State -</span> {{ ucfirst($advert->location->state) }}</p>

                    @if ($advert->expiration_date == null && $advert->draft == false && $advert->active == false)
                        <p>Status - <span class="text-danger fst-italic">Ad has been de-listed</span></p>
                    @else
                        <p><span class="">Time Listed -</span>
                            {{ \Carbon\Carbon::parse($advert->list_date)->diffForHumans() }}</p>
                        <p><span class="">Expiration Date -</span> {{ $advert->expiration_date }}</p>
                    @endif
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <h4 class="fw-bold">Description</h4>
                    <p>{{ ucfirst($advert->description) }}</p>

                    <a class="text-decoration-none" href="tel:{{ $advert->phone_number }}">
                        <h5 class="bg-success rounded-pill text-center p-2 text-light"> {{ $advert->phone_number }}</h5>
                    </a>
                    <h5 class="bg-primary rounded-pill text-center p-2 text-light">Seller -
                        {{ ucfirst($advert->seller_name) }}</h5>

                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('js/image_modal.js') }}"></script>

    <!-- Modal for displaying large image -->
    <div class="modal">
        <img src="" class="modal-image" alt="Other Image">
    </div>

@endsection
