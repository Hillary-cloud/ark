<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header bg-success d-flex justify-content-between">
                        <h5 class="text-light">Summary</h5>
                        <a href="javascript:history.back()" class="text-decoration-none" style="color: dark">
                            < Back</a>
                    </div>

                    <div class="card-body">
                        @if (isset($errorMessage))
                            <div class="alert alert-danger">
                                {{ $errorMessage }}
                            </div>
                        @endif
                        <img src="../loggo2.png" class="img-fluid mb-4" style="width: 150px" alt="">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ADVERT'S DETAILS</th>
                                        <th>SELLER'S DETAILS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            @if ($advert->service_id !== null)
                                                <p>Service: <span>{{ ucfirst($advert->service->name) }}</span></p>
                                            @else
                                                <p>Lodge: <span> {{ ucfirst($advert->lodge->name) }}</span></p>
                                            @endif

                                            <p>Location: <span> {{ ucfirst($advert->location->state) }}</span></p>
                                            <p>School: <span> {{ ucfirst($advert->school->name) }}</span></p>
                                            <p>School Area: <span> {{ ucfirst($advert->school_area->name) }}</span></p>
                                            @if ($advert->combined_price !== null)
                                                <p>Price: <span> &#8358 {{ number_format($advert->price) }}</span></p>
                                                <p>Agent Fee: <span> &#8358 {{ number_format($advert->agent_fee) }}</span>
                                                </p>
                                            @else
                                                <p>Price: <span> On Contact</span></p>
                                            @endif

                                            <p>Description: <span> {{ ucfirst($advert->description) }}</span></p>
                                        </td>
                                        <td>
                                            <p>Seller: <span> {{ ucfirst(auth()->user()->name) }}</span></p>
                                            <p>Phone: <span> {{ $advert->phone_number }}</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @if ($advert->combined_price !== null)
                                            <p><strong>Total:<span> &#8358
                                                    {{ number_format($advert->combined_price) }}</span></strong></p>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <p><strong>Cover Image</strong></p>
                        <div style="border-radius: 10px;" class="p-2 mb-3">
                            <img src="{{ asset($advert->cover_image) }}"
                                style="object-fit: cover; width:50%; height: 20vh; border-radius:10px" alt="">

                        </div>

                        @if ($advert->other_images)
                            <p><strong>Other Images</strong></p>
                            <div style="border-radius: 10px;">
                                <div class="row justify-content-start mb-2 p-2">
                                    @foreach ($advert->other_images as $images)
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                                            <img src="{{ asset($images) }}" class=" mb-2"
                                                style="height: 15vh; width:100%; object-fit: cover; border-radius:10px"
                                                alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('post', $advert->uuid) }}" method="POST">
                            @csrf

                            {{-- @if ($advert->expiration_date == null && $advert->draft == false && $advert->active == false)
                                <button type="submit" class="btn btn-primary w-100">Pay Now To Re-list ad</button>
                            @else
                                <button type="submit" class="btn btn-primary w-100">Pay Now</button>
                            @endif --}}

                            <button type="submit" class="btn btn-primary w-100">Re-list</button>
                        </form>

                        {{-- uncomment this form if you want the user to make payment before relisting --}}
                        {{-- <form action="{{ route('pay', $advert->uuid) }}" method="POST">
                            @csrf

                            @if ($advert->expiration_date == null && $advert->draft == false && $advert->active == false)
                                <button type="submit" class="btn btn-primary w-100">Pay Now To Re-list ad</button>
                            @else
                                <button type="submit" class="btn btn-primary w-100">Pay Now</button>
                            @endif

                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

