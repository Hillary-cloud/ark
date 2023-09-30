<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Lodge;
use Ramsey\Uuid\Uuid;
use App\Models\Advert;
use App\Models\School;
use App\Models\Service;
use App\Models\Location;
use App\Models\SchoolArea;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreLodgeRequest;
use App\Http\Requests\StoreServiceRequest;
use App\Notifications\AdCreatedNotification;

class AdvertController extends Controller
{
    public function lodgeIndex()
    {
        $lodges = Lodge::all();
        $locations = Location::all();
        $schools = School::all();
        $school_areas = SchoolArea::all();
        return view('post-lodge', compact('locations', 'schools', 'school_areas', 'lodges'));
    }

    public function serviceIndex()
    {
        $services = Service::all();
        $locations = Location::all();
        $schools = School::all();
        $school_areas = SchoolArea::all();
        return view('post-service', compact('locations', 'schools', 'school_areas', 'services'));
    }

    // store method stores lodge
    public function storeLodge(StoreLodgeRequest $request)
    {
        //    the validation rules are in app/http/request/StoreLodgeRequest

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

        // Redirect to the payment page with the UUID as a query parameter. This page post ad with payment
        // return redirect()->route('payment-page', ['uuid' => $advert->uuid]);

        // Redirect to the post ad page with the UUID as a query parameter. this page posts ad without payment
        return redirect()->route('post-ad-page', ['uuid' => $advert->uuid]);
    }

    // storeService method stores service
    public function storeService(StoreServiceRequest $request)
    {
        //    the validation rules are in app/http/request/StoreServiceRequest

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

        $on_contact = $request->has('on_contact') ? true : false;

        // Calculate the combined price (service price)
        $combinedPrice = $request->input('price');

        // Save the ad as a draft in the database
        $advert = new Advert([
            'uuid' => $uuid,
            'user_id' => $request->input('user_id'),
            'service_id' => $request->input('service_id'),
            'slug' => $request->input('slug'),
            'location_id' => $request->input('location_id'),
            'school_id' => $request->input('school_id'),
            'school_area_id' => $request->input('school_area_id'),
            'price' => $request->input('price'),
            'combined_price' => $combinedPrice,
            'on_contact' => $on_contact,
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

        // Redirect to the payment page with the UUID as a query parameter. This page post ad with payment
        // return redirect()->route('payment-page', ['uuid' => $advert->uuid]);

        // Redirect to the post ad page with the UUID as a query parameter. this page posts ad without payment
        return redirect()->route('post-ad-page', compact('uuid'));
    }

    // the two functions below are used when we want users to be able to post ad for free
    public function showPostAdPage($uuid)
    {
        $advert = Advert::where('uuid', $uuid)->firstOrFail();
        // Pass the advert data to the post ad page view
        return view('post-ad-page', compact('advert'));
    }


    public function post($uuid)
    {
        try {

            $expirationDate = Carbon::now()->addDays(30);

            $advert = Advert::where('uuid', $uuid)->firstOrFail();
            $advert->update(['expiration_date' => $expirationDate, 'list_date' => now(), 'draft' => false, 'active' => true]);
            // Dispatch the AdCreatedNotification
            $user = Auth::user(); // Get the user who created the ad
            $advert->user->notify(new AdCreatedNotification($advert));

            return redirect()->route('success-two', compact('uuid', 'advert',)); // Redirect to a success page
        } catch (\Exception $e) {
            // Handle the exception and return an error response
            $errorMessage = 'Sorry, ad listing failed. Please try again later.';
            return view('post-ad-page', compact('errorMessage', 'advert', 'uuid'));
        }
    }

    public function showNotifications()
    {
        $user = Auth::user(); // Get the authenticated user
        $notifications = $user->notifications; // Retrieve the user's notifications

        return view('notification', compact('notifications'));
    }

    public function markNotificationAsRead(Request $request, $notification)
    {
        $notification = $request->user()->notifications()->findOrFail($notification);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }


    public function getDraft()
    {
        $adverts = Advert::where(['user_id' => auth()->user()->id, 'draft' => true])->get();
        return view('draft', compact('adverts'));
    }

    public function editDraft($uuid)
    {
        $advert = Advert::where('uuid', $uuid)->firstOrFail();
        return view('edit-draft', compact('advert'));
    }

    public function updateLodgeDraft(Request $request, $uuid)
    {
        $request->validate([
            'price' => 'required|numeric',
            'agent_fee' => 'nullable|numeric',
            'negotiable' => 'nullable|boolean',
            'phone_number' => 'required|string',
        ]);

        $negotiable = $request->has('negotiable') ? true : false;
        $combinedPrice = $request->price + $request->agent_fee;

        $advert = Advert::where('uuid', $uuid)->firstOrFail();
        $advert->price = $request->price;
        $advert->agent_fee = $request->agent_fee;
        $advert->combined_price = $combinedPrice;
        $advert->negotiable = $negotiable;
        $advert->phone_number = $request->phone_number;
        $advert->save();

        // Redirect to the payment page with the UUID as a query parameter. This page post ad with payment
        // return redirect()->route('payment-page', ['uuid' => $advert->uuid]);

        // Redirect to the post ad page with the UUID as a query parameter. this page posts ad without payment
        return redirect()->route('post-ad-page', ['uuid' => $advert->uuid]);
    }

    public function updateServiceDraft(Request $request, $uuid)
    {
        $request->validate([
            'price' => 'required_without:on_contact|nullable|numeric',
            'on_contact' => 'required_without:price|boolean',
            'phone_number' => 'required|string',
        ]);

        $on_contact = $request->has('on_contact') ? true : false;
        $combinedPrice = $request->price;

        $advert = Advert::where('uuid', $uuid)->firstOrFail();
        $advert->price = $request->price;
        $advert->combined_price = $combinedPrice;
        $advert->on_contact = $on_contact;
        $advert->phone_number = $request->phone_number;
        $advert->save();

        // Redirect to the payment page with the UUID as a query parameter. This page post ad with payment
        // return redirect()->route('payment-page', ['uuid' => $advert->uuid]);

        // Redirect to the post ad page with the UUID as a query parameter. this page posts ad without payment
        return redirect()->route('post-ad-page', ['uuid' => $advert->uuid]);
    }

    public function deleteDraft($uuid)
    {
        $advert = Advert::where('uuid', $uuid)->firstOrFail();
        $advert->delete();

        return redirect()->back();
    }

    public function overView()
    {
        $adverts = Advert::all();
        return view('admin.over-view', $adverts);
    }

    // displays all ads in the admin side
    public function allAds(Request $request)
    {
        $query = $request->input('query');

        $adverts = Advert::where('draft', false)
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder
                    ->leftJoin('lodges', 'lodges.id', '=', 'adverts.lodge_id')
                    ->leftJoin('services', 'services.id', '=', 'adverts.service_id')
                    ->join('locations', 'locations.id', '=', 'adverts.location_id')
                    ->join('schools', 'schools.id', '=', 'adverts.school_id')
                    ->join('school_areas', 'school_areas.id', '=', 'adverts.school_area_id')
                    ->where(function ($innerQueryBuilder) use ($query) {
                        $innerQueryBuilder
                            ->where('adverts.description', 'like', '%' . $query . '%')
                            ->orWhere('schools.name', 'like', '%' . $query . '%')
                            ->orWhere('school_areas.name', 'like', '%' . $query . '%')
                            ->orWhere('locations.state', 'like', '%' . $query . '%')
                            ->orWhere('lodges.name', 'like', '%' . $query . '%')
                            ->orWhere('services.name', 'like', '%' . $query . '%');
                    });
            })->paginate(10);

        return view('admin.all-ads', compact('adverts', 'query'));
    }

