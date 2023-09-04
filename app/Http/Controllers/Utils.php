<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class Utils extends Controller
{
    /**
     * This method takes a closure as an argument and tries to execute it within a database transaction.
     *
     * If the callback function throws an exception, the function will catch the exception and return a JSON response with the error message.
     *
     * If the callback function does not throw an exception, the function will commit the database transaction and return the callback function.
     *
     * @param Closure $callback The closure **must return** an `Illuminate\Http\JsonResponse`.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function tryCatch(Closure $callback): JsonResponse
    {
        try {
            return DB::transaction(function () use ($callback): JsonResponse {
                return $callback();
            });
        } catch(\Illuminate\Validation\ValidationException $err) {
            // This exception is thrown when the input data is invalid.
            return response()->json([
              'message' => 'Invalid input',
              'validation_errors' => $err->errors()
            ], 422);
        } catch(\Illuminate\Auth\Access\AuthorizationException $err) {
            // This exception is thrown when the user does not have permission to perform the requested action.
            return response()->json([
              'title' => 'Unauthorized access',
              'message' => $err->getMessage()
            ], 403);
        } catch(\Illuminate\Database\QueryException $err) {
            // This exception is thrown when there is an error in the database query.
            return response()->json([
              'title' => 'Database Error',
              'message' => $err->getMessage()
            ], 400);
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $err) {
            // This exception is thrown when the requested data is not found in the database.
            return response()->json([
              'title' => 'Database Error',
              'message' => 'Data not found'
            ], 404);
        } catch (\Throwable $th) {
            // This exception is thrown for any other errors.
            return response()->json([
              'message' => 'Error: '.$th->getMessage()
            ], 500);
        }
    }

    public static function jsonResponse(
        array $data = [],
        int $status = 200,
        array $headers = [],
        int $options = 0
    ): JsonResponse {
        return response()->json($data, $status, $headers, $options);
    }
}
