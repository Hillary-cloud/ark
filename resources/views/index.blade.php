<base href="/public">
@extends('layouts.base')
@section('content')

<style>
    /* Add your CSS styles here */
    #back-to-top {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: green;
        color: white;
        border: none;
        border-radius: 50%;
        padding: 10px;
        cursor: pointer;
    }

    #back-to-top.show {
        display: block;
    }
</style>

<header class="text-light" 
style="
background-image: url('../post-single-1.jpg'); 
height: 400px;
background-size: cover;
background-position: center;
background-size: 100%;
background-repeat: no-repeat;
">
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
        <div class="container-fluid h-100" style="padding-left: 10%; padding-top: 100px;">
            <h1 class="display-5">dolfin</h1>
            <p class="col-md-8 lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            <form class="mt-5 d-flex">
                <input class=" me-2" style="width: 450px; height: 50px" type="search" name="query" value="{{ old('query', $query) }}" placeholder="Search" aria-label="Search" >
                <button class="btn btn-outline-light btn-success form-control-lg" type="submit"><i class="bi bi-search" style="font-size: 20px"></i></button>
            </form>
            @if ($adverts->isEmpty())
            <p class="text-danger">Nothing was found.</p>
            @endif
        </div>
    </div>
</header>

<main>
    <div class="container" >
        <div class="my-5 text-center">
            <h1 class="fw-bold text-success">Featured Lodges</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing Lorem ipsum dolor sit amet consectetur adipisicing</p>
        </div>
        <div class="row d-flex justify-content-evenly text-center">
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../property-1.jpg" class="shadow-lg img-thumbnail img-fluid w-75" alt="">
                <h6 class="fw-bold">Self contain</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../property-1.jpg" class="shadow-lg img-thumbnail img-fluid w-75" alt="">
                <h6 class="fw-bold">Short let</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../property-1.jpg" class="shadow-lg img-thumbnail img-fluid w-75" alt="">
                <h6 class="fw-bold">Flat</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../property-1.jpg" class="shadow-lg img-thumbnail img-fluid w-75" alt="">
                <h6 class="fw-bold">Single room</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-4 my-2">
                <img src="../property-1.jpg" class="shadow-lg img-thumbnail img-fluid w-75" alt="">
                <h6 class="fw-bold">Roomie</h6>
            </div>
        </div>
    </div>
    
    <div class="container my-4 ">
        <h4 class="fw-bold">Listed Lodges</h4>
        <form action="{{route('/')}}" method="GET" id="filter-form">
            <div class="mb-3">
            <select style="width:70px" name="lodge" id="lodge">
                <option value="">Lodge</option>
                @foreach ($lodges as $lodge)
                <option value="{{$lodge->id}}" {{Request::get('lodge_id') == $lodge->id ? 'selected' : ''}}>{{ucfirst($lodge->name)}}</option>
                @endforeach
            </select>
            <select style="width:70px" name="school" id="school">
                <option value="">School</option>
                @foreach ($schools as $school)
                <option value="{{$school->id}}" {{Request::get('school_id') == $school->id ? 'selected' : ''}}>{{ucfirst($school->name)}}</option>
                @endforeach
               
            </select>
            <select style="width: 60px" name="price" id="price">
                <option value="">Price</option>
                <option value="0-50000" {{Request::get('0-50000') == 0-50000 ? 'selected' : ''}}>&#8358 0 - &#8358 50,000</option>
                <option value="50001-100000" {{Request::get('50001-100000') == 50001-100000 ? 'selected' : ''}}>&#8358 50,001 - &#8358 100,000</option>
                <option value="100001-150000" {{Request::get('100001-150000') == 100001-150000 ? 'selected' : ''}}>&#8358 100,001 - &#8358 150,000</option>
                <option value="150001-200000" {{Request::get('150001-200000') == 150001-200000 ? 'selected' : ''}}>&#8358 150,001 - &#8358 200,000</option>
                <option value="200001-100000000000" {{Request::get('200001-100000000000') == 200001-100000000000 ? 'selected' : ''}}>&#8358 200,001 and above</option>
            </select>
        </div>
        <div>
            <select style="width:110px" name="school_area" id="school_area">
                <option value="">School Area</option>
                @foreach ($school_areas as $school_area)
                <option value="{{$school_area->id}}" {{Request::get('school_area_id') == $school_area->id ? 'selected' : ''}}>{{ucfirst($school_area->name)}}</option>
                @endforeach
                
            </select>
           
            <select style="width:80px" name="location" id="location">
                <option value="">Location</option>
                @foreach ($locations as $location)
                <option value="{{$location->id}}" {{Request::get('location_id') == $location->id ? 'selected' : ''}}>{{ucfirst($location->state)}}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-success btn-sm" id="filter-button"><i class="bi bi-funnel"></i> Filter</button>
        </div>
        </form>

        @include('filtered-results')
    </div>
</main>
<footer style="width:100%" class=" bg-success align-middle text-center">
    <div class="container" >
      <div class="row mt-3">
        <div class="col-md-6">
          <p class="text-light">&copy; 2023 Tetmart. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-md-end ">
          <p>
            <a style="color: black" href="#"><i class="bi bi-instagram"></i> </a>
             <a class="mx-3" style="color: black" href="#"><i class="bi bi-twitter"></i></a>
            <a style="color: black" href="#"><i class="bi bi-facebook"></i></a>
        </p>
        </div>
      </div>
    </div>
  </footer>

<button id="back-to-top" class="show"><i class="bi bi-arrow-up"></i></button>
    
<script>
    const backToTopButton = document.getElementById('back-to-top');

    // Show/hide the button based on scroll position
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
    });

    // Scroll smoothly to the top when the button is clicked
    backToTopButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>

<script>
   $(document).ready(function() {
        $('#filter-button').on('click', function(event) {
            event.preventDefault();

            // Get the form data
            var formData = $('#filter-form').serialize();

            // Perform the AJAX request to submit the form data and get the filtered results
            $.ajax({
                type: 'GET',
                url: '{{ route("filtered-advert") }}',
                data: formData,
                success: function(response) {
                    // Update the content of the 'filtered-results' div with the filtered data
                    $('#filtered-results').html(response);

                    
                },
                error: function(error) {
                    console.error('Error: ', error);
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const bookmarkButtons = document.querySelectorAll('.bookmark-button');

    bookmarkButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const adId = this.dataset.adId;
            toggleBookmark(adId, this);
        });
    });
});

function toggleBookmark(adId, button) {
    axios.post('{{ route('bookmark.toggle') }}', { advert_id: adId })
        .then(response => {
            if (response.data.message === 'Ad bookmarked') {
                button.classList.add('bookmarked');
            } else {
                button.classList.remove('bookmarked');
            }
        })
        .catch(error => {
            console.error(error);
        });
}

</script>

@endsection