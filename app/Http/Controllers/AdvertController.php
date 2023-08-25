<?php

namespace App\Http\Controllers;

use App\Models\Lodge;
use App\Models\Advert;
use App\Models\School;
use App\Models\Location;
use App\Models\SchoolArea;
use Ramsey\Uuid\Uuid; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertController extends Controller
{
    public function index()
    {
        $lodges = Lodge::all();
        $locations = Location::all();
        $schools = School::all();
        $school_areas = SchoolArea::all();
        return view('post-ad', compact('locations', 'schools', 'school_areas', 'lodges'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'lodge_id' => 'required|numeric',
            'slug' => 'required|string',
            'location_id' => 'required|numeric',
            'school_id' => 'required|numeric',
            'school_area_id' => 'required|numeric',
            'price' => 'required|numeric',
            'agent_fee' => 'nullable|numeric',
            'negotiable' => 'nullable|boolean',
            'description' => 'required',
            'phone_number' => 'required|string',
            'seller_name' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'other_images' => 'nullable|array|max:4', // Allow up to 4 images
            'other_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'expiration_date' => 'required|date|after:today', // Assuming the product should expire in the future.
            'active' => 'nullable|boolean',
            'draft' => 'nullable|boolean',
        ]);

        // Generate a UUID for the new ad
        $uuid = Uuid::uuid4()->toString();


        // Store the cover image
        $coverImagePath = $request->file('cover_image')->store('public/advert_images');

        // Convert the cover image path to a publicly accessible URL
        $coverImageURL = Storage::url($coverImagePath);

        // Store the other images (if any)
        $otherImages = [];
        if ($request->hasFile('other_images')) {
            foreach ($request->file('other_images') as $file) {
                $otherImagePath = $file->store('public/advert_images');
                $otherImages[] = Storage::url($otherImagePath);
            }
        }

        // Calculate the combined price (ad price + agent fee)
        $combinedPrice = $request->input('price') + $request->input('agent_fee');


        // Save the ad as a draft in the database
        $advert = new Advert([
            'uuid' => $uuid,
            'user_id' => $request->input('user_id'),
            'lodge_id' => $request->input('lodge_id'),
            'slug' => $request->input('slug'),
            'location_id' => $request->input('location_id'),
            'school_id' => $request->input('school_id'),
            'school_area_id' => $request->input('school_area_id'),
            'price' => $request->input('price'),
            'agent_fee' => $request->input('agent_fee'),
            'combined_price' => $combinedPrice,
            'negotiable' => $request->has('negotiable') ? true : false,
            'description' => $request->input('description'),
            'phone_number' => $request->input('phone_number'),
            'seller_name' => $request->input('seller_name'),
            'cover_image' => $coverImageURL,
            'other_images' => $otherImages,
            // 'expiration_date' => 0,
            'active' => false, 
            'draft' => true
        ]);
        $advert->save();

         // Get the ID of the newly created ad
        // $adId = $advert->id;
        $uuid = $advert->uuid;

          // Check if the ad with the given ID exists
    // if (!$advert) {
    //     // Handle the case where the ad does not exist (e.g., redirect to an error page)
    // }

        // Redirect to the payment page with the UUID as a query parameter
        return redirect()->route('payment-page', ['uuid' => $advert->uuid]);
    }

    public function getDraft(){
        $adverts = Advert::where(['user_id' => auth()->user()->id, 'draft' => true])->get();
        return view('draft',compact('adverts'));
    }

    public function editDraft($uuid){
        $advert = Advert::where('uuid',$uuid)->firstOrFail();
        return view('edit-draft',compact('advert'));
    }

    public function updateDraft(Request $request,$uuid){
        $request->validate([
            'price' => 'required|numeric',
            'agent_fee' => 'nullable|numeric',
            'negotiable' => 'nullable|boolean',
            'phone_number' => 'required|string',
        ]);

        $negotiable = $request->has('negotiable') ? true : false;
        $combinedPrice = $request->price + $request->agent_fee;

        $advert = Advert::where('uuid',$uuid)->firstOrFail();
        $advert->price = $request->price;
        $advert->agent_fee = $request->agent_fee;
        $advert->combined_price = $combinedPrice;
        $advert->negotiable = $negotiable;
        $advert->phone_number = $request->phone_number;
        $advert->save();

        return redirect()->route('payment-page', ['uuid' => $advert->uuid]);

    }

    public function deleteDraft($uuid){
        $advert = Advert::where('uuid',$uuid)->firstOrFail();
        $advert->delete();

        return redirect()->back();
    }

    public function overView(){
        $adverts = Advert::all();
        return view('admin.over-view',$adverts);
    }

    // displays all ads in the admin side
    public function allAds(Request $request){
        $query = $request->input('query');
    
        $adverts = Advert::where('draft', false)
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
            })->paginate(10);

        return view('admin.all-ads',compact('adverts','query'));
    }

    public function viewAd($uuid){
        $advert = Advert::where('uuid',$uuid)->firstOrFail();
        return view('admin.view-ad',compact('advert'));
    }

    public function deleteAd($uuid){
        $advert = Advert::where('uuid',$uuid)->firstOrFail();
        $advert->delete();

        return redirect()->back()->with('message','Ad deleted successfully');
    }

    public function myAds(Request $request){
        $query = $request->input('query');

        $adverts = Advert::where('user_id',auth()->user()->id)
        ->where('draft', false)
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
        })->get();
        return view('my-ads',compact('adverts','query'));
    }

    public function viewMyAd($uuid){
        $advert = Advert::where('uuid',$uuid)->firstOrFail();
        return view('view-my-ad',compact('advert'));
    }

    public function deleteMyAd($uuid){
        $advert = Advert::where('uuid',$uuid)->firstOrFail();
        $advert->delete();

        return redirect()->back()->with('message','Ad deleted successfully');
    }

    public function Relist($uuid){
        $advert = Advert::where('uuid',$uuid)->firstOrFail();
        return view('relist',compact('advert'));
    }

    public function updateRelist(Request $request,$uuid){
        $request->validate([
            'price' => 'required|numeric',
            'agent_fee' => 'nullable|numeric',
            'negotiable' => 'nullable|boolean',
            'phone_number' => 'required|string',
        ]);

        $negotiable = $request->has('negotiable') ? true : false;
        $combinedPrice = $request->price + $request->agent_fee;

        $advert = Advert::where('uuid',$uuid)->firstOrFail();
        $advert->price = $request->price;
        $advert->agent_fee = $request->agent_fee;
        $advert->combined_price = $combinedPrice;
        $advert->negotiable = $negotiable;
        $advert->phone_number = $request->phone_number;
        $advert->save();

        return redirect()->route('payment-page', ['uuid' => $advert->uuid]);

    }

}
