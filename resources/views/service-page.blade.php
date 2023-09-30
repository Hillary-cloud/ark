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

        .scrollable-selects {
            overflow-x: auto;
            white-space: nowrap;
        }

        /* Optional: Add some padding for better appearance */
        .scrollable-selects select {
            width: 100%;
            height: 30px;
            margin-right: 10px;
            /* Adjust as needed */
        }
    </style>

    <div class="container my-4">
        <div class="d-flex justify-content-between mb-3">
            <h3 class="">Listed {{ ucfirst($service->name) }}</h3>
            <a href="javascript:history.back()" class="text-decoration-none">
                < Back</a>
        </div>

        <form action="" method="GET" class="row g-3">
            <div class="container p-2" style="border-radius:5px;">
                <div class="scrollable-selects">
                    <div class="d-flex justify-content-start">
                        <div class="">
                            <select style="width: 150px; height: 40px" name="location" id="location">
                                <option value="">Location</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->slug }}"
                                        {{ Request::get('location') == $location->slug ? 'selected' : '' }}>
                                        {{ ucfirst($location->state) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="">
                            <select style="width: 150px; height: 40px" name="school" id="school" disabled>
                                <option value="">School</option>
                            </select>
                        </div>

                        <div class="">
                            <select style="width: 150px; height: 40px" name="school_area" id="school_area" disabled>
                                <option value=""> Area</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="">
                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-funnel"></i> Filter</button>
            </div>

        </form>

        <div class="row d-flex justify-content-start" style="margin-bottom: 100px">
            @if ($ads->count() > 0)
                <p class="text-muted fst-italic">({{ $ads->count() }} result{{ $ads->count() !== 1 ? 's' : '' }})
                    @if (Request::has('location') && !empty(Request::get('location')))
                        , Location: {{ ucfirst(Request::get('location')) }}
                    @endif
                    @if (Request::has('school') && !empty(Request::get('school')))
                        , School: {{ ucfirst(Request::get('school')) }}
                    @endif
                    @if (Request::has('school_area') && !empty(Request::get('school_area')))
                        , Area: {{ ucfirst(Request::get('school_area')) }}
                    @endif
                </p>

                @foreach ($ads as $advert)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                        <a href="{{ route('service-detail', $advert->uuid) }}" class="text-decoration-none">
                            <div class="card shadow-lg" style="border-radius: 10px">
                                <img src="{{ asset($advert->cover_image) }}" class="card-img-top w-100"
                                    style="object-fit: cover; height:25vh" alt="">

                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="card-tittle fw-bold text-dark ">{{ ucfirst($advert->service->name) }}
                                        </h4>
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
                    {{ $ads->links() }}
                </div>
            @else
                <p class="text-danger text-center">No service found</p>
            @endif
        </div>
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
