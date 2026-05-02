<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::query();

    // 🔍 search
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // 🏷️ filter category
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    return $query->paginate($request->per_page ?? 10);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = $path;
    }

    $product = Product::create($validated);

    return response()->json($product);
}

public function show($id)
{
    return Product::with('category')->findOrFail($id);
}

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $validated = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'price' => 'sometimes|required|numeric',
        'stock' => 'sometimes|required|integer',
        'category_id' => 'sometimes|required|exists:categories,id',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = $path;
    }

    $product->update($validated);

    return response()->json([
        'message' => 'Product updated ✅',
        'product' => $product
    ]);
}

public function destroy($id)
{
    Product::destroy($id);
    return response()->json(['message' => 'deleted']);
}
}
