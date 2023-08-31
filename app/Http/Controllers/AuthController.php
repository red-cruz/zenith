<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InsertiaResponse;

class AuthController extends Controller
{
    public function index(): InsertiaResponse
    {
        return Inertia::render('Auth/login', ['testdata' => 'd']);
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
              'email' => ['required', 'email'],
              'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return response()->json([]);
            }
            return response()->json([
              'title' => 'Wrong email or password',
            ], 401);

        } catch(\Illuminate\Validation\ValidationException $err) {
            return response()->json([
              'title' => 'Invalid input',
              'validation_errors' => $err->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
              'message' => 'Error: '.$th->getMessage()
            ], 500);
        }
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
