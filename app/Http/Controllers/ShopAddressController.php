<?php

namespace App\Http\Controllers;

use App\Models\ShopAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ShopAddressController extends Controller
{
    public function read(ShopAddress $ShopAddress): JsonResponse
    {
        return Utils::tryCatch(function () use ($ShopAddress): JsonResponse {
            Gate::authorize('user-address-read', $ShopAddress);
            return response()->json([
              'address' => $ShopAddress
            ]);
        });
    }

    public function update(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'id' => ['required', 'integer', 'exists:user_addresses'],
              'address' => ['required', 'string'],
              'street' => ['required', 'string'],
              'city' => ['required', 'string'],
              'state' => ['required', 'string'],
              'zip_code' => ['required', 'string', 'max:10'],
              'phone_number' => ['required', 'string', 'max:22'],
            ]);

            $ShopAddress = ShopAddress::findOrFail($validated['id']);

            Gate::authorize('user-address-update', $ShopAddress);

            $ShopAddress->address = $validated['address'];
            $ShopAddress->street = $validated['street'];
            $ShopAddress->city = $validated['city'];
            $ShopAddress->state = $validated['state'];
            $ShopAddress->zip_code = $validated['zip_code'];
            $ShopAddress->phone_number = $validated['phone_number'];
            $ShopAddress->saveOrFail();

            return response()->json([
              'message' => 'Successfully updated',
              'user' => $ShopAddress,
            ]);
        });
    }
    public function delete(ShopAddress $ShopAddress): JsonResponse
    {
        return Utils::tryCatch(function () use ($ShopAddress): JsonResponse {
            Gate::authorize('user-address-delete', $ShopAddress);

            $ShopAddress->deleteOrFail();

            return response()->json([
              'message' => 'Successfully deleted',
              'user' => $ShopAddress,
            ]);
        });
    }
}
