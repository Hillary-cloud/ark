<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container w-75 mx-auto my-3">
        <div class="card p-2">
            <div class="d-flex justify-content-between">
                <h3>Draft</h3>
                <a href="javascript:history.back()" class="text-decoration-none">< Back</a>
            </div>
        </div>

        <div class="card shadow-sm my-2 p-3">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="">
                        <p><strong>Cover Image</strong></p>
                        <img src="{{ asset($advert->cover_image) }}" class="img-fluid w-100 h-25"
                            style="object-fit: cover;" alt="">
                    </div>

                    @if ($advert->other_images)
                        <p><strong>Other Images</strong></p>
                        @foreach ($advert->other_images as $images)
                            <img src="{{ asset($images) }}" class="img-fluid w-25 h-25 mb-2"
                                style="width:23%; object-fit: cover;" alt="">
                        @endforeach
                    @endif
                    @if ($advert->lodge_id !== null)
                    <p><strong>Lodge</strong> - {{ ucfirst($advert->lodge->name)}}</p>
                    @else
                    <p><strong>Service</strong> - {{ ucfirst($advert->service->name)}}</p>
                    @endif
                    
                    <p><strong>School Area</strong> - {{ ucfirst($advert->school_area->name)}}</p>
                    <p><strong>School</strong> - {{ ucfirst($advert->School->name)}}</p>
                    <p><strong>Location</strong> - {{ ucfirst($advert->location->state)}}</p>
                    <p><strong>Description</strong> - {{ ucfirst($advert->description)}}</p>
                    <p><strong>Name</strong> - {{ ucfirst($advert->seller_name)}}</p>
                    
                    
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                    @if ($advert->lodge_id !== null)
                    <form action="{{route('update-lodge-draft',$advert->uuid)}}" method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="price" class="form-label">Price(&#8358)<span class="text-danger">*</span></label>
                            <input type="number" name="price" id="price" value="{{ $advert->price }}"
                                class="form-control" step="0.01">
                            @error('price')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    
                    <div class="mb-3">
                        <label for="agent_fee" class="form-label">Agent fee(&#8358)</label>
                        <input type="number" name="agent_fee" id="agent_fee" value="{{ $advert->agent_fee }}"
                            class="form-control" step="0.01">
                        @error('agent_fee')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="negotiable" value="{{ $advert->negotiable }}"
                            id="negotiable" class="form-check-input">
                        <label for="negotiable" class="form-check-label">Negotiable</label>
                        @error('negotiable')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone number<span class="text-danger">*</span></label>
                        <input type="text" name="phone_number" id="phone_number"
                            value="{{ $advert->phone_number }}"
                            class="form-control">
                            <p class="text-muted fst-italic">NB: Provide your active phone number as people will reach out to you through it.</p>
                        @error('phone_number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class=" btn btn-primary btn-lg mx-auto w-100">Proceed to post this lodge</button>
                </form>
                    @else
                    <form action="{{route('update-service-draft',$advert->uuid)}}" method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="price" class="form-label">Price(&#8358)</label>
                            <input type="number" name="price" id="price"
                                class="form-control" onchange="handleInputToggle()" step="0.01">
                            @error('price')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="on_contact"
                            id="onContact" class="form-check-input" onchange="handleInputToggle()" value="1" @if($advert->on_contact) checked @endif>
                        <label for="on_contact" class="form-check-label">On Contact</label>
                        @error('on_contact')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone number<span class="text-danger">*</span></label>
                        <input type="text" name="phone_number" id="phone_number"
                            value="{{ $advert->phone_number }}"
                            class="form-control">
                            <p class="text-muted fst-italic">NB: Provide your active phone number as people will reach out to you through it.</p>
                        @error('phone_number')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class=" btn btn-primary btn-lg mx-auto w-100">Proceed to post this service</button>
                </form>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>

    <script>
function handleInputToggle() {
  const priceInput = document.getElementById('price');
  const onContactInput = document.getElementById('onContact');

  if (onContactInput.checked) {
    priceInput.value = ''; // Clear the value
    priceInput.disabled = true; // Disable the field
  } else if (priceInput.value !== '') {
    onContactInput.disabled = true; // Disable the checkbox
  } else {
    priceInput.disabled = false; // Enable the field
    onContactInput.disabled = false; // Enable the checkbox
  }
}
    </script>
@endsection