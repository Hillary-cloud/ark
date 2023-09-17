<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center pt-6 pt-sm-0 bg-gray-100">
        <div class="m-3">
            <img src="../loggo2.png" class="img-fluid" style="width: 200px" alt="">
        </div>
        
        <div class="container mt-6">
            <div class="mx-auto px-4 py-4 bg-white shadow overflow-hidden rounded-lg col-lg-6 col-md-10 col-sm-12 col-12">
              {{$slot}}
            </div>
        </div>
          
    </div>
@endsection