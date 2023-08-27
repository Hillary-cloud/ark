<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lodge;
use App\Models\Advert;
use App\Models\School;
use App\Models\Location;
use Jorenvh\Share\ShareFacade as Share;
use App\Models\SchoolArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request as FacadesRequest;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $adverts = Advert::where('active', true)
            ->where('draft', false)
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
            })->paginate(6);

        return view('index', compact('adverts','query'));
    }

    public function ViewMoreLodges(Request $request){
        $query = Advert::query();

        // Apply filters if provided in the request
        if ($request->filled('location')) {
            $query->where('location_id', $request->input('location'));
        }

        if ($request->filled('school')) {
            $query->where('school_id', $request->input('school'));
        }

        if ($request->filled('school_area')) {
            $query->where('school_area_id', $request->input('school_area'));
        }

        if ($request->filled('lodge')) {
            $query->where('lodge_id', $request->input('lodge'));
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
        $query->where('active', true)
            ->where('draft', false)
            ->where('expiration_date', '>', Carbon::now());

        // Get filtered results
        $adverts = $query->paginate(4);

        $locations = Location::all();
        $schools = School::all();
        $school_areas = SchoolArea::all();
        $lodges = Lodge::all();

        return view('more-lodges', compact('adverts', 'locations', 'schools', 'school_areas', 'lodges'));
    }

    public function adDetail($uuid)
    {
        $advert = Advert::where('uuid', $uuid)->firstOrFail();

        // Check if the ad has been viewed in the current session
        // $viewedAds = session()->get('viewed_ads', []);
        // if (!in_array($uuid, $viewedAds)) {
        //     $advert->increment('view_count'); // Increment view count
        //     $viewedAds[] = $uuid;
        //     session()->put('viewed_ads', $viewedAds);
        // }
        // Get the user's IP address
        $ip = FacadesRequest::ip();

        // Check if the ad has been viewed by this IP address
        $viewedAds = Cache::remember('viewed_ads:' . $ip, now()->addHours(24), function () use ($ip) {
            return [];
        });

        if (!in_array($uuid, $viewedAds)) {
            $advert->increment('view_count'); // Increment IP view count
            $viewedAds[] = $uuid;
            Cache::put('viewed_ads:' . $ip, $viewedAds, now()->addHours(24));
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

        return view('detail', compact('advert', 'adverts','shareButton'));
    }

}
