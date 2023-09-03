<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index(){
        $services = Service::orderBy('created_at', 'DESC')->get();
        return view('admin.service', compact('services'));
    }

    public function add(){
        return view('admin.add-service');
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'slug' => 'required|unique:lodges',
        ]);
        $service = new Service;
        $service->name = $request->name;
        $service->slug = Str::slug($request->slug);
        $service->save();

        return redirect()->back()->with('message', 'Service added successfully');
    }

    public function edit($id){
        $service = Service::findOrFail($id);
        return view('admin.edit-service',compact('service'));
    }
    
    public function update(Request $request, $id){
        $this->validate($request,[
            'name' => 'required',
            'slug' => 'required',
        ]);
        $service = Service::findOrFail($id);
        $service->name = $request->name;
        $service->slug = $request->slug;
        $service->save();

        return redirect()->back()->with('message', 'Service updated successfully');
    }

    public function delete($id){
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->back()->with('message','Service removed successfully');
    }
}
