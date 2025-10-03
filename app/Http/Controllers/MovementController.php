<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movement;
use App\Models\Product;

class MovementController extends Controller
{
    public function index()
    {
        return Movement::with(['product', 'user'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:entrada,salida',
            'quantity' => 'required|integer|min:1',
        ]);

        $movement = Movement::create($request->all());

        // Actualizar cantidad del producto
        $product = Product::find($request->product_id);
        if ($request->type === 'entrada') {
            $product->quantity += $request->quantity;
        } else {
            $product->quantity -= $request->quantity;
        }
        $product->save();

        return response()->json($movement, 201);
    }

    public function show(Movement $movement)
    {
        return $movement->load(['product', 'user']);
    }

    public function destroy(Movement $movement)
    {
        $movement->delete();
        return response()->json(null, 204);
    }
}
