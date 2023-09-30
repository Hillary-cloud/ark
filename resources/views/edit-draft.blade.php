<base href="/public">
@extends('layouts.base')
@section('content')
    <div class="container mx-auto my-3">
        <div class="card p-2">
            <div class="d-flex justify-content-between">
                <h3>Edit Draft</h3>
                <a href="javascript:history.back()" class="text-decoration-none">
                    < Back</a>
            </div>
        </div>

        <div class="card shadow-sm my-2 p-3">
            <div class="row">
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
                                    @if ($advert->lodge_id !== null)
                                    <p>Lodge - {{ ucfirst($advert->lodge->name) }}</p>
                                @else
                                    <p>Service - {{ ucfirst($advert->service->name) }}</p>
                                @endif
            
                                <p>Location - {{ ucfirst($advert->location->state) }}</p>
                                <p>School - {{ ucfirst($advert->School->name) }}</p>
                                <p>School Area - {{ ucfirst($advert->school_area->name) }}</p>
                                <p>Description - {{ ucfirst($advert->description) }}</p>
                                
                                </td>
                                <td>
                                    <p>Name - {{ ucfirst($advert->seller_name) }}</p>
                                    <p>Phone - {{ ucfirst($advert->phone_number) }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> 
               
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="">
                        <p><strong>Cover Image</strong></p>
                        <img src="{{ asset($advert->cover_image) }}" style="object-fit: cover; border-radius:10px; width:50%; height:20vh"
                            alt="">
                    

                    @if ($advert->other_images)
                        <p><strong>Other Images</strong></p>
                        <div class="row justify-content-start mb-2 p-2">
                        @foreach ($advert->other_images as $images)
                        <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                            <img src="{{ asset($images) }}" class="mb-2"
                                style="width:100px; border-radius:10px; height: 15vh; object-fit: cover; " alt="">
                        </div>
                        @endforeach
                        </div>
                    @endif

                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                    @if ($advert->lodge_id !== null)
                        <form action="{{ route('update-lodge-draft', $advert->uuid) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="price" class="form-label">Price(&#8358)<span
                                        class="text-danger">*</span></label>
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
                                <input type="checkbox" name="negotiable" value="{{ $advert->negotiable }}" id="negotiable"
                                    class="form-check-input">
                                <label for="negotiable" class="form-check-label">Negotiable</label>
                                @error('negotiable')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone number<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="phone_number" id="phone_number"
                                    value="{{ $advert->phone_number }}" class="form-control">
                                <p class="text-muted fst-italic" style="font-size: 10px">NB: Provide your active phone number as people will reach
                                    out to you through it.</p>
                                @error('phone_number')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <button class=" btn btn-primary btn-lg mx-auto w-100">Proceed to post this lodge</button>
                        </form>
                    @else
                        <form action="{{ route('update-service-draft', $advert->uuid) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="price" class="form-label">Price(&#8358)</label>
                                <input type="number" name="price" value="{{ $advert->price }}" id="price" class="form-control"
                                    onchange="handleInputToggle()" step="0.01">
                                @error('price')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" name="on_contact" id="onContact" class="form-check-input"
                                    onchange="handleInputToggle()" value="1"
                                    @if ($advert->on_contact) checked @endif>
                                <label for="onContact" class="form-check-label">On Contact</label>
                                @error('on_contact')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone number<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="phone_number" id="phone_number"
                                    value="{{ $advert->phone_number }}" class="form-control">
                                <p class="text-muted fst-italic" style="font-size: 10px">NB: Provide your active phone number as people will reach
                                    out to you through it.</p>
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