    public function viewAd($uuid)
    {
        $advert = Advert::where('uuid', $uuid)->firstOrFail();
        return view('admin.view-ad', compact('advert'));
    }

    public function deleteAd($uuid)
    {
        $advert = Advert::where('uuid', $uuid)->firstOrFail();
        $advert->delete();

        return redirect()->back()->with('message', 'Ad deleted successfully');
    }

    public function myAds(Request $request)
    {
        $query = $request->input('query');

        $adverts = Advert::where('user_id', auth()->user()->id)
            ->where('draft', false)
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder
                    ->leftJoin('lodges', 'lodges.id', '=', 'adverts.lodge_id')
                    ->leftJoin('services', 'services.id', '=', 'adverts.service_id')
                    ->join('locations', 'locations.id', '=', 'adverts.location_id')
                    ->join('schools', 'schools.id', '=', 'adverts.school_id')
                    ->join('school_areas', 'school_areas.id', '=', 'adverts.school_area_id')
                    ->where(function ($innerQueryBuilder) use ($query) {
                        $innerQueryBuilder->where('adverts.description', 'like', '%' . $query . '%')
                            ->orWhere('schools.name', 'like', '%' . $query . '%')
                            ->orWhere('school_areas.name', 'like', '%' . $query . '%')
                            ->orWhere('lodges.name', 'like', '%' . $query . '%')
                            ->orWhere('services.name', 'like', '%' . $query . '%')
                            ->orWhere('locations.state', 'like', '%' . $query . '%');
                    });
            })->get();
        return view('my-ads', compact('adverts', 'query'));
    }

    public function viewMyAd($uuid)
    {
        $advert = Advert::where('uuid', $uuid)->firstOrFail();
        return view('view-my-ad', compact('advert'));
    }

    public function deleteMyAd($uuid)
    {
        $advert = Advert::where('uuid', $uuid)->firstOrFail();
        $advert->delete();

        return redirect()->back()->with('message', 'Ad deleted successfully');
    }

    public function Relist($uuid)
    {
        $advert = Advert::where('uuid', $uuid)->firstOrFail();
        return view('relist', compact('advert'));
    }

    public function updateRelistLodge(Request $request, $uuid)
    {
        $request->validate([
            'price' => 'required|numeric',
            'agent_fee' => 'nullable|numeric',
            'negotiable' => 'nullable|boolean',
            'phone_number' => 'required|string',
        ]);


        $negotiable = $request->has('negotiable') ? true : false;
        $combinedPrice = $request->price + $request->agent_fee;

        $advert = Advert::where('uuid', $uuid)->firstOrFail();
        $advert->price = $request->price;
        $advert->agent_fee = $request->agent_fee;
        $advert->combined_price = $combinedPrice;
        $advert->negotiable = $negotiable;
        $advert->phone_number = $request->phone_number;
        $advert->save();

        return redirect()->route('payment-page', ['uuid' => $advert->uuid]);
    }

    public function updateRelistService(Request $request, $uuid)
    {
        $request->validate([
            'price' => 'required_if:on_contact,false|nullable|numeric',
            'on_contact' => 'required_if:price,null|boolean',
            'phone_number' => 'required|string',
        ]);

        $on_contact = $request->has('on_contact') ? true : false;
        $combinedPrice = $request->price;

        $advert = Advert::where('uuid', $uuid)->firstOrFail();
        $advert->price = $request->price;
        $advert->combined_price = $combinedPrice;
        $advert->on_contact = $on_contact;
        $advert->phone_number = $request->phone_number;
        $advert->save();

        return redirect()->route('payment-page', ['uuid' => $advert->uuid]);
    }

    public function deleteNotification($id)
    {
        $notification = Notification::where('id', $id)->firstOrFail();
        $notification->delete();

        return redirect()->back();
    }
}
