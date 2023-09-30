<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container">
        <div class="card w-100 mt-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">Edit Lodge</h3>
                <a href="{{ route('admin.lodge') }}" class="btn btn-success rounded-pill text-light p-1"
                    style="width: 12rem">All Lodge</a>
            </div>
        </div>
        <div class="card p-2 m-3 shadow-lg mx-auto ">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <form action="{{ route('admin.update-lodge', $lodge->id) }}" method="post" class="p-3"
                enctype="multipart/form-data">
                @method('put')
                @csrf

                <label for="">Lodge<span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" value="{{ ucfirst($lodge->name) }}"
                    class="form-control">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <label for="">Slug<span class="text-danger">*</span></label>
                <input type="text" name="slug" id="slug" value="{{ $lodge->slug }}" class="form-control">
                @error('slug')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <label for="cover_image" class="form-label">Cover Image<span class="text-danger">*</span></label>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" class="form-control">
                <img src="{{ asset($lodge->cover_image) }}" class="img-fluid my-2"
                    style="object-fit: cover; width:20vw; height:10vh" alt="">
                @error('cover_image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <div>
                    <button class="btn btn-success mt-2">Update</button>
                </div>

            </form>
        </div>
    </div>

    <script src="{{ asset('js/slug.js') }}"></script>
@endsection
