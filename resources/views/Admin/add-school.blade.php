<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container">
        <div class="card w-100 mt-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">Add School</h3>
                <a href="{{ route('admin.school') }}" class="btn btn-success rounded-pill text-light p-1"
                    style="width: 12rem">All School</a>
            </div>
        </div>
        <div class="card p-2 m-3 shadow-lg mx-auto ">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <form action="{{ route('admin.store-school') }}" method="POST" class="p-3">
                @csrf

                <label class="" for=""> State</label>
                <select name="location_id" class="form-control" id="">
                    <option value="">--Select State--</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ ucfirst($location->state) }}</option>
                    @endforeach
                </select>
                @error('location_id')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <label for="">School</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="add school name">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <label for="">Slug</label>
                <input type="text" name="slug" id="slug" class="form-control" placeholder="add slug">
                @error('slug')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <button class="btn btn-success mt-2">Submit</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/slug.js') }}"></script>
@endsection
