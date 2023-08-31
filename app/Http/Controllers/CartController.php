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

    public function upsert(Request $request): JsonResponse
    {
        return TryCatch::input(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'product_id' => ['required', 'integer', 'exists:products,id'],
              'quantity' => ['required', 'integer'],
            ]);

            $cart = Cart::updateOrCreate(
                [
                  'user_id' => 1,
                  'product_id' => $validated['product_id']
                ],
                [
                  'user_id' => 1,
                  'quantity' => $validated['quantity']
                ]
            );

            return response()->json([
              'message' => 'Successfully added',
              'cart' => $cart
            ]);
        });
    }

    public function delete(Cart $cart): JsonResponse
    {
        $cart->delete();
        return response()->json([
          'cart_id' => $cart->id
        ]);
    }
}
