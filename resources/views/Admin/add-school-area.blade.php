<base href="/public">
@extends('layouts.base')
@section('content')
    
    <div class="container">
        <div class="card w-100 m-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3 class="fw-bold">Add School Area</h3>
                <a href="{{route('admin.school-area')}}" class="btn btn-success rounded-pill text-light p-1" style="width: 12rem">All School Area</a>
            </div>
        </div>
        <div class="card w-50 p-2 m-3 shadow-lg mx-auto ">
            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
            <form action="{{route('admin.store-school-area')}}" method="POST" class="p-3">
                @csrf

                <label class="" for="">School</label>
                <select name="school_id" class="form-control" id="">
                    <option value="">--Select School--</option>
                    @foreach ($schools as $school)
                        <option value="{{$school->id}}">{{ucfirst($school->name)}}</option>
                    @endforeach
                </select>
                @error('school_id')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <label for="">School Area</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="add school area">
                @error('name')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <label for="">Slug</label>
                <input type="text" name="slug" id="slug" class="form-control" placeholder="add slug">
                @error('slug')
                    <p class="text-danger">{{$message}}</p>
                @enderror
                <button class="btn btn-success mt-2">Submit</button>
            </form>
        </div>
    </div>
    

    <script src="{{asset('js/slug.js')}}"></script>

@endsection