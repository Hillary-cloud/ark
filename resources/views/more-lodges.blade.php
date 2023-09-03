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

    <div class="container my-4">
        <div class="d-flex justify-content-between">
            <h3 class="fw-bold">Listed Lodges</h3>
            <a href="javascript:history.back()" class="text-decoration-none">< Back</a>
        </div>
        <form action="{{ route('view-more-lodges') }}" method="GET" class="row g-3">

            <div class="col-2">
                <label for="lodge" class="form-label">Lodge</label><br>
                <select style="width: 100%" name="lodge" id="lodge">
                    <option value="">Lodge</option>
                    @foreach ($lodges as $lodge)
                        <option value="{{ $lodge->id }}" {{ Request::get('lodge') == $lodge->id ? 'selected' : '' }}>
                            {{ ucfirst($lodge->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-2">
                <label for="school" class="form-label">School</label><br>
                <select style="width: 100%" name="school" id="school">
                    <option value="">School</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ Request::get('school') == $school->id ? 'selected' : '' }}>
                            {{ ucfirst($school->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-2">
                <label for="price" class="form-label">Price</label><br>
                <select style="width: 100%" name="price" id="price">
                    <option value="">Price</option>
                    <option value="0-50000" {{ Request::get('price') == '0-50000' ? 'selected' : '' }}>&#8358 0 - &#8358
                        50,000</option>
                    <option value="50001-100000" {{ Request::get('price') == '50001-100000' ? 'selected' : '' }}>&#8358
                        50,001 - &#8358 100,000</option>
                    <option value="100001-150000" {{ Request::get('price') == '100001-150000' ? 'selected' : '' }}>&#8358
                        100,001 - &#8358 150,000</option>
                    <option value="150001-200000" {{ Request::get('price') == '150001-200000' ? 'selected' : '' }}>&#8358
                        150,001 - &#8358 200,000</option>
                    <option value="200001-100000000000"
                        {{ Request::get('price') == '200001-100000000000' ? 'selected' : '' }}>&#8358 200,001 and above
                    </option>
                </select>
            </div>

            <div class="col-2">
                <label for="school_area" class="form-label">Area</label><br>
                <select style="width: 100%" name="school_area" id="school_area">
                    <option value="">School Area</option>
                    @foreach ($school_areas as $school_area)
                        <option value="{{ $school_area->id }}" {{ Request::get('school_area') == $school_area->id ? 'selected' : '' }}>
                            {{ ucfirst($school_area->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-2">
                <label for="location" class="form-label">Location</label><br>
                <select style="width: 100%" name="location" id="location">
                    <option value="">Location</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" {{ Request::get('location') == $location->id ? 'selected' : '' }}>
                            {{ ucfirst($location->state) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-2 align-self-end">
                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-funnel"></i> Filter</button>
            </div>

        </form>

        <div class="row d-flex justify-content-start" style="margin-bottom: 100px">
            @if ($adverts->count() > 0)
                <p class="text-muted fst-italic">({{ $adverts->count() }} ad{{ $adverts->count() !== 1 ? 's' : '' }})</p>

                @foreach ($adverts as $advert)
                {{-- @if ($advert->lodge_id !== null ) --}}
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                        <a href="{{ route('lodge-detail', $advert->uuid) }}" class="text-decoration-none">
                            <div class="card shadow-lg">
                                <img src="{{ asset($advert->cover_image) }}" class="card-img-top w-100"
                                    style="object-fit: cover; height:25vh" alt="">
                        </a>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
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
                                <p class="card-text fw-bold bg-success p-2 rounded-pill text-light w-52 text-center">&#8358
                                    {{ number_format($advert->combined_price) }}</p>
                                <p class="card-text "><small
                                        class="text-muted">{{ ucfirst($advert->location->state) }}</small>
                                </p>
                            </div>

                            <div class="d-flex justify-content-between mb-0">
                                <p class="card-text fw-bold text-dark">{{ ucfirst($advert->school->name) }}</p>
                                <p class="card-text text-dark">{{ ucfirst($advert->school_area->name) }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="card-text "><small class="text-muted">Listed
                                        {{ $advert->created_at->diffForHumans() }}</small></p>
                                <i class="bi bi-eye"> {{ $advert->view_count }}</i>
                            </div>
                        </div>
                    </div>
        </div>
        {{-- @endif --}}
        @endforeach

            <div class="pagination">
                <style>
                    nav svg {
                        height: 20px;
                    }

                    nav .hidden {
                        display: block !important;
                    }
                </style>
                {{ $adverts->links() }}
            </div>
        @else
            <p class="text-danger text-center">No ad found</p>
            @endif

    </div>

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
