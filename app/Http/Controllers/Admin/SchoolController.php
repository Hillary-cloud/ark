<?php

namespace App\Http\Controllers\Admin;

use App\Models\School;
use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolController extends Controller
{
    public function index(){
        $schools = School::orderBy('created_at','DESC')->get();
        return view('admin.school',compact('schools'));
    }

    public function add(){
        $locations = Location::all();
        return view('admin.add-school',compact('locations'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'location_id' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:schools',
        ]);
        $school = new School;
        $school->location_id = $request->location_id; 
        $school->name = $request->name;
        $school->slug = Str::slug($request->slug);
        $school->save();

        return redirect()->back()->with('message','School added successfully');
    }

    public function edit($id){
        $school = School::find($id);
        $locations = Location::all();
        
        return view('admin.edit-school',compact('school','locations'));
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'location_id' => 'required',
            'name' => 'required',
            'slug' => 'required',
        ]);
        $school = School::find($id);
        $school->location_id = $request->location_id; 
        $school->name = $request->name;
        $school->slug = Str::slug($request->slug);
        $school->update();
        
        return redirect()->back()->with('message','School successfully updated');
    }

    public function delete($id){
        $school = School::findOrFail($id);
        $school->delete();

        return redirect()->back()->with('message','School removed successfully');
    }

    public function getSchools($locationId){
        $schools = School::where('location_id', $locationId)->get();
        return $schools;
    }
}
