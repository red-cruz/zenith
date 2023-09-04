<?php

namespace App\Http\Controllers;

use App\Models\Variation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VariationController extends Controller
{
    public function showAll(): JsonResponse
    {
        return Utils::tryCatch(function (): JsonResponse {
            return response()->json(Variation::all());
        });
    }

    public function show(Variation $variation): JsonResponse
    {
        return Utils::tryCatch(function () use ($variation): JsonResponse {
            return response()->json($variation);
        });
    }

    public function create(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'name' => ['required', 'string'],
              'product_id' => ['required', 'integer', 'exists:products,id']
            ]);

            $variation = new Variation();
            $variation->name = $validated['name'];
            $variation->product_id = $validated['product_id'];
            $variation->saveOrFail();

            return response()->json([
              'message' => 'successfully added a variation',
              'variation' => $variation,
            ]);
        });
    }

    public function update(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'id' => ['required', 'integer', 'exists:variations,id'],
              'name' => ['required', 'string'],
              'product_id' => ['required', 'integer', 'exists:products,id']
            ]);

            $variation = Variation::findOrFail($validated['id']);
            $variation->name = $validated['name'];
            $variation->product_id = $validated['product_id'];
            $variation->saveOrFail();

            return response()->json([
              'message' => 'successfully updated a variation',
              'variation' => $variation,
            ]);
        });
    }

    public function delete(Variation $variation): JsonResponse
    {
        return Utils::tryCatch(function () use ($variation) {
            $variation->deleteOrFail();

            return response()->json([
              'message' => 'Successfully deleted',
              'variation' => $variation,
            ]);
        });
    }
}
