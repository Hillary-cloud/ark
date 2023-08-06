<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function toggleBookmark(Request $request)
    {
        $user = Auth::user();
        $advertId = $request->input('advert_id');

        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('advert_id', $advertId)
            ->first();

        if ($bookmark) {
            $bookmark->delete(); // Unbookmark
            return response()->json(['message' => 'Ad unbookmarked']);
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'advert_id' => $advertId
            ]);
            return response()->json(['message' => 'Ad bookmarked']);
        }
    }

    public function bookmarks()
{
    $user = Auth::user();
    $bookmarkedAds = $user->bookmarks;

    return view('bookmarks', compact('bookmarkedAds'));
}

}
