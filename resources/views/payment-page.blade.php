<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Payment Details</h5>
                        <a href="javascript:history.back()" class="text-decoration-none">< Back</a>
                    </div>

                    <div class="card-body">
                        @if ($advert->service_id !== null)
                            <p><strong>Service:</strong> {{ ucfirst($advert->service->name) }}</p>
                        @else
                            <p><strong>Lodge:</strong> {{ ucfirst($advert->lodge->name) }}</p>
                        @endif
                        
                        
                        <p><strong>Location:</strong> {{ ucfirst($advert->location->state) }}</p>
                        <p><strong>School:</strong> {{ ucfirst($advert->school->name) }}</p>
                        <p><strong>School Area:</strong> {{ ucfirst($advert->school_area->name) }}</p>
                        @if ($advert->combined_price !== null)
                            <p><strong>Price:</strong> &#8358 {{ number_format($advert->combined_price) }}</p>
                        @else
                            <p><strong>Price:</strong> On Contact</p>
                        @endif
                        
                        <p><strong>Description:</strong> {{ ucfirst($advert->description) }}</p>
                        <form action="{{ route('pay', $advert->uuid) }}" method="POST">
                            @csrf

                            @if ($advert->expiration_date == null && $advert->draft == false && $advert->active == false)
                                <button type="submit" class="btn btn-primary w-100">Pay Now To Re-list ad</button>
                            @else
                                <button type="submit" class="btn btn-primary w-100">Pay Now</button>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
