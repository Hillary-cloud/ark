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
        <div class="d-flex justify-content-between mb-3">
            <h3 class="">Listed Lodges</h3>
            <a href="javascript:history.back()" class="text-decoration-none">
                < Back</a>
        </div>
        
        <form action="{{ route('view-more-lodges') }}" method="GET" class="row g-3">

            <div class="col-4">

                <select style="width: 100%; height: 30px" name="location" id="location">
                    <option value="">Location</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->slug }}">
                            {{ ucfirst($location->state) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-4">
                <select style="width: 100%; height: 30px" name="school" id="school" disabled>
                    <option value="">School</option>
                </select>
            </div>

            <div class="col-4">
                <select style="width: 100%; height: 30px" name="school_area" id="school_area" disabled>
                    <option value=""> Area</option>
                </select>
            </div>

            <div class="col-4">
                <select style="width: 100%; height: 30px" name="lodge" id="lodge">
                    <option value="">Lodge</option>
                    @foreach ($lodges as $lodge)
                        <option value="{{ $lodge->slug }}" {{ Request::get('lodge') == $lodge->slug ? 'selected' : '' }}>
                            {{ ucfirst($lodge->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-4">
                <select style="width: 100%; height: 30px" name="price" id="price">
                    <option value="">Price</option>
                    <option value="0-50000" {{ Request::get('price') == '0-50000' ? 'selected' : '' }}>&#8358 0 - &#8358
                        50,000</option>
                    <option value="50001-100000" {{ Request::get('price') == '50001-100000' ? 'selected' : '' }}>&#8358
                        50,001 - &#8358 100,000</option>
                    <option value="100001-150000" {{ Request::get('price') == '100001-150000' ? 'selected' : '' }}>&#8358
                        100,001 - &#8358 150,000</option>
                    <option value="150001-200000" {{ Request::get('price') == '150001-200000' ? 'selected' : '' }}>&#8358
                        150,001 - &#8358 200,000</option>
                    <option value="200001-250000" {{ Request::get('price') == '200001-250000' ? 'selected' : '' }}>&#8358
                        200,001 - &#8358 250,000</option>
                    <option value="250001-300000" {{ Request::get('price') == '250001-300000' ? 'selected' : '' }}>&#8358
                        250,001 - &#8358 300,000</option>
                    <option value="300001-350000" {{ Request::get('price') == '300001-350000' ? 'selected' : '' }}>&#8358
                        300,001 - &#8358 350,000</option>
                    <option value="350001-400000" {{ Request::get('price') == '350001-400000' ? 'selected' : '' }}>&#8358
                        350,001 - &#8358 400,000</option>
                    <option value="400001-450000" {{ Request::get('price') == '400001-450000' ? 'selected' : '' }}>&#8358
                        400,001 - &#8358 450,000</option>
                    <option value="450001-500000" {{ Request::get('price') == '450001-500000' ? 'selected' : '' }}>&#8358
                        450,001 - &#8358 500,000</option>
                    <option value="500001-600000" {{ Request::get('price') == '500001-600000' ? 'selected' : '' }}>&#8358
                        500,001 - &#8358 600,000</option>
                    <option value="600001-700000" {{ Request::get('price') == '600001-700000' ? 'selected' : '' }}>&#8358
                        600,001 - &#8358 700,000</option>
                    <option value="700001-800000" {{ Request::get('price') == '700001-800000' ? 'selected' : '' }}>&#8358
                        700,001 - &#8358 800,000</option>
                    <option value="800001-900000" {{ Request::get('price') == '800001-900000' ? 'selected' : '' }}>&#8358
                        800,001 - &#8358 900,000</option>
                    <option value="900001-1000000" {{ Request::get('price') == '900001-1000000' ? 'selected' : '' }}>&#8358
                        900,001 - &#8358 1000,000</option>
                    <option value="1000001-1000000000000000" {{ Request::get('price') == '1000001-1000000000000000' ? 'selected' : '' }}>&#8358 
                        1000,000 and above</option>
                </select>
            </div>

            <div class="">
                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-funnel"></i> Filter</button>
            </div>

        </form>

        <div class="row d-flex justify-content-start" style="margin-bottom: 100px">
            @if ($adverts->count() > 0)
                <p class="text-muted fst-italic">({{ $adverts->count() }} result{{ $adverts->count() !== 1 ? 's' : '' }} )
                
                    @if (Request::has('location') && !empty(Request::get('location')))
                        , Location: {{ ucfirst(Request::get('location')) }}
                    @endif
                    @if (Request::has('school') && !empty(Request::get('school')))
                        , School: {{ ucfirst(Request::get('school')) }}
                    @endif
                    @if (Request::has('school_area') && !empty(Request::get('school_area')))
                        , Area: {{ ucfirst(Request::get('school_area')) }}
                    @endif
                    @if (Request::has('lodge') && !empty(Request::get('lodge')))
                        , Lodge: {{ ucfirst(Request::get('lodge')) }}
                    @endif
                    @if (Request::has('price') && !empty(Request::get('price')))
                        , Price: (&#8358) {{ Request::get('price') }}
                    @endif
                </p>

                @foreach ($adverts as $advert)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                        <a href="{{ route('lodge-detail', $advert->uuid) }}" class="text-decoration-none">
                            <div class="card shadow-lg" style="border-radius: 10px">
                                <img src="{{ asset($advert->cover_image) }}" class="card-img-top w-100"
                                    style="object-fit: cover; height:25vh" alt="">

                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="card-tittle fw-bold text-dark ">{{ ucfirst($advert->lodge->name) }}</h4>
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
                <p class="text-danger text-center">No lodge found</p>
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

        <script>
            // public/js/dropdown.js
            $(document).ready(function() {
                $('#location').change(function() {
                    const selectedLocationSlug = $(this).val();
                    if (selectedLocationSlug) {
                        // Make an AJAX request to fetch schools based on the selected location's slug
                        $.get(`/getSchools/${selectedLocationSlug}`, function(data) {
                            const schoolSelect = $('#school');
                            schoolSelect.empty().append('<option value="">School</option>');
                            $.each(data.schools, function(index, school) {
                                schoolSelect.append('<option value="' + school.slug + '">' +
                                    school.name + '</option>');
                            });
                            schoolSelect.removeAttr('disabled');
                        });
                    } else {
                        $('#school').attr('disabled', true);
                        $('#school_area').attr('disabled', true);
                    }
                });

                $('#school').change(function() {
                    const selectedSchoolSlug = $(this).val();
                    if (selectedSchoolSlug) {
                        // Make an AJAX request to fetch school areas based on the selected school's slug
                        $.get(`/getSchoolAreas/${selectedSchoolSlug}`, function(data) {
                            const schoolAreaSelect = $('#school_area');
                            schoolAreaSelect.empty().append('<option value="">Area</option>');
                            $.each(data.schoolAreas, function(index, schoolArea) {
                                schoolAreaSelect.append('<option value="' + schoolArea.slug +
                                    '">' + schoolArea.name + '</option>');
                            });
                            schoolAreaSelect.removeAttr('disabled');
                        });
                    } else {
                        $('#school_area').attr('disabled', true);
                    }
                });
            });
        </script>

    @endsection
