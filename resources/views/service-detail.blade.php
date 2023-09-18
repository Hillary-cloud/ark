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

        #social-links ul li {
            display: inline-block;
            margin-top: 15px;
        }

        #social-links ul li a {
            padding: 5px;
            margin: 2px;
            font-size: 20px;
            color: rgb(46, 41, 114);
            background-color: #ccc;
        }

        #social-links ul li a:hover {
            background-color: rgb(46, 41, 114);
            color: white;
        }
    </style>

    <div class="container my-5">
        <div class="card my-2">
            <div class="d-flex justify-content-between p-2">
                    <h2 class="fw-bold">{{ ucfirst($advert->service->name) }}</h2>

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

            <h1 class="display-4">{{ ucfirst($advert->service->name) }}</h1>

        <div class="card p-4 shadow-lg">
            <h2 class="fw-bolder text-success">Quick Summary</h2>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-2 ">
                
                        @if ($advert->on_contact == true)
                            <p class="text-muted fst-italic"> Price is on contact</p>
                        @else
                            <p><span class="">Price -</span> &#8358 {{ number_format($advert->combined_price) }}</p>
                        @endif

                    <p><span class="">School Area -</span> {{ ucfirst($advert->school_area->name) }}</p>
                    <p><span class="">School -</span> {{ ucfirst($advert->school->name) }}</p>
                    <p><span class="">State -</span> {{ ucfirst($advert->location->state) }}</p>
                    <p><span class="">Time Listed -</span> {{ \Carbon\Carbon::parse($advert->list_date)->diffForHumans() }}</p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <h4 class="fw-bold">Description</h4>
                    <p>{{ ucfirst($advert->description) }}
                    </p>
                    @auth
                        <h5 class="bg-success rounded-pill text-center p-2 text-light"> {{ $advert->phone_number }}</h5>
                        <h5 class="bg-primary rounded-pill text-center p-2 text-light">Seller -
                            {{ ucfirst($advert->seller_name) }}</h5>
                    @else
                        <a href="{{ url('login') }}" class="text-center btn btn-success btn-lg fw-bold rounded-pill"><i
                                class="bi bi-telephone"></i> CONTACT SELLER</a>
                    @endauth
                    <div class="d-flex">
                        <p style="font-size:20px; margin-top:15px"><i class="bi bi-share"
                                style="font-size:20px; margin-top:15px"></i> Share on</p>
                        {!! $shareButton !!}
                    </div>
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
            <a href="{{ route('postService') }}" class="btn btn-outline-success btn-light fw-bold mb-4">POST SERVICE
                SIMILAR TO THIS</a>

        <div class="card p-3 my-3">
            <h2 class="fw-bolder text-warning">Related Ads</h2>
        <div class="row">
            @if ($adverts->count() > 0)
            @foreach ($adverts as $advert)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                            <a href="{{ route('service-detail', $advert->uuid) }}" class="text-decoration-none">
                                <div class="card shadow-lg">
                                    <img src="{{ asset($advert->cover_image) }}" class="card-img-top w-100"
                                        style="object-fit: cover; height:25vh" alt="">
                            </a>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
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
                                    <p class="text-success fw-bold">&#8358
                                        {{ number_format($advert->combined_price) }}</p>
                                    @endif
                                    
                                    <p class="card-text "><small
                                            class="text-muted"><i class="bi bi-geo-alt"></i>{{ ucfirst($advert->location->state) }}</small></p>
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
            @endforeach
            @else
            <p class="text-danger text-center">No related ad</p>
            @endif
        </div>
    </div>
    </div>

    <script src="{{ asset('js/image_modal.js') }}"></script>

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

    <!-- Modal for displaying large image -->
    <div class="modal">
        <img src="" class="modal-image" alt="Other Image">
    </div>

@endsection
