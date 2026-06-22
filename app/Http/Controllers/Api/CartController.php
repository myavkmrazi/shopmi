<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Cart\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        Cart::sanitize();

        return response()->json([
            'items' => Cart::getCart(),
            'total' => Cart::getTotalPrice(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:'.Cart::MAX_QUANTITY,
        ]);

        $result = Cart::add2Cart(
            (int) $validated['product_id'],
            (int) ($validated['quantity'] ?? 1)
        );

        if (! $result['success']) {
            return response()->json(['message' => $result['message']], 422);
        }

        return response()->json([
            'message' => $result['message'],
            'items' => Cart::getCart(),
            'total' => Cart::getTotalPrice(),
        ]);
    }

    public function destroy(string $id)
    {
        Cart::removeProductFromCart((int) $id);

        return response()->json([
            'message' => 'Removed from cart',
            'items' => Cart::getCart(),
            'total' => Cart::getTotalPrice(),
        ]);
    }
}
