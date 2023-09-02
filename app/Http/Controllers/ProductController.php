<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index(Shop $shop, Product $product): JsonResponse
    {
        return response()->json([
          'product' => $product
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request): JsonResponse {

            $validated = $request->validate([
              'id' => ['required', 'integer', 'exists:products,id'],
              'name' => ['required', 'string'],
              'brand' => ['required', 'string'],
              'description' => ['required', 'string'],
              'quantity' => ['required', 'integer'],
              'price' => ['required', 'integer'],
              'prev_price' => ['required', 'integer'],
              'category_id' => ['required', 'integer', 'exists:categories,id'],
              'subcategory_id' => ['required', 'integer', 'exists:sub_categories,id'],
              // 'pfp' => ['required', 'file']
            ]);

            $product = Product::find($validated['id']);

            Gate::authorize('product-update', $product);

            $product->name = $validated['name'];
            $product->brand = $validated['brand'];
            $product->description = $validated['description'];
            $product->quantity = $validated['quantity'];
            $product->price = $validated['price'];
            $product->prev_price = $validated['prev_price'];
            $product->category_id = $validated['category_id'];

            $product->save();

            return response()->json(
                [
                  'message' => $validated['name'] .'has been updated',
                  'product' => $product
                ]
            );
        });
    }
}
