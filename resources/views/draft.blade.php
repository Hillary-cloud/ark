<base href="/public">
@extends('layouts.base')
@section('content')

    <div class="container-fluid p-5">
        <div class="card w-100 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3>Draft</h3>
                <a href="javascript:history.back()" class="text-decoration-none">
                    < Back</a>
            </div>
        </div>
        @php
            use App\Models\Advert;
        @endphp
        @if (Advert::where(['user_id' => auth()->user()->id, 'draft' => true])->count() < 1)
            <p class="text-danger text-center">No draft found</p>
        @else
            <div class="row mx-auto w-100 ">
                @foreach ($adverts as $advert)
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">

                        <div class="card w-100 mt-3 shadow-lg">
                            <div class="card-header d-flex justify-content-between">
                                @if ($advert->service_id == null)
                                    <p>{{ ucfirst($advert->lodge->name) }}</p>
                                @else
                                    <p>{{ ucfirst($advert->service->name) }}</p>
                                @endif
                                <p>{{ ucfirst($advert->school_area->name) }}</p>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    @if ($advert->cover_image)
                                        <img class="my-auto" src="{{ asset($advert->cover_image) }}"
                                            style="object-fit: cover; height: 200px" class="img-fluid" width="50%"
                                            alt="">
                                    @endif

                                    <div class="my-auto">
                                        <a href="{{ route('edit-draft', $advert->uuid) }}"><button
                                                class="btn btn-light btn-outline-success btn-sm ">Edit</button></a>
                                        <a href="{{ route('delete-draft', $advert->uuid) }}"
                                            onclick="event.preventDefault(); deleteDraft('{{ route('delete-draft', $advert->uuid) }}')"
                                            class="btn btn-danger btn-sm text-light">Delete</a>
                                        {{-- <a href="{{route('delete-draft', $advert->uuid)}}"><button class="btn btn-danger btn-sm">Delete</button></a> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <p>{{ ucfirst($advert->location->state) }}</p>
                                @if ($advert->combined_price !== null)
                                <p>&#8358 {{ number_format($advert->combined_price) }}</p>
                                @else
                                    Price on contact
                                @endif
                                
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        function deleteDraft(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this draft',
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
