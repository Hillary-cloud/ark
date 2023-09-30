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

        nav svg {
            height: 20px;
        }

        nav .hidden {
            display: block !important;
        }
    </style>

    <div class="container" style="margin-bottom: 100px">

        <div class="card w-100 mt-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">Ads</h3>
                <form class=" d-flex">
                    <input class=" me-2" style="width: 30vw;" type="search" name="query" value="{{ old('query', $query) }}"
                        placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light btn-success form-control-lg" type="submit"><i class="bi bi-search"
                            style="font-size: 20px"></i></button>
                </form>
            </div>
            @if ($adverts->isEmpty())
                <p class="text-danger text-center">Nothing was found.</p>
            @endif
        </div>
        <div class="card w-100 p-2 mt-3">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @php
                use App\Models\Advert;
            @endphp
            @if (Advert::count() < 1)
                <p class="text-danger text-center">No ad found</p>
            @else
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped table-bordered table-hover text-center">
                            <thead class="bg-success text-light">
                                <tr class="align-middle">
                                    <th>S/N</th>
                                    <th>Image</th>
                                    <th>Ads</th>
                                    <th>School</th>
                                    <th>Status</th>
                                    <th>View</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($adverts as $advert)
                                    <tr class="align-middle">
                                        <td>{{ $i++ }}</td>
                                        <td><img src="{{ asset($advert->cover_image) }}" class="img-fluid"
                                                style="object-fit: cover; width:10vw; height:10vh" alt=""></td>
                                        @if ($advert->service_id !== null)
                                            <td>{{ ucfirst($advert->service->name) }}</td>
                                        @else
                                            <td>{{ ucfirst($advert->lodge->name) }}</td>
                                        @endif

                                        <td>{{ ucfirst($advert->school->name) }}</td>
                                        @if ($advert->expiration_date == null && $advert->draft == false && $advert->active == false)
                                            <td class="text-danger fst-italic">De-listed</td>
                                        @else
                                            <td class="text-success fst-italic">Listed</td>
                                        @endif
                                        <td>
                                            <a href="{{ route('admin.view-ad', $advert->uuid) }}"><button
                                                    class="btn btn-success btn-sm text-light">View</button></a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.delete-ad', $advert->uuid) }}"
                                                onclick="event.preventDefault(); deleteAdByAdmin('{{ route('admin.delete-ad', $advert->uuid) }}')"
                                                class="btn btn-danger btn-sm text-light">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="pagination">
                {{ $adverts->links() }}
            </div>
        </div>
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
        function deleteAdByAdmin(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this ad',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        }
    </script>
@endsection
