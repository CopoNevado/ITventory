<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with(['category', 'location'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'sku' => 'required|string|unique:products',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
        ]);

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return $product->load(['category', 'location']);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|string',
            'sku' => 'sometimes|string|unique:products,sku,' . $product->id,
            'quantity' => 'sometimes|integer',
            'category_id' => 'sometimes|exists:categories,id',
            'location_id' => 'sometimes|exists:locations,id',
        ]);

        $product->update($request->all());
        return response()->json($product, 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
