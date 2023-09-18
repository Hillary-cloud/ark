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
        <div class="container-fluid h-100" style="padding-left: 10%; padding-top: 100px;">
            <h1 class="display-5">Tetmart</h1>
            <p class="col-md-8 lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            <form class="mt-5 d-flex">
                <input class=" me-2" style="width: 450px; height: 50px" type="search" name="query" value="{{ old('query', $query) }}" placeholder="Search" aria-label="Search" >
                <button class="btn btn-outline-light btn-success form-control-lg" type="submit"><i class="bi bi-search" style="font-size: 20px"></i></button>
            </form>
            @if ($lodgeAds->isEmpty() && $serviceAds->isEmpty())
            <p class="text-danger">Nothing was found.</p>
            @endif
        </div>
    </div>
</header>

<main>
    <div class="container" >
        <div class="my-5 text-center">
            <h1 class="text-success">Featured Lodges</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing Lorem ipsum dolor sit amet consectetur adipisicing</p>
        </div>
        <div class="row d-flex justify-content-evenly text-center">
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../pls4.png" class="img-fluid w-75" alt="">
                <h6 class="fw-bold">Self contain</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../pl5.png" class="img-fluid w-75" alt="">
                <h6 class="fw-bold">Short let</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../pls2.png" class="img-fluid w-75" alt="">
                <h6 class="fw-bold">Flat</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../pls1.png" class="img-fluid w-75" alt="">
                <h6 class="fw-bold">Single room</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../roomie.jpg" class="img-fluid w-75" alt="">
                <h6 class="fw-bold">Roomie</h6>
            </div>
        </div>
    </div>

    <div class="container" >
        <div class="my-5 text-center">
            <h1 class="text-success">Featured Services</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing Lorem ipsum dolor sit amet consectetur adipisicing</p>
        </div>
        <div class="row d-flex justify-content-evenly text-center">
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../paint.png" class="img-fluid w-75" alt="">
                <h6 class="fw-bold">Painter</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../laundry.png" class="img-fluid w-75" alt="">
                <h6 class="fw-bold">Laundry</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../plumber.PNG" class="img-fluid w-75" alt="">
                <h6 class="fw-bold">Plumber</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../electricia.PNG" class="img-fluid w-75" alt="">
                <h6 class="fw-bold">Electrician</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../makeup.PNG" class="img-fluid w-75" alt="">
                <h6 class="fw-bold">Make up</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../delivery.PNG" class="img-fluid w-75" alt="">
                <h6 class="fw-bold">Delivery</h6>
            </div>
        </div>
    </div>
    
    <div class="container my-5 ">
        
        <h3 class="text-success">Listed Lodges</h3>
        <div class="row d-flex justify-content-start" style="margin-bottom: 100px">
        
            <div class="d-flex justify-content-end">
                {{-- <a href="{{route('view-more-lodges')}}" class="btn btn-success rounded-pill text-light p-1"
                style="width: 12rem">View all lodges
                </a> --}}
            </div>
        
                @foreach ($lodgeAds as $advert)
                @if ($advert->lodge_id !== null )
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                        <a href="{{ route('lodge-detail', $advert->uuid) }}" class="text-decoration-none">
                            <div class="card shadow-lg">
                                <img src="{{ asset($advert->cover_image) }}" class="card-img-top w-100"
                                    style="object-fit: cover; height:25vh" alt="">
                        </a>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                {{-- use if statement to prevent attempt to read property name on null error --}}
                                
                                <h4 class="card-tittle fw-bold text-dark ">{{ ucfirst($advert->lodge->name) }}</h4>
                                
                                
                                @auth
                                    <a href="#"
                                        class="bookmark-button {{ $advert->isBookmarkedByUser(Auth::user()) ? 'bookmarked' : '' }}"
                                        data-ad-id="{{ $advert->id }}">
                                        <i class="bi bi-bookmark-fill" style="font-size: 25px"></i>
                                    </a>
                                @endauth
        
                            </div>
        
                            <div class="d-flex justify-content-between">
                                <p class="text-success fw-bold">&#8358
                                    {{ number_format($advert->combined_price) }}</p>
                                <p class="card-text "><small class="text-muted"><i class="bi bi-geo-alt"></i>{{ ucfirst($advert->location->state) }}</small>
                                </p>
                            </div>
        
                            <div class="d-flex justify-content-between mb-0">
                                <p class="card-text fw-bold text-dark"><i class="bi bi-bank2"></i> {{ ucfirst($advert->school->name) }}</p>
                                <p class="card-text text-dark">{{ ucfirst($advert->school_area->name) }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text "><small class="text-muted">Listed
                                        {{ \Carbon\Carbon::parse($advert->list_date)->diffForHumans() }}</small></p>
                                <i class="bi bi-eye"> {{ $advert->view_count }}</i>
                            </div>
                        </div>
                    </div>
        </div>
        @endif
        @endforeach
        
        <div class="d-flex justify-content-center">
            <a href="{{route('view-more-lodges')}}" class="btn btn-success rounded-pill text-light p-1"
            style="width: 12rem">View all lodges
            </a>
        </div>

        <h3 class="text-success">Listed Service</h3>
        <div class="row d-flex justify-content-start" >
        
            <div class="d-flex justify-content-end">
                {{-- <a href="{{route('view-more-services')}}" class="btn btn-success rounded-pill text-light p-1"
                style="width: 12rem">View all services
                </a> --}}
            </div>
        
                @foreach ($serviceAds as $advert)
                @if ($advert->service_id !== null )
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                        <a href="{{ route('service-detail', $advert->uuid) }}" class="text-decoration-none">
                            <div class="card shadow-lg">
                                <img src="{{ asset($advert->cover_image) }}" class="card-img-top w-100"
                                    style="object-fit: cover; height:25vh" alt="">
                        </a>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                {{-- use if statement to prevent attempt to read property name on null error --}}
                                
                                <h4 class="card-tittle fw-bold text-dark ">{{ ucfirst($advert->service->name) }}</h4>
                                
                                
                                @auth
                                    <a href="#"
                                        class="bookmark-button {{ $advert->isBookmarkedByUser(Auth::user()) ? 'bookmarked' : '' }}"
                                        data-ad-id="{{ $advert->id }}">
                                        <i class="bi bi-bookmark-fill" style="font-size: 25px"></i>
                                    </a>
                                @endauth
        
                            </div>
        
                            <div class="d-flex justify-content-between">
                                @if ($advert->on_contact == true)
                                <p class="text-success fw-bold">Price on contact</p>
                                @else
                                <p class="text-success fw-bold ">&#8358
                                    {{ number_format($advert->combined_price) }}</p>
                                @endif
                                
                                <p class="card-text "><small class="text-muted"><i class="bi bi-geo-alt"></i>{{ ucfirst($advert->location->state) }}</small>
                                </p>
                            </div>
        
                            <div class="d-flex justify-content-between mb-0">
                                <p class="card-text fw-bold text-dark"><i class="bi bi-bank2"></i> {{ ucfirst($advert->school->name) }}</p>
                                <p class="card-text text-dark">{{ ucfirst($advert->school_area->name) }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text "><small class="text-muted">Listed
                                    {{ \Carbon\Carbon::parse($advert->list_date)->diffForHumans() }}</small></p>
                                <i class="bi bi-eye"> {{ $advert->view_count }}</i>
                            </div>
                        </div>
                    </div>
        </div>
        @endif
        @endforeach
        
        <div class="d-flex justify-content-center mb-5">
            <a href="{{route('view-more-services')}}" class="btn btn-success rounded-pill text-light p-1"
            style="width: 12rem">View all services
            </a>
        </div>     
        
    </div>
</main>

<button id="back-to-top" class="show"><i class="bi bi-arrow-up"></i></button>
    
<script>
    const backToTopButton = document.getElementById('back-to-top');

    // Show/hide the button based on scroll position
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
    });

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
    axios.post('{{ route('bookmark.toggle') }}', { advert_id: adId })
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