<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // 📦 Get wishlist
    public function index()
    {
        return Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->get();
    }

    // ➕ Add
    public function store(Request $request)
    {
        $exists = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if (!$exists) {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id
            ]);
        }

        return response()->json(['message' => 'Added']);
    }

    // ❌ Delete
    public function destroy($id)
    {
        Wishlist::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}