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
        <img src="{{ asset($advert->cover_image) }}" class="img-fluid mx-auto d-block"
            style="width: 100%; object-fit:cover; height:500px" alt="">
        <h4 class=" fw-bold text-success mt-4">More</h4>
        <div class="row align-items-start mb-5">
            @foreach ($advert->other_images as $images)
                <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                    <img src="{{ asset($images) }}" style="width:100%; object-fit:cover; height: 15vh;"
                        class="img-fluid other-image" alt="">

                </div>
            @endforeach

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
                        <p><span class="">Price -</span> &#8358 {{ number_format($advert->combined_price) }} per annum
                        </p>
                        @if ($advert->negotiable == true)
                            <p class="text-muted fst-italic"> Price is negotiable</p>
                        @else
                            <p class="text-muted fst-italic"> Price is not negotiable</p>
                        @endif
                    @else
                        @if ($advert->on_contact == true)
                            <p class="text-muted fst-italic"> Price is on contact</p>
                        @else
                            <p><span class="">Price -</span> &#8358 {{ number_format($advert->combined_price) }}</p>
                        @endif
                    @endif

                    <p><span class="">School Area -</span> {{ ucfirst($advert->school_area->name) }}</p>
                    <p><span class="">School -</span> {{ ucfirst($advert->school->name) }}</p>
                    <p><span class="">State -</span> {{ ucfirst($advert->location->state) }}</p>
                    <p><span class="">Date Listed -</span> {{ $advert->updated_at }}</p>
                    @if ($advert->expiration_date == null && $advert->draft == false && $advert->active == false)
                        <p>Status - <span class="text-danger fst-italic">Ad has been de-listed</span></p>
                    @else
                        <p><span class="">Expiration Date -</span> {{ $advert->expiration_date }}</p>
                    @endif
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <h4 class="fw-bold">Description</h4>
                    <p>{{ ucfirst($advert->description) }}</p>

                    <h5 class="bg-success rounded-pill text-center p-2 text-light"> {{ $advert->phone_number }}</h5>
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
