<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'name' => ['required', 'string'],
              'gender' => ['required', Rule::in(['male', 'female', 'secret'])],
              'phone_number' => [ 'required', 'string'],
              'birthdate' => ['required', 'date'],
              'email' => ['required', 'email', 'unique:users'],
              'password' => ['required', 'string', 'between:6,20']
            ]);

            $user = new User();
            $user->name = $validated['name'];
            $user->gender = $validated['gender'];
            $user->phone_number = $validated['phone_number'];
            $user->birthdate = $validated['birthdate'];
            $user->email = $validated['email'];
            $user->plain_pass = $validated['password'];
            $user->password = password_hash($validated['password'], PASSWORD_BCRYPT);
            $user->address_id = 1;

            $user->save();

            return response()->json([
              'message' => 'succesfully createad an account',
              'user' => $user
            ]);
        });
    }

    public function read(User $user): JsonResponse
    {
        return Utils::tryCatch(function () use ($user): JsonResponse {
            $user->userAddresses;
            $user->cart;
            $user->shop->shopAddress;
            return response()->json([
              'user' => $user
            ]);
        });
    }

    public function update(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'name' => ['required', 'string'],
              'gender' => ['required', Rule::in(['male', 'female', 'secret'])],
              'phone_number' => [ 'required', 'string'],
              'birthdate' => ['required', 'date'],
              'email' => ['required', 'email', 'unique:users'],
              'password' => ['required', 'string', 'between:6,20']
            ]);

            $user = User::find(Auth::id());
            $user->name = $validated['name'];
            $user->gender = $validated['gender'];
            $user->phone_number = $validated['phone_number'];
            $user->birthdate = $validated['birthdate'];
            $user->email = $validated['email'];
            $user->plain_pass = $validated['password'];
            $user->password = password_hash($validated['password'], PASSWORD_BCRYPT);
            $user->address_id = 1;

            $user->save();

            return response()->json([
              'message' => 'succesfully updated',
              'user' => $user
            ]);
        });
    }

    public function delete(User $user): JsonResponse
    {
        return Utils::tryCatch(function () use ($user) {
            Gate::authorize('user-delete', $user);

            $user->delete();

            return response()->json([
              'message' => 'Successfully deleted',
              'user' => $user,
            ]);
        });
    }
}
