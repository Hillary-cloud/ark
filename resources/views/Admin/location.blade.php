<base href="/public">
@extends('layouts.base')
@section('content')

    <div class="container">
        <div class="card w-100 m-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">Location</h3>
                <a href="{{ route('admin.add-location') }}" class="btn btn-success rounded-pill text-light p-1"
                    style="width: 12rem">Add Location</a>
            </div>
        </div>
        <div class="card w-100 p-2 m-3">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @php
                use App\Models\Location;
            @endphp
            @if (Location::count() < 1)
                <p class="text-danger text-center">No Location found</p>
            @else
                <table class="table table-striped table-bordered table-hover text-center">
                    <thead class="bg-success text-light">
                        <tr class="align-middle text-center">
                            <th>n/s</th>
                            <th>State</th>
                            <th>Slug</th>
                            <th>Date Added</th>
                            <th>Edit</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($locations as $location)
                            <tr class="align-middle text-center">
                                <td>{{ $i++ }}</td>
                                <td>{{ ucfirst($location->state) }}</td>
                                <td>{{ $location->slug }}</td>
                                <td>{{ $location->created_at }}</td>
                                <td>
                                    <a href="{{route('admin.edit-location', $location->id)}}"><button class="btn btn-primary text-light">Edit</button></a>
                                </td>
                                <td>
                                    {{-- <a href="{{route('admin.delete-location', $location->id)}}" onclick="return confirm('You are about to delete this location')"><button class="btn btn-danger text-light">Delete</button></a> --}}
                                    <a href="{{ route('admin.delete-location', $location->id) }}"
                                        onclick="event.preventDefault(); deleteLocation('{{ route('admin.delete-location', $location->id) }}')"
                                        class="btn btn-danger text-light">Delete</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @endif
            </div>
        </div>
    </div>
    <script>
        function deleteLocation(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this location',
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
