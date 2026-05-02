<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 📦 Get cart
    public function index()
    {
        return Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();
    }

    // ➕ Add to cart
    public function store(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            $cart->quantity += 1;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => 1
            ]);
        }

        return response()->json(['message' => 'Added']);
    }

    // 🔄 Update quantity
    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json(['message' => 'Updated']);
    }

    // ❌ Delete item
    public function destroy($id)
    {
        Cart::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}