<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container">
        <div class="card w-100 m-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">Edit Location</h3>
                <a href="{{ route('admin.location') }}" class="btn btn-success rounded-pill text-light p-1"
                    style="width: 12rem">All Location</a>
            </div>
        </div>
        <div class="card p-2 m-3 shadow-lg mx-auto ">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <form action="{{ route('admin.update-location', $location->id) }}" method="post" class="p-3">
                @method('put')
                @csrf

                <label for="">State</label>
                <input type="text" name="state" id="name" value="{{ ucfirst($location->state) }}" class="form-control">
                @error('state')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <label for="">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ $location->slug }}" class="form-control">
                @error('slug')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <button class="btn btn-success mt-2">Update</button>
            </form>
        </div>
    </div>

    <script src="{{asset('js/slug.js')}}"></script>
@endsection
