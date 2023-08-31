<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TryCatch extends Controller
{
    public static function input(callable $callback): JsonResponse
    {
        try {
            return $callback();
        } catch(\Illuminate\Validation\ValidationException $err) {
            return response()->json([
              'message' => 'Invalid input',
              'validation_errors' => $err->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
              'message' => 'Error: '.$th->getMessage()
            ], 500);
        }
    }
}
