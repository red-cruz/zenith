<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

            return response()->json(
                [
                  'message' => 'succesfully createad an account',
                  'user' => $user
                ]
            );
        });
    }
}
