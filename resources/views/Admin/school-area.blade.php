<base href="/public">
@extends('layouts.base')
@section('content')
    
<style>
    nav svg {
        height: 20px;
    }

    nav .hidden {
        display: block !important;
    }
</style>
    <div class="container">
        <div class="card w-100 m-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">School Area</h3>
                <a href="{{route('admin.add-school-area')}}" class="btn btn-success rounded-pill text-light p-1" style="width: 12rem">Add School Area</a>
            </div>
        </div>
        <div class="card w-100 p-2 m-3">

            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @php
            use App\Models\SchoolArea;
        @endphp
        @if (SchoolArea::count() < 1)
            <p class="text-danger text-center">No Location found</p>
        @else
            <table class="table table-striped table-bordered table-hover text-center">
                <thead class="bg-success text-light">
                    <tr>
                        <th>n/s</th>
                        <th>School Area</th>
                        <th>Slug</th>
                        <th>School</th>
                        <th>State</th>
                        <th>Edit</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>

                    @php
                        $i = 1;
                    @endphp
                    @foreach ($school_areas as $school_area)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{ucfirst($school_area->name)}}</td>
                        <td>{{$school_area->slug}}</td>
                        <td>{{ucfirst($school_area->school->name)}}</td>
                        <td>{{ucfirst($school_area->school->location->state)}}</td>
                        <td>
                            <a href="{{route('admin.edit-school-area', $school_area->id)}}"><button class="btn btn-primary text-light">Edit</button></a>
                        </td>
                        <td>
                            <a href="{{route('admin.delete-school-area', $school_area->id)}}" onclick="return confirm('You are about to delete this school area')"><button class="btn btn-danger text-light">Delete</button></a>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            @endif
            {{-- {{ $school_areas->links() }} --}}
        </div>
    </div>
@endsection