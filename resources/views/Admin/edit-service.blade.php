<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container">
        <div class="card w-100 m-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">Edit Service</h3>
                <a href="{{ route('admin.service') }}" class="btn btn-success rounded-pill text-light p-1"
                    style="width: 12rem">All Service</a>
            </div>
        </div>
        <div class="card p-2 m-3 shadow-lg mx-auto ">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <form action="{{ route('admin.update-service', $service->id) }}" method="post" class="p-3">
                @method('put')
                @csrf

                <label for="">Service</label>
                <input type="text" name="name" id="name" value="{{ ucfirst($service->name) }}" class="form-control">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <label for="">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ $service->slug }}" class="form-control">
                @error('slug')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <button class="btn btn-success mt-2">Update</button>
            </form>
        </div>
    </div>

    <script src="{{asset('js/slug.js')}}"></script>
@endsection
