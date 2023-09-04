<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserAddressController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'address' => ['required', 'string'],
              'street' => ['required', 'string'],
              'city' => ['required', 'string'],
              'state' => ['required', 'string'],
              'zip_code' => ['required', 'string', 'max:10'],
              'phone_number' => ['required', 'string', 'max:22'],
            ]);

            $address = new UserAddress();
            $address->user_id = Auth::id();
            $address->address = $validated['address'];
            $address->street = $validated['street'];
            $address->city = $validated['city'];
            $address->state = $validated['state'];
            $address->zip_code = $validated['zip_code'];
            $address->phone_number = $validated['phone_number'];
            $address->saveOrFail();

            return response()->json([
              'message' => 'succesfully added an address',
              'address' => $address
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

            $userAddress = UserAddress::findOrFail($validated['id']);

            Gate::authorize('user-address-update', $userAddress);

            $userAddress->address = $validated['address'];
            $userAddress->street = $validated['street'];
            $userAddress->city = $validated['city'];
            $userAddress->state = $validated['state'];
            $userAddress->zip_code = $validated['zip_code'];
            $userAddress->phone_number = $validated['phone_number'];
            $userAddress->saveOrFail();

            return response()->json([
              'message' => 'Successfully updated',
              'user' => $userAddress,
            ]);
        });
    }
    public function delete(UserAddress $userAddress): JsonResponse
    {
        return Utils::tryCatch(function () use ($userAddress): JsonResponse {
            Gate::authorize('user-address-delete', $userAddress);

            $userAddress->deleteOrFail();

            return response()->json([
              'message' => 'Successfully deleted',
              'user' => $userAddress,
            ]);
        });
    }
}
