<base href="/public">
@extends('layouts.base')
@section('content')
    <style>
        /* Add your CSS styles here */
        #back-to-top {
            display: none;
            position: fixed;
            bottom: 100px;
            right: 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 10px;
            cursor: pointer;
        }

        #back-to-top.show {
            display: block;
        }
    </style>

    <header class="text-light"
        style="
background-image: url('../property-1.jpg'); 
height: 400px;
background-size: cover;
background-position: center;
background-repeat: no-repeat;
">
        <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
            <div class="container-fluid h-100" style="padding-left: 10%; padding-top: 150px;">
                <h1 class="display-5 fw-bold">Tetmart</h1>
                <p class="col-md-8">We help you find best lodges and services in any area of residence that fit your
                    choice and budget.</p>
                {{-- <form class="mt-5 d-flex">
                    <input class=" me-2" style="width: 450px; height: 50px" type="search" name="query"
                        value="{{ old('query', $query) }}" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light btn-success form-control-lg" type="submit"><i class="bi bi-search"
                            style="font-size: 20px"></i></button>
                </form>
                @if ($lodgeAds->isEmpty() && $serviceAds->isEmpty())
                    <p class="text-danger">Nothing was found.</p>
                @endif --}}
            </div>
        </div>
    </header>

    <main>
        <div class="container shadow-sm " style="border-radius: 10px; background-color: rgb(231, 222, 222)">
            <div class="mt-5 text-center p-3">
                <h2 class="text-success">Featured Lodges</h2>
                <p>Find many lodges options that fits your budgets and choices.</p>
            </div>
            <div class="row d-flex justify-content-evenly text-center p-3">
                @foreach ($lodges as $lodge)
                    <div class="col-lg-2 col-md-2 col-sm-4 col-4 m-1 bg-white p-3"
                        style="border-radius: 10px; width: 115px">
                        <a style="text-decoration: none" href="{{ route('lodge-page', $lodge->slug) }}">
                            <img src="{{ asset($lodge->cover_image) }}"
                                style="width: 100%; object-fit: contain; height: 40px" alt="">
                        </a>
                        <h6 class="" style="font-size: 13px">{{ ucfirst($lodge->name) }}</h6>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="container shadow-sm" style="border-radius: 10px; background-color: rgb(231, 222, 222)">
            <div class="mt-5 text-center p-3">
                <h2 class="text-success">Featured Services</h2>
                <p>Find services like painter, cab-man, makeup artist, chef, carpenter and so much more that you need in
                    your area at your finger tips.
                </p>
            </div>

            <div class="d-flex justify-content-center">
                <a href="services" class="bg-white p-3 mb-3 text-decoration-none" style="border-radius: 10px; width: 150px">
                    <img src="service.jpg" style="width: 100%; height: 60px; object-fit: contain;" alt="">
                    <h5 style="font-size: 15px" class="text-center text-dark m-1">Services</h5>
                </a>

            </div>

            {{-- <div class="row d-flex justify-content-evenly text-center p-3">
                @foreach ($services as $service)
                <div class="col-lg-2 col-md-2 col-sm-4 col-4 m-1 bg-white p-3" style="border-radius: 10px; width: 115px">
                    <a style="text-decoration: none" href="{{route('service-page',$service->slug)}}">
                        <img src="{{ asset($service->cover_image) }}" style="width: 100%; object-fit: contain; height: 40px" alt="">
                    </a>
                    <h6 class="" style="font-size: 13px">{{ucfirst($service->name)}}</h6>
                </div>
                @endforeach
            </div> --}}
        </div>

        <div class="container my-5">

            <h3 class="text-success">Listed Lodges</h3>
            <div class="row d-flex justify-content-start">

                @foreach ($lodgeAds as $advert)
                    @if ($advert->lodge_id !== null)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                            <a href="{{ route('lodge-detail', $advert->uuid) }}" class="text-decoration-none">
                                <div class="card shadow-lg" style="border-radius: 10px">
                                    <img src="{{ asset($advert->cover_image) }}" class="card-img-top w-100"
                                        style="object-fit: cover; height:25vh" alt="">

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            {{-- use if statement to prevent attempt to read property name on null error --}}

                                            <h4 class="card-tittle fw-bold text-dark ">{{ ucfirst($advert->lodge->name) }}
                                            </h4>

                                            @auth
                                                <i class="bi bi-bookmark-fill bookmark-button {{ $advert->isBookmarkedByUser(Auth::user()) ? 'bookmarked' : '' }}"
                                                    data-ad-id="{{ $advert->id }}" style="font-size: 25px"></i>

                                            @endauth
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <p class="text-success fw-bold">&#8358
                                                {{ number_format($advert->combined_price) }}</p>
                                            <p class="card-text "><small class="text-muted"><i
                                                        class="bi bi-geo-alt"></i>{{ ucfirst($advert->location->state) }}</small>
                                            </p>
                                        </div>

                                        <div class="d-flex justify-content-between mb-0">
                                            <p class="card-text fw-bold text-dark"><i class="bi bi-bank2"></i>
                                                {{ ucfirst($advert->school->name) }}</p>
                                            <p class="card-text text-dark">{{ ucfirst($advert->school_area->name) }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="card-text "><small class="text-muted">Listed
                                                    {{ \Carbon\Carbon::parse($advert->list_date)->diffForHumans() }}</small>
                                            </p>
                                            <i class="bi bi-eye"> {{ $advert->view_count }}</i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>


            <div class="text-center">
                <a href="{{ route('view-more-lodges') }}" class="btn btn-success rounded-pill text-light p-1"
                    style="width: 12rem">View more lodges
                </a>
            </div>

            <h3 class="text-success" style="margin-top: 50px">Listed Service</h3>
            <div class="row d-flex justify-content-start">

                @foreach ($serviceAds as $advert)
                    @if ($advert->service_id !== null)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                            <a href="{{ route('service-detail', $advert->uuid) }}" class="text-decoration-none">
                                <div class="card shadow-lg" style="border-radius: 10px">
                                    <img src="{{ asset($advert->cover_image) }}" class="card-img-top w-100"
                                        style="object-fit: cover; height:25vh" alt="">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            {{-- use if statement to prevent attempt to read property name on null error --}}

                                            <h4 class="card-tittle fw-bold text-dark ">
                                                {{ ucfirst($advert->service->name) }}</h4>

                                            @auth
                                                <i class="bi bi-bookmark-fill bookmark-button {{ $advert->isBookmarkedByUser(Auth::user()) ? 'bookmarked' : '' }}"
                                                    data-ad-id="{{ $advert->id }}" style="font-size: 25px"></i>

                                            @endauth

                                        </div>

                                        <div class="d-flex justify-content-between">
                                            @if ($advert->on_contact == true)
                                                <p class="text-success fw-bold">Price on contact</p>
                                            @else
                                                <p class="text-success fw-bold ">&#8358
                                                    {{ number_format($advert->combined_price) }}</p>
                                            @endif

                                            <p class="card-text "><small class="text-muted"><i
                                                        class="bi bi-geo-alt"></i>{{ ucfirst($advert->location->state) }}</small>
                                            </p>
                                        </div>

                                        <div class="d-flex justify-content-between mb-0">
                                            <p class="card-text fw-bold text-dark"><i class="bi bi-bank2"></i>
                                                {{ ucfirst($advert->school->name) }}</p>
                                            <p class="card-text text-dark">{{ ucfirst($advert->school_area->name) }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p class="card-text "><small class="text-muted">Listed
                                                    {{ \Carbon\Carbon::parse($advert->list_date)->diffForHumans() }}</small>
                                            </p>
                                            <i class="bi bi-eye"> {{ $advert->view_count }}</i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach

                <div class="text-center">
                    <a href="{{ route('view-more-services') }}" class="btn btn-success rounded-pill text-light p-1"
                        style="width: 12rem">View more services
                    </a>
                </div>
            </div>
        </div>
    </main>

    <button id="back-to-top" class="show"><i class="bi bi-arrow-up"></i></button>

    <script>
        const backToTopButton = document.getElementById('back-to-top');

        // Function to toggle the "show" class on the button
        function toggleBackToTopButton() {
            if (window.scrollY > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        }

        // Add an event listener for the "scroll" event
        window.addEventListener('scroll', toggleBackToTopButton);

        // Check the scroll position on page load and toggle the "show" class accordingly
        window.addEventListener('load', toggleBackToTopButton);

        // Scroll smoothly to the top when the button is clicked
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookmarkButtons = document.querySelectorAll('.bookmark-button');

            bookmarkButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const adId = this.dataset.adId;
                    toggleBookmark(adId, this);
                });
            });
        });

        function toggleBookmark(adId, button) {
            axios.post('{{ route('bookmark.toggle') }}', {
                    advert_id: adId
                })
                .then(response => {
                    if (response.data.message === 'Ad bookmarked') {
                        button.classList.add('bookmarked');
                    } else {
                        button.classList.remove('bookmarked');
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
@endsection
