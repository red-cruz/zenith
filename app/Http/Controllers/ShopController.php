<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShopAddress;
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

    public function create(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request) {
            Gate::authorize('shop-create');

            $validated = $request->validate([
              'name' => ['required', 'string', 'min:3', 'max:255'],
              'description' => ['required', 'string'],
              'pfp' => ['nullable', 'file'],
              'cover' => ['nullable', 'file'],
              'address' => ['required', 'string'],
              'street' => ['required', 'string'],
              'city' => ['required', 'string'],
              'state' => ['required', 'string'],
              'zip_code' => ['required', 'string', 'max:10'],
            ]);

            $shop = new Shop();
            $shop->user_id = Auth::id();
            $shop->name = $validated['name'];
            $shop->description = $validated['description'];
            $shop->saveOrFail();

            $shopAddress = new ShopAddress();
            $shopAddress->shop_id = $shop->id;
            $shopAddress->address = $validated['address'];
            $shopAddress->street = $validated['street'];
            $shopAddress->city = $validated['city'];
            $shopAddress->state = $validated['state'];
            $shopAddress->zip_code = $validated['zip_code'];
            $shopAddress->saveOrFail();

            $shop->shopAddress;

            return response()->json([
              'message' => 'successfully created',
              'shop' => $shop
            ]);
        });
    }

    public function update(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request) {
            $validated = $request->validate([
              'name' => ['required', 'string', 'min:3', 'max:255'],
              'description' => ['required', 'string'],
              'pfp' => ['nullable', 'file'],
              'cover' => ['nullable', 'file'],
              'address' => ['required', 'string'],
              'street' => ['required', 'string'],
              'city' => ['required', 'string'],
              'state' => ['required', 'string'],
              'zip_code' => ['required', 'string', 'max:10'],
            ]);

            $shop = Shop::where('user_id', Auth::id())->firstOrFail();

            Gate::authorize('shop-update', $shop);

            $shop->name = $validated['name'];
            $shop->description = $validated['description'];
            $shop->saveOrFail();

            $shopAddress = $shop->shopAddress;
            $shopAddress->address = $validated['address'];
            $shopAddress->street = $validated['street'];
            $shopAddress->city = $validated['city'];
            $shopAddress->state = $validated['state'];
            $shopAddress->zip_code = $validated['zip_code'];
            $shopAddress->saveOrFail();

            $shop->shopAddress;

            return response()->json([
              'message' => 'Successfully updated',
              'shop' => $shop
            ]);
        });
    }

    public function delete(Shop $shop): JsonResponse
    {
        return Utils::tryCatch(function () use ($shop) {
            Gate::authorize('shop-delete', $shop);

            $shop->deleteOrFail();

            return response()->json([
              'message' => 'Successfully deleted',
              'shop_id' => $shop->id,
            ]);
        });
    }
}
