<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lodge;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LodgeController extends Controller
{
    public function index()
    {
        $lodges = Lodge::orderBy('created_at', 'DESC')->get();
        return view('admin.lodge', compact('lodges'));
    }

    public function add()
    {
        return view('admin.add-lodge');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:lodges',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);
        // Store the cover image
        $coverImagePath = $request->file('cover_image')->store('public/advert_images');

        // Convert the cover image path to a publicly accessible URL
        $coverImageURL = Storage::url($coverImagePath);

        $lodge = new Lodge;
        $lodge->name = $request->name;
        $lodge->slug = Str::slug($request->slug);
        $lodge->cover_image = $coverImageURL;
        $lodge->save();

        return redirect()->back()->with('message', 'Lodge added successfully');
    }

    public function edit($id)
    {
        $lodge = Lodge::findOrFail($id);
        return view('admin.edit-lodge', compact('lodge'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        // Store the cover image
        $coverImagePath = $request->file('cover_image')->store('public/advert_images');

        // Convert the cover image path to a publicly accessible URL
        $coverImageURL = Storage::url($coverImagePath);

        $lodge = Lodge::findOrFail($id);
        $lodge->name = $request->name;
        $lodge->slug = $request->slug;
        $lodge->cover_image = $coverImageURL;
        $lodge->save();

        return redirect()->back()->with('message', 'Lodge updated successfully');
    }

    public function delete($id)
    {
        $lodge = Lodge::findOrFail($id);
        $lodge->delete();

        return redirect()->back()->with('message', 'Lodge removed successfully');
    }
}
