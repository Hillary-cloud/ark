<?php

namespace App\Http\Controllers\Admin;

use App\Models\School;
use App\Models\Location;
use App\Models\SchoolArea;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolAreaController extends Controller
{
    public function index(){
        $school_areas = SchoolArea::with('school.location')->get();
        return view('admin.school-area', compact('school_areas'));
    }

    public function add(){
        $schools = School::all();
        return view('admin.add-school-area', compact('schools'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'school_id' => 'required',
            'name' => 'required|unique:school_areas',
            'slug' => 'required',
        ]);
        $school_area = new SchoolArea;
        $school_area->school_id = $request->school_id;
        $school_area->name = $request->name;
        $school_area->slug = Str::slug($request->slug);
        $school_area->save();

        return redirect()->back()->with('message','School area added successfully');

    }

    public function edit($id){
        $school_area = SchoolArea::with('school.location')->find($id);
        $schools = School::all();
        $locations = Location::all();
        return view('admin.edit-school-area',compact('school_area','schools','locations'));
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'name' => 'required',
            'slug' => 'required',
        ]);
        $school_area = SchoolArea::with('school.location')->find($id);
        $school_area->name = $request->name;
        $school_area->slug = Str::slug($request->slug);
        $school_area->update();

        return redirect()->back()->with('message','School area successfully updated');
    }

    public function delete($id){
        $school_area = SchoolArea::findOrFail($id);
        $school_area->delete();

        return redirect()->back()->with('message',' School area deleted successfully');
    }

    public function getSchoolAreas($schoolId){
        $school_areas = SchoolArea::where('school_id', $schoolId)->get();
        return $school_areas;
    }
}
