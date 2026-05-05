<?php

namespace App\Http\Controllers;

use App\Models\wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // 📦 Get wishlist
    public function index()
    {
        return wishlist::with('product')
            ->where('user_id', auth()->id())
            ->get();
    }

    // ➕ Add
    public function store(Request $request)
    {
        $exists = wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if (!$exists) {
            wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id
            ]);
        }

        return response()->json(['message' => 'Added']);
    }

    // ❌ Delete
    public function destroy($id)
    {
        wishlist::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
