<base href="/public">
@extends('layouts.base')
@section('content')

    <div class="container" style="margin-bottom: 100px;">

        <div class="card w-100 mt-3 shadow-sm p-2">
             <div class="d-flex justify-content-between">
                <h3 class="">My Ads</h3>
                {{-- <form class=" d-flex">
                    <input class=" me-2" style="width: 30vw;" type="search" name="query" value="{{ old('query', $query) }}" placeholder="Search" aria-label="Search" >
                    <button class="btn btn-outline-light btn-success form-control-lg" type="submit"><i class="bi bi-search" style="font-size: 20px"></i></button>
                </form> --}}
            </div>
           
        </div>
        @if ($adverts->isEmpty())
        <p class="text-danger text-center">No ad found</p>
        @endif
        <div class="card w-100 p-2 mt-3">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
       
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped table-bordered table-hover text-center">
                        <thead class="bg-success text-light">
                            <tr class="align-middle">
                                <th>Image</th>
                                <th>Lodge</th>
                                <th>School Area</th>
                                <th>View</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                            @foreach ($adverts as $advert)
                                <tr class="align-middle">
                                    <td><img src="{{asset($advert->cover_image)}}" class="img-fluid" style="object-fit: cover; border-radius:5px; width:100px; height:50px" alt=""></td>
                                    @if ($advert->service_id !== null)
                                    <td>{{ ucfirst($advert->service->name) }}</td>
                                    @else
                                    <td>{{ ucfirst($advert->lodge->name) }}</td>
                                    @endif
                                    <td>{{ ucfirst($advert->school_area->name) }}</td>
                                    
                                    <td>
                                        <a href="{{route('view-my-ad',$advert->uuid)}}"><button class="btn btn-success btn-sm text-light">View</button></a>
                                    </td>
                                    <td>
                                        {{-- <a href="{{route('delete-my-ad',$advert->uuid)}}" onclick="return confirm('You are about to delete this advert')"><button class="btn btn-danger btn-sm text-light">Delete</button></a> --}}
                                        <a href="{{ route('delete-my-ad', $advert->uuid) }}"
                                            onclick="event.preventDefault(); deleteAdByUser('{{ route('delete-my-ad', $advert->uuid) }}')"
                                            class="btn btn-danger btn-sm text-light">Delete</a>
                                    </td>
                                    @if ($advert->expiration_date == null && $advert->draft == false && $advert->active == false)
                                    <td>
                                        <a href="{{route('relist',$advert->uuid)}}"><button class="btn btn-primary btn-sm text-light">Re-list</button></a>
                                    </td>
                                @endif 
                                </tr>
                            @endforeach
    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteAdByUser(deleteUrl) {
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
