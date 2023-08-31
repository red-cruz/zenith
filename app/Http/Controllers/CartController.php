<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getCartProducts(): JsonResponse
    {
        return response()->json([
          'cart' => Cart::where('user_id', 1)->get()
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        return TryCatch::input(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'product_id' => ['required', 'integer', 'exists:products,id'],
              'quantity' => ['required', 'integer'],
            ]);

            $cart = new Cart();
            $cart->user_id = 1;
            $cart->product_id = $validated['product_id'];
            $cart->quantity = $validated['quantity'];
            $cart->save();

            return response()->json([
              'message' => 'Successfully added',
              'cart' => $cart
            ]);
        });
    }
}
