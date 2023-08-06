<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function index(){
        $locations = Location::orderBy('created_at', 'DESC')->get();
        return view('admin.location', compact('locations'));
    }

    public function add(){
        return view('admin.add-location');
    }

    public function store(Request $request){
        $this->validate($request,[
            'state' => 'required',
            'slug' => 'required|unique:locations',
        ]);
        $location = new Location;
        $location->state = $request->state;
        $location->slug = Str::slug($request->slug);
        $location->save();

        return redirect()->back()->with('message', 'Location added successfully');
    }

    public function edit($id){
        $location = Location::where('id',$id)->firstOrFail();
        return view('admin.edit-location',compact('location'));
    }
    
    public function update(Request $request, $id){
        $this->validate($request,[
            'state' => 'required',
            'slug' => 'required',
        ]);
        $location = Location::findOrFail($id);
        $location->state = $request->state;
        $location->slug = $request->slug;
        $location->save();

        return redirect()->back()->with('message', 'Location updated successfully');
    }

    public function delete($id){
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->back()->with('message','Location removed successfully');
    }
}
