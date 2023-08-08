<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container">
        <div class="card my-3 p-2">
            <div class="d-flex justify-content-between">
                <h3>Saved Ads</h3>
                <a href="javascript:history.back()" class="text-decoration-none">< Back</a>
            </div>
        </div>

        <div class="row d-flex justify-content-start" id="filtered-results">
            @if ($bookmarkedAds->isEmpty())
            <p class="text-danger text-center">You have no saved ad</p>
            @else
            @foreach ($bookmarkedAds as $bookmark)
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                <a href="{{route('property-detail',$bookmark->advert->uuid)}}" class="text-decoration-none">
                    <div class="card shadow-lg">
                        <img src="{{asset($bookmark->advert->cover_image)}}" class="card-img-top w-100" style="object-fit: cover; height:25vh" alt="">
                    </a>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-tittle fw-bold text-dark ">{{ucfirst($bookmark->advert->lodge->name)}}</h4>
                                {{-- <a href="{{route('delete-bookmark',$bookmark->id)}}"><button class="btn btn-danger btn-sm">Delete</button></a>                               --}}
                                <a href="{{ route('delete-bookmark', $bookmark->id) }}"
                                    onclick="event.preventDefault(); deleteBookmark('{{ route('delete-bookmark', $bookmark->id) }}')"
                                    class="btn text-danger"><i class="bi bi-trash"></i></a>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                            <p class="card-text fw-bold bg-success p-2 rounded-pill text-light w-52 text-center">&#8358 {{number_format($bookmark->advert->combined_price)}}</p>
                            <p class="card-text "><small class="text-muted">{{ucfirst($bookmark->advert->location->state)}}</small></p>
                        </div>
                        
                            <div class="d-flex justify-content-between mb-0">
                                <p class="card-text fw-bold text-dark">{{ucfirst($bookmark->advert->school->name)}}</p>
                                <p class="card-text text-dark">{{ucfirst($bookmark->advert->school_area->name)}}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                            <p class="card-text "><small class="text-muted">Listed {{($bookmark->advert->created_at)->diffForHumans()}}</small></p>
                            <i class="bi bi-eye"> {{ $bookmark->advert->view_count }}</i>
                            </div>
                        </div>
                    </div>
            </div>
            
            @endforeach
            
            @endif
            
        </div>
    </div>

    <script>
        function deleteBookmark(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to remove this saved ad',
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