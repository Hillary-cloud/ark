<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container">
        <div class="card w-100 m-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">Edit School Area</h3>
                <a href="{{ route('admin.school-area') }}" class="btn btn-success rounded-pill text-light p-1"
                    style="width: 12rem">All School Area</a>
            </div>
        </div>
        <div class="card p-2 m-3 shadow-lg mx-auto ">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <form action="{{ route('admin.update-school-area', $school_area->id) }}" method="POST" class="p-3">
                @method('put')
                @csrf

                <label class="" for="">State</label>
                <input type="text" name="location_id" class="form-control"
                    value="{{ ucfirst($school_area->school->location->state) }}" readonly>
                <input type="hidden" name="location_id" value="{{ $school_area->school->location_id }}">

                <label class="" for="">School</label>
                <input type="text" name="school_id" class="form-control"
                    value="{{ ucfirst($school_area->school->name) }}" readonly>
                <input type="hidden" name="school_id" value="{{ $school_area->school_id }}">

                <label for="">School Area</label>
                <input type="text" name="name" id="name" value="{{ $school_area->name }}" class="form-control">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <label for="">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ $school_area->slug }}" class="form-control">
                @error('slug')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <button class="btn btn-success mt-2">Update</button>
            </form>
        </div>
    </div>

    <script src="{{asset('js/slug.js')}}"></script>
@endsection
