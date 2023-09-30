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
                <h2 class="fw-bold">{{ ucfirst($advert->lodge->name) }}</h2>

                <p class=""><a href="javascript:history.back()" class="text-decoration-none">
                        < Back</a><span class="text-muted">/{{ ucfirst($advert->school_area->name) }}</span></p>
            </div>
        </div>

        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset($advert->cover_image) }}" class="img-fluid col-lg-8 col-md-8 col-sm-12 col-12"
                            style="height: 400px; object-fit:cover; border-radius:10px" alt="Cover Image">
                    </div>
                </div>
                @foreach ($advert->other_images as $images)
                    <div class="carousel-item">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset($images) }}" class="img-fluid col-lg-8 col-md-8 col-sm-12 col-12"
                                style="height: 400px; object-fit:cover; border-radius:10px" alt="Other Image">
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

        <h1 class="display-4">{{ ucfirst($advert->lodge->name) }} for rent</h1>

        <div class="card p-4 shadow-lg">
            <h2 class="fw-bolder text-success">Quick Summary</h2>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-2 ">
                    <p><span class="">Rent -</span> &#8358 {{ number_format($advert->price) }} per annum </p>
                    <p><span class="">Agent Fee -</span> &#8358 {{ number_format($advert->agent_fee) }}
                    </p>
                    @if ($advert->negotiable == true)
                        <p class="text-muted fst-italic"> Price is negotiable</p>
                    @else
                        <p class="text-muted fst-italic"> Price is not negotiable</p>
                    @endif

                    <p><span class="">School Area -</span> {{ ucfirst($advert->school_area->name) }}</p>
                    <p><span class="">School -</span> {{ ucfirst($advert->school->name) }}</p>
                    <p><span class="">State -</span> {{ ucfirst($advert->location->state) }}</p>
                    <p><span class="">Time Listed -</span>
                        {{ \Carbon\Carbon::parse($advert->list_date)->diffForHumans() }}</p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <h4 class="fw-bold">Description</h4>
                    <p>{{ ucfirst($advert->description) }}
                    </p>
                    @auth
                        <a class="text-decoration-none" href="tel:{{ $advert->phone_number }}">
                            <h5 class="bg-success rounded-pill text-center p-2 text-light"> {{ $advert->phone_number }}</h5>
                        </a>
                        <h5 class="bg-primary rounded-pill text-center p-2 text-light">Seller -
                            {{ ucfirst($advert->seller_name) }}</h5>
                    @else
                        <a href="{{ url('login') }}" class="text-center btn btn-success fw-bold rounded-pill"><i
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
        <a href="{{ route('postLodge') }}" class="btn btn-outline-success btn-light fw-bold mb-4">POST LODGE SIMILAR TO
            THIS</a>

        <div class="card p-3 my-3">
            <h2 class="">Similar Ads</h2>
            <div class="row">
                @if ($adverts->count() > 0)
                    @foreach ($adverts as $advert)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                            <a href="{{ route('lodge-detail', $advert->uuid) }}" class="text-decoration-none">
                                <div class="card shadow-lg" style="border-radius: 10px">
                                    <img src="{{ asset($advert->cover_image) }}" class="card-img-top w-100"
                                        style="object-fit: cover; height:25vh" alt="">

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="card-tittle fw-bold text-dark ">{{ ucfirst($advert->lodge->name) }}
                                            </h4>

                                            @auth
                                                <i class="bi bi-bookmark-fill bookmark-button {{ $advert->isBookmarkedByUser(Auth::user()) ? 'bookmarked' : '' }}"
                                                    data-ad-id="{{ $advert->id }}" style="font-size: 25px"></i>

                                            @endauth

                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <p class="text-success fw-bold">
                                                &#8358 {{ number_format($advert->combined_price) }}</p>
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
