<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * This class provides static functions to handle errors.
 */
class TryCatch extends Controller
{
    /**
     * This function takes a callback function as an argument and tries to execute it.
     * If the callback function throws an exception, the function will catch the exception and return a JSON response with the error message.
     * If the callback function does not throw an exception, the function will return a JSON response with a success message.
     *
     * @param callable $callback The callback function to execute.
     * @return JsonResponse The JSON response.
     */
    public static function input(callable $callback): JsonResponse
    {
        try {
            return $callback();
        } catch(\Illuminate\Validation\ValidationException $err) {
            /**
             * This exception is thrown when the input data is invalid.
             *
             * @return JsonResponse The JSON response with the error message and the validation errors.
             */
            return response()->json([
              'message' => 'Invalid input',
              'validation_errors' => $err->errors()
            ], 422);
        } catch (\Throwable $th) {
            /**
             * This exception is thrown for any other errors.
             *
             * @return JsonResponse The JSON response with the error message.
             */
            return response()->json([
              'message' => 'Error: '.$th->getMessage()
            ], 500);
        }
    }
}