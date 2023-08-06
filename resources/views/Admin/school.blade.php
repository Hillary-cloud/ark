<base href="/public">
@extends('layouts.base')
@section('content')
    
    <div class="container">
        <div class="card w-100 m-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">School</h3>
                <a href="{{route('admin.add-school')}}" class="btn btn-success rounded-pill text-light p-1" style="width: 12rem">Add School</a>
            </div>
        </div>
        <div class="card w-100 p-2 m-3">

            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @php
            use App\Models\School;
        @endphp
        @if (School::count() < 1)
            <p class="text-danger text-center">No School found</p>
        @else
            <table class="table table-striped table-bordered table-hover text-center">
                <thead class="bg-success text-light">
                    <tr>
                        <th>n/s</th>
                        <th>School</th>
                        <th>Slug</th>
                        <th>State</th>
                        <th>Edit</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($schools as $school)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{ucfirst($school->name)}}</td>
                        <td>{{$school->slug}}</td>
                        <td>{{ucfirst($school->location->state)}}</td>
                        <td>
                            <a href="{{route('admin.edit-school', $school->id)}}"><button class="btn btn-primary text-light">Edit</button></a>
                        </td>
                        <td>
                            <a href="{{ route('admin.delete-school', $school->id) }}"
                                onclick="event.preventDefault(); deleteSchool('{{ route('admin.delete-school', $school->id) }}')"
                                class="btn btn-danger text-light">Delete</a>
                        </td>
                    </tr>        
                    @endforeach
                
                </tbody>
            </table>
            @endif
        </div>
    </div>

    <script>
        function deleteSchool(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this school',
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