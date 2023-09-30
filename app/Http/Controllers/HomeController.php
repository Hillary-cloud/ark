<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lodge;
use App\Models\Advert;
use App\Models\AdView;
use App\Models\School;
use App\Models\Service;
use App\Models\Location;
use App\Models\SchoolArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Jorenvh\Share\ShareFacade as Share;
use Illuminate\Support\Facades\Request as FacadesRequest;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query');

        // Query for Lodge Ads
        $lodgeAdsQuery = Advert::where('active', true)
            ->where('draft', false)
            ->whereNotNull('lodge_id')
            ->where('expiration_date', '>', Carbon::now())
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->join('locations', 'locations.id', '=', 'adverts.location_id')
                    ->join('schools', 'schools.id', '=', 'adverts.school_id')
                    ->join('school_areas', 'school_areas.id', '=', 'adverts.school_area_id')
                    ->join('lodges', 'lodges.id', '=', 'adverts.lodge_id')
                    ->where(function ($innerQueryBuilder) use ($query) {
                        $innerQueryBuilder->where('adverts.description', 'like', '%' . $query . '%')
                            ->orWhere('schools.name', 'like', '%' . $query . '%')
                            ->orWhere('school_areas.name', 'like', '%' . $query . '%')
                            ->orWhere('lodges.name', 'like', '%' . $query . '%')
                            ->orWhere('locations.state', 'like', '%' . $query . '%');
                    });
            });

        // Query for Service Ads
        $serviceAdsQuery = Advert::where('active', true)
            ->where('draft', false)
            ->whereNotNull('service_id')
            ->where('expiration_date', '>', Carbon::now())
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->join('locations', 'locations.id', '=', 'adverts.location_id')
                    ->join('schools', 'schools.id', '=', 'adverts.school_id')
                    ->join('school_areas', 'school_areas.id', '=', 'adverts.school_area_id')
                    ->join('services', 'services.id', '=', 'adverts.service_id')
                    ->where(function ($innerQueryBuilder) use ($query) {
                        $innerQueryBuilder->where('adverts.description', 'like', '%' . $query . '%')
                            ->orWhere('schools.name', 'like', '%' . $query . '%')
                            ->orWhere('school_areas.name', 'like', '%' . $query . '%')
                            ->orWhere('services.name', 'like', '%' . $query . '%')
                            ->orWhere('locations.state', 'like', '%' . $query . '%');
                    });
            });

        // Paginate Lodge Ads
        $lodgeAds = $lodgeAdsQuery->paginate(8);

        // Paginate Service Ads
        $serviceAds = $serviceAdsQuery->paginate(8);

        $lodges = Lodge::all();
        $services = Service::all();

        return view('index', compact('lodgeAds', 'serviceAds', 'query', 'lodges', 'services'));
    }


    public function viewMoreLodges(Request $request)
    {
        $query = Advert::query();

        // Apply filters if provided in the request
        if ($request->filled('location')) {
            // Assuming the 'location' parameter now contains the location slug
            $locationSlug = $request->input('location');

            // Retrieve the location based on the slug
            $location = Location::where('slug', $locationSlug)->first();

            if ($location) {
                // Use the location's ID in the query
                $query->where('location_id', $location->id);
            }
        }

        if ($request->filled('school')) {
            // Assuming the 'school' parameter now contains the school slug
            $schoolSlug = $request->input('school');

            // Retrieve the school based on the slug
            $school = School::where('slug', $schoolSlug)->first();

            if ($school) {
                // Use the school's ID in the query
                $query->where('school_id', $school->id);
            }
        }

        if ($request->filled('school_area')) {
            // Assuming the 'school_area' parameter now contains the school area slug
            $schoolAreaSlug = $request->input('school_area');

            // Retrieve the school area based on the slug
            $schoolArea = SchoolArea::where('slug', $schoolAreaSlug)->first();

            if ($schoolArea) {
                // Use the school area's ID in the query
                $query->where('school_area_id', $schoolArea->id);
            }
        }

        if ($request->filled('lodge')) {
            // Assuming the 'lodge' parameter now contains the lodge slug
            $lodgeSlug = $request->input('lodge');

            // Retrieve the lodge based on the slug
            $lodge = Lodge::where('slug', $lodgeSlug)->first();

            if ($lodge) {
                // Use the lodge's ID in the query
                $query->where('lodge_id', $lodge->id);
            }
        }

        if ($request->filled('price')) {
            // Extract the price range from the request (e.g., '0-100000')
            $priceRange = explode('-', $request->input('price'));
            $minPrice = (int) $priceRange[0];
            $maxPrice = (int) $priceRange[1];

            // Filter the adverts where combined_price is within the selected range
            $query->whereBetween('combined_price', [$minPrice, $maxPrice]);
        }

        // Additional conditions for active, draft, and expiration date
        $adverts = $query->where('active', true)
            ->where('draft', false)
            ->whereNotNull('lodge_id')
            ->where('expiration_date', '>', Carbon::now())->paginate(50);

        $locations = Location::all();
        $schools = School::all();
        $school_areas = SchoolArea::all();
        $lodges = Lodge::all();

        return view('more-lodges', compact('adverts', 'locations', 'schools', 'school_areas', 'lodges'));
    }

    public function viewMoreServices(Request $request)
    {
        $query = Advert::query();

        // Apply filters if provided in the request
        if ($request->filled('location')) {
            // Assuming the 'location' parameter now contains the location slug
            $locationSlug = $request->input('location');

            // Retrieve the location based on the slug
            $location = Location::where('slug', $locationSlug)->first();

            if ($location) {
                // Use the location's ID in the query
                $query->where('location_id', $location->id);
            }
        }

        if ($request->filled('school')) {
            // Assuming the 'school' parameter now contains the school slug
            $schoolSlug = $request->input('school');

            // Retrieve the school based on the slug
            $school = School::where('slug', $schoolSlug)->first();

            if ($school) {
                // Use the school's ID in the query
                $query->where('school_id', $school->id);
            }
        }

        if ($request->filled('school_area')) {
            // Assuming the 'school_area' parameter now contains the school area slug
            $schoolAreaSlug = $request->input('school_area');

            // Retrieve the school area based on the slug
            $schoolArea = SchoolArea::where('slug', $schoolAreaSlug)->first();

            if ($schoolArea) {
                // Use the school area's ID in the query
                $query->where('school_area_id', $schoolArea->id);
            }
        }

        if ($request->filled('service')) {
            // Assuming the 'service' parameter now contains the service slug
            $serviceSlug = $request->input('service');

            // Retrieve the service based on the slug
            $service = Service::where('slug', $serviceSlug)->first();

            if ($service) {
                // Use the service's ID in the query
                $query->where('service_id', $service->id);
            }
        }
        // Additional conditions for active, draft, and expiration date
        $ads = $query->where('active', true)
            ->where('draft', false)
            ->whereNotNull('service_id')
            ->where('expiration_date', '>', Carbon::now())->paginate(50);

        $locations = Location::all();
        $schools = School::all();
        $school_areas = SchoolArea::all();
        $services = Service::all();

        return view('more-services', compact('ads', 'locations', 'schools', 'school_areas', 'services'));
    }

    public function getSchoolsBySlug($locationSlug)
    {
        $location = Location::where('slug', $locationSlug)->firstOrFail();
        $schools = $location->schools;

        return response()->json(['schools' => $schools]);
    }

    public function getSchoolAreasBySlug($schoolSlug)
    {
        $school = School::where('slug', $schoolSlug)->firstOrFail();
        $schoolAreas = $school->school_areas;

        return response()->json(['schoolAreas' => $schoolAreas]);
    }

    public function lodgeDetail($uuid)
    {
        $advert = Advert::where('uuid', $uuid)->firstOrFail();

        // Check if the user is authenticated
        if (Auth::check()) {
            $userId = Auth::id();

            // Check if the user has already viewed the ad
            $existingView = AdView::where('user_id', $userId)
                ->where('advert_id', $advert->id)
                ->first();

            if (!$existingView) {
                // Increment the view count
                $advert->increment('view_count');

                // Record the view in the ad_views table
                AdView::create([
                    'user_id' => $userId,
                    'advert_id' => $advert->id,
                ]);
            }
        }


        $adverts = Advert::where('active', true)
            ->where('draft', false)
            ->where('expiration_date', '>', Carbon::now())
            ->where('school_id', $advert->school->id)
            ->where('lodge_id', $advert->lodge->id)
            ->whereNotIn('uuid', [$uuid])->get();

        $shareButton = Share::page(url()->current())
            ->facebook()
            ->twitter()
            ->whatsapp();

        return view('lodge-detail', compact('advert', 'adverts', 'shareButton'));
    }

    public function serviceDetail($uuid)
    {
        $advert = Advert::where('uuid', $uuid)->firstOrFail();

        // Check if the user is authenticated
        if (Auth::check()) {
            $userId = Auth::id();

            // Check if the user has already viewed the ad
            $existingView = AdView::where('user_id', $userId)
                ->where('advert_id', $advert->id)
                ->first();

            if (!$existingView) {
                // Increment the view count
                $advert->increment('view_count');

                // Record the view in the ad_views table
                AdView::create([
                    'user_id' => $userId,
                    'advert_id' => $advert->id,
                ]);
            }
        }

        $adverts = Advert::where('active', true)
            ->where('draft', false)
            ->where('expiration_date', '>', Carbon::now())
            ->where('school_id', $advert->school->id)
            ->where('service_id', $advert->service->id)
            ->whereNotIn('uuid', [$uuid])->get();

        $shareButton = Share::page(url()->current())
            ->facebook()
            ->twitter()
            ->whatsapp();

        return view('service-detail', compact('advert', 'adverts', 'shareButton'));
    }

    public function lodgePage(Request $request, $slug)
    {
        $lodge = Lodge::where('slug', $slug)->firstOrFail();

        $query = Advert::query();

        // Apply filters if provided in the request
        if ($request->filled('location')) {
            // Assuming the 'location' parameter now contains the location slug
            $locationSlug = $request->input('location');

            // Retrieve the location based on the slug
            $location = Location::where('slug', $locationSlug)->first();

            if ($location) {
                // Use the location's ID in the query
                $query->where('location_id', $location->id);
            }
        }

        if ($request->filled('school')) {
            // Assuming the 'school' parameter now contains the school slug
            $schoolSlug = $request->input('school');

            // Retrieve the school based on the slug
            $school = School::where('slug', $schoolSlug)->first();

            if ($school) {
                // Use the school's ID in the query
                $query->where('school_id', $school->id);
            }
        }

        if ($request->filled('school_area')) {
            // Assuming the 'school_area' parameter now contains the school area slug
            $schoolAreaSlug = $request->input('school_area');

            // Retrieve the school area based on the slug
            $schoolArea = SchoolArea::where('slug', $schoolAreaSlug)->first();

            if ($schoolArea) {
                // Use the school area's ID in the query
                $query->where('school_area_id', $schoolArea->id);
            }
        }

        if ($request->filled('price')) {
            // Extract the price range from the request (e.g., '0-100000')
            $priceRange = explode('-', $request->input('price'));
            $minPrice = (int) $priceRange[0];
            $maxPrice = (int) $priceRange[1];

            // Filter the adverts where combined_price is within the selected range
            $query->whereBetween('combined_price', [$minPrice, $maxPrice]);
        }

        // Additional conditions for active, draft, and expiration date
        $adverts = $query->where('active', true)
            ->where('draft', false)
            ->whereNotNull('lodge_id')
            ->where('slug', $slug)
            ->where('expiration_date', '>', Carbon::now())->paginate(50);

        $locations = Location::all();
        $schools = School::all();
        $school_areas = SchoolArea::all();
        return view('lodge-page', compact('lodge', 'locations', 'schools', 'school_areas', 'adverts'));
    }

    public function servicePage(Request $request, $slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();

        $query = Advert::query();

        // Apply filters if provided in the request
        if ($request->filled('location')) {
            // Assuming the 'location' parameter now contains the location slug
            $locationSlug = $request->input('location');

            // Retrieve the location based on the slug
            $location = Location::where('slug', $locationSlug)->first();

            if ($location) {
                // Use the location's ID in the query
                $query->where('location_id', $location->id);
            }
        }

        if ($request->filled('school')) {
            // Assuming the 'school' parameter now contains the school slug
            $schoolSlug = $request->input('school');

            // Retrieve the school based on the slug
            $school = School::where('slug', $schoolSlug)->first();

            if ($school) {
                // Use the school's ID in the query
                $query->where('school_id', $school->id);
            }
        }

        if ($request->filled('school_area')) {
            // Assuming the 'school_area' parameter now contains the school area slug
            $schoolAreaSlug = $request->input('school_area');

            // Retrieve the school area based on the slug
            $schoolArea = SchoolArea::where('slug', $schoolAreaSlug)->first();

            if ($schoolArea) {
                // Use the school area's ID in the query
                $query->where('school_area_id', $schoolArea->id);
            }
        }

        // Additional conditions for active, draft, and expiration date
        $ads = $query->where('active', true)
            ->where('draft', false)
            ->whereNotNull('service_id')
            ->where('slug', $slug)
            ->where('expiration_date', '>', Carbon::now())->paginate(50);

        $locations = Location::all();
        $schools = School::all();
        $school_areas = SchoolArea::all();

        return view('service-page', compact('service', 'locations', 'schools', 'school_areas', 'ads'));
    }
}
