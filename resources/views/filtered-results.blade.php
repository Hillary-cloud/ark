<div class="row d-flex justify-content-start" id="filtered-results">
    @if ($adverts->count() > 0)

        <p class="text-muted fst-italic">({{ $adverts->count() }} ad{{ $adverts->count() !== 1 ? 's' : '' }})</p>

        @foreach ($adverts as $advert)
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 my-4">
                <a href="{{ route('property-detail', $advert->uuid) }}" class="text-decoration-none">
                    <div class="card shadow-lg">
                        <img src="{{ asset($advert->cover_image) }}" class="card-img-top w-100"
                            style="object-fit: cover; height:25vh" alt="">
                </a>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-tittle fw-bold text-dark ">{{ ucfirst($advert->lodge->name) }}</h4>
                        @auth
                            <a href="#"
                                class="bookmark-button {{ $advert->isBookmarkedByUser(Auth::user()) ? 'bookmarked' : '' }}"
                                data-ad-id="{{ $advert->id }}">
                                <i class="bi bi-bookmark-fill" style="font-size: 25px"></i>
                            </a>
                        @endauth

                    </div>

                    <div class="d-flex justify-content-between">
                        <p class="card-text fw-bold bg-success p-2 rounded-pill text-light w-52 text-center">&#8358
                            {{ number_format($advert->combined_price) }}</p>
                        <p class="card-text "><small class="text-muted">{{ ucfirst($advert->location->state) }}</small>
                        </p>
                    </div>

                    <div class="d-flex justify-content-between mb-0">
                        <p class="card-text fw-bold text-dark">{{ ucfirst($advert->school->name) }}</p>
                        <p class="card-text text-dark">{{ ucfirst($advert->school_area->name) }}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="card-text "><small class="text-muted">Listed
                                {{ $advert->created_at->diffForHumans() }}</small></p>
                        <i class="bi bi-eye"> {{ $advert->view_count }}</i>
                    </div>
                </div>
            </div>
</div>
@endforeach
@else
<p class="text-danger text-center">No ad found</p>
@endif

</div>
</div>
