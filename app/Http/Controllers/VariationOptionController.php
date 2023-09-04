<?php

namespace App\Http\Controllers;

use App\Models\Variation;
use App\Models\VariationOption;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VariationOptionController extends Controller
{
    public function show(Variation $variation, VariationOption $variationOption): JsonResponse
    {
        return Utils::tryCatch(function () use ($variation, $variationOption): JsonResponse {

            $variationOption->variationOptions;
            return response()->json($variationOption);
        });
    }

    public function create(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'name' => ['required', 'string'],
              'product_id' => ['required', 'integer', 'exists:products,id']
            ]);

            $variationOption = new VariationOption();
            $variationOption->name = $validated['name'];
            $variationOption->product_id = $validated['product_id'];
            $variationOption->saveOrFail();

            return response()->json([
              'message' => 'successfully added a variation',
              'variation' => $variationOption,
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

            $variationOption = VariationOption::findOrFail($validated['id']);
            $variationOption->name = $validated['name'];
            $variationOption->product_id = $validated['product_id'];
            $variationOption->saveOrFail();

            return response()->json([
              'message' => 'successfully updated a variation',
              'variation' => $variationOption,
            ]);
        });
    }

    public function delete(VariationOption $variationOption): JsonResponse
    {
        return Utils::tryCatch(function () use ($variationOption) {
            $variationOption->deleteOrFail();

            return response()->json([
              'message' => 'Successfully deleted',
              'variation' => $variationOption,
            ]);
        });
    }
}
