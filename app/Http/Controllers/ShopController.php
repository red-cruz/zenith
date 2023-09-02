<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ShopController extends Controller
{
    public function index(Shop $shop)
    {
        $shop->owner;
        $shop->products;
        return response()->json([
          'shop' => $shop
        ]);
    }

    public function create(): JsonResponse
    {
        return Utils::tryCatch(function () {
            Gate::authorize('shop-create');

            $shop = new Shop([
              'user_id' => Auth::id()
            ]);
            $shop->save();

            return response()->json();
        });
    }

    public function update(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request) {
            $validated = $request->validate([
              'shop_id' => ['required', 'integer', 'exists:shops,id'],
              'name' => ['required', 'string', 'min:3', 'max:255'],
              'description' => ['required', 'string'],
              'pfp' => ['nullable', 'file'],
              'cover' => ['nullable', 'file']
            ]);

            $shop = Shop::find($validated['shop_id']);

            Gate::authorize('shop-update', $shop);

            $shop->name = $validated['name'];
            $shop->description = $validated['description'];

            $shop->save();

            return response()->json([
              'message' => 'Successfully updated',
              'shop' => $validated
            ]);
        });
    }

    public function delete(Shop $shop): JsonResponse
    {
        return Utils::tryCatch(function () use ($shop) {
            Gate::authorize('shop-delete', $shop);

            $shop->delete();

            return response()->json([
              'message' => 'Successfully deleted',
              'shop_id' => $shop->id,
            ]);
        });
    }
}
