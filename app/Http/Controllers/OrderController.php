<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Notifications\OrderPlaced;

class OrderController extends Controller
{
    // 📦 GET Orders
    public function index()
    {
        return Order::with('user')->latest()->get();
    }

    // 🧾 STORE (checkout)
    public function store(Request $request)
    {
        return $this->checkout();
    }

    // 💳 Checkout
    public function checkout()
    {
        $cart = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cart->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        // 🔥 حساب total بطريقة نظيفة
        $total = $cart->sum(function ($item) {
            return (float)$item->product->price * (int)$item->quantity;
        });

        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $total,
            'status' => 'pending'
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        auth()->user()->notify(new OrderPlaced($order));

        Cart::where('user_id', auth()->id())->delete();

        return response()->json($order->load('items.product'));
    }

    // 💳 Stripe (اختياري)
    public function pay()
{
    Stripe::setApiKey(env('STRIPE_SECRET'));

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => ['name' => 'Order Payment'],
                'unit_amount' => 1000,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://127.0.0.1:8000/success',
        'cancel_url' => 'http://127.0.0.1:8000/cancel',
    ]);

    return response()->json(['url' => $session->url]);
}
public function destroy($id)
{
    $order = Order::findOrFail($id);
    $order->delete();

    return response()->json(['message' => 'Order deleted']);
}
public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);

    $request->validate([
        'status' => 'required|in:pending,paid,shipped'
    ]);

    $order->status = $request->status;
    $order->save();

    return response()->json(['message' => 'Status updated']);
}
}