<base href="/public">
@extends('layouts.base')
@section('content')

    <div class="container">

        <div class="card w-100 mt-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">Ads</h3>
                <form class=" d-flex">
                    <input class=" me-2" style="width: 30vw;" type="search" name="query" value="{{ old('query', $query) }}" placeholder="Search" aria-label="Search" >
                    <button class="btn btn-outline-light btn-success form-control-lg" type="submit"><i class="bi bi-search" style="font-size: 20px"></i></button>
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
                <div class="col-12">
                    <table class="table table-striped table-bordered table-hover text-center">
                        <thead class="bg-success text-light">
                            <tr class="align-middle">
                                <th>n/s</th>
                                <th>Image</th>
                                <th>Lodge</th>
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
                                    <td><img src="{{asset($advert->cover_image)}}" class="img-fluid" style="object-fit: cover; width:10vw; height:10vh" alt=""></td>
                                    <td>{{ ucfirst($advert->lodge->name) }}</td>
                                    <td>{{ ucfirst($advert->school->name) }}</td>
                                    @if ($advert->expiration_date == null && $advert->draft == false && $advert->active == false)
                                        <td class="text-danger fst-italic">De-listed</td>
                                    @else
                                        <td class="text-success fst-italic">Listed</td>
                                    @endif
                                    <td>
                                        <a href="{{route('admin.view-ad',$advert->uuid)}}"><button class="btn btn-success btn-sm text-light">View</button></a>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.delete-ad',$advert->uuid)}}" onclick="return confirm('You are about to delete this advert')"><button class="btn btn-danger btn-sm text-light">Delete</button></a>
                                    </td>
                                </tr>
                            @endforeach
    
                        </tbody>
                    </table>
                </div>
            </div>
                
            @endif
        </div>
    </div>
@endsection
