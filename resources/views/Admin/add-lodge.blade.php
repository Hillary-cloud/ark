<base href="/public">
@extends('layouts.base')
@section('content')
    
    <div class="container">
        <div class="card w-100 mt-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">Add Lodge</h3>
                <a href="{{route('admin.lodge')}}" class="btn btn-success rounded-pill text-light p-1" style="width: 6rem">All Lodge</a>
            </div>
        </div>
        <div class="card p-2 m-3 shadow-lg mx-auto ">
            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
            <form action="{{route('admin.store-lodge')}}" method="POST" class="p-3" enctype="multipart/form-data">
                @csrf
                <label for="">Lodge<span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" placeholder="add lodge name">
                @error('name')
                    <p class="text-danger">{{$message}}</p>
                @enderror
                <label for="">Slug<span class="text-danger">*</span></label>
                <input type="text" name="slug" id="slug" class="form-control" placeholder="add slug">
                @error('slug')
                    <p class="text-danger">{{$message}}</p>
                @enderror
                <label for="cover_image" class="form-label">Cover Image<span class="text-danger">*</span></label>
                <input type="file" name="cover_image" id="cover_image" accept="image/*"
                    class="form-control">
                <div id="coverImagePreview" class="mt-2"></div>
                @error('cover_image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <button class="btn btn-success mt-2">Submit</button>
            </form>
        </div>
    </div>
    
    <script src="{{asset('js/slug.js')}}"></script>

    <script>
$(document).ready(function() {

    // Function to preview the selected cover image
    function previewCoverImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#coverImagePreview").html('<img src="' + e.target.result +
                    '" width="150" height="100"/>');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

   
    // Preview the selected cover image
    $("#cover_image").on("change", function() {
        previewCoverImage(this);
    });

    // Preview the selected other images and replace old ones
    $("#other_images").on("change", function() {
        previewOtherImages(this);
    });

});

// Additional Function to remove the old cover image when selecting a new one
$("#cover_image").on("click", function() {
    // Remove the old cover image preview
    $("#coverImagePreview").html("");
});

    </script>

@endsection