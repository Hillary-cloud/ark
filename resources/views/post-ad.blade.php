<base href="/public">
@extends('layouts.base')
@section('content')
    <style>
        /* CSS Styling for the image previews */
        #otherImagesPreview {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
        }

        .imagePreview {
            margin: 10px;
            text-align: center;
        }

        .imagePreview img {
            display: block;
            margin-bottom: 5px;
        }
    </style>
    <div class="container">
        <div class="card w-100 my-3 shadow-sm p-2">
            <div class="d-flex justify-content-between">
                <h3>Post ad</h3>
                <a href="javascript:history.back()" class="text-decoration-none">< Back</a>
            </div>
        </div>

        <div class="card w-100 mx-auto my-3 shadow-sm">
            <form action="{{ route('store-ad') }}" class="p-4" method="POST" enctype="multipart/form-data" 
                id="postAdForm">
                @csrf

                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="mb-3">
                                <label for="lodge" class="form-label">Lodge<span class="text-danger">*</span></label>
                                <select class="form-control" name="lodge_id" id="lodge" onchange="generateSlug()">
                                    <option value="">Select Lodge</option>
                                    @foreach ($lodges as $lodge)
                                        <option value="{{ $lodge->id }}">{{ ucfirst($lodge->name) }}</option>
                                    @endforeach
                                </select>
                                @error('lodge_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <input type="hidden" id="slug" class="" name="slug">

                            <div class="mb-3">
                                <label for="location" class="form-label">Location<span class="text-danger">*</span></label>
                                <select class="form-control" name="location_id" id="location">
                                    <option value="">Select Location</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ ucfirst($location->state) }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="school" class="form-label">School<span class="text-danger">*</span></label>
                                <select class="form-control" name="school_id" id="school" disabled>
                                    <option value="">Select School</option>
                                </select>
                                @error('school_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="school_area" class="form-label">School Area<span class="text-danger">*</span></label>
                                <select class="form-control" name="school_area_id" id="school_area" disabled>
                                    <option value="">Select School Area</option>
                                </select>
                                @error('school_area_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cover_image" class="form-label">Cover Image<span class="text-danger">*</span></label>
                                <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                    class="form-control">
                                <div id="coverImagePreview" class="mt-2"></div>
                                @error('cover_image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="other_images" class="form-label">Other Images (not more than 4 images)</label>
                                <input type="file" name="other_images[]" id="other_images" accept="image/*"
                                    class="form-control" multiple max="4">
                                <div id="otherImagesPreview" class="mt-2"></div>
                                @error('other_images')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price(&#8358)<span class="text-danger">*</span></label>
                                <input type="number" name="price" id="price" value="{{ old('price') }}"
                                    class="form-control" step="0.01">
                                @error('price')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="agent_fee" class="form-label">Agent fee(&#8358)</label>
                                <input type="number" name="agent_fee" id="agent_fee" value="{{ old('agent_fee') }}"
                                    class="form-control" step="0.01">
                                @error('agent_fee')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" name="negotiable" value="{{ old('negotiable') }}"
                                    id="negotiable" class="form-check-input">
                                <label for="negotiable" class="form-check-label">Negotiable</label>
                                @error('negotiable')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                                <textarea name="description" id="description" placeholder="Give a detailed description of your ad" class="form-control"
                                    rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone number<span class="text-danger">*</span></label>
                                <input type="text" name="phone_number" id="phone_number"
                                    value="{{ old('phone_number') }}" placeholder="e.g, 080123456789"
                                    class="form-control">
                                    <p class="text-muted fst-italic">NB: Provide your active phone number as people will reach out to you through it.</p>
                                @error('phone_number')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">

                            <div class="mb-3">
                                {{-- <label for="seller_name" class="form-label">Name:</label> --}}
                                <input type="text" name="seller_name" id="seller_name"
                                    value="{{ ucfirst(auth()->user()->name) }}" class="form-control" readonly>
                                @error('seller_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>
                    <button type="submit" class="btn btn-light btn-outline-success btn-lg w-100">Post Ad</button>

                </div>

            </form>
        </div>
    </div>

<script src="{{asset('js/script.js')}}"></script>

@endsection
