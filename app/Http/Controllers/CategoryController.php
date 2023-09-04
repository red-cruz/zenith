<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function showAll(): JsonResponse
    {
        return Utils::tryCatch(function (): JsonResponse {
            return response()->json(Category::all());
        });
    }

    public function show(Category $category): JsonResponse
    {
        return Utils::tryCatch(function () use ($category): JsonResponse {
            return response()->json($category);
        });
    }

    public function create(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'name' => ['required', 'string'],
              'parent_category_id' => ['required', 'integer', 'exists:parent_categories,id']
            ]);

            $category = new Category();
            $category->name = $validated['name'];
            $category->parent_category_id = $validated['parent_category_id'];
            $category->saveOrFail();

            return response()->json([
              'message' => 'successfully added a category',
              $category
            ]);
        });
    }

    public function update(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'id' => ['required', 'integer', 'exists:categories,id'],
              'name' => ['required', 'string'],
              'parent_category_id' => ['required', 'integer', 'exists:parent_categories,id']
            ]);

            $category = Category::findOrFail($validated['id']);
            $category->name = $validated['name'];
            $category->parent_category_id = $validated['parent_category_id'];
            $category->saveOrFail();

            return response()->json([
              'message' => 'successfully updated a category',
              $category
            ]);
        });
    }

    public function delete(Category $category): JsonResponse
    {
        return Utils::tryCatch(function () use ($category) {
            $category->deleteOrFail();

            return response()->json([
              'message' => 'Successfully deleted',
              'category' => $category,
            ]);
        });
    }

    public function restore($shop_id): JsonResponse
    {
        return Utils::tryCatch(function () use ($shop_id): JsonResponse {
            $shop = Shop::withTrashed()->findOrFail($shop_id);
            Gate::authorize('shop-restore', $shop);

            $shop->restore();

            return response()->json([
              'message' => 'Successfully restored',
              'shop' => $shop,
            ]);
        });
    }

    public function forceDelete(Shop $shop): JsonResponse
    {
        return Utils::tryCatch(function () use ($shop) {
            Gate::authorize('shop-delete-permanent', $shop);

            $shop->forceDelete();

            return response()->json([
              'message' => 'Successfully deleted permanently',
              'shop_id' => $shop->id,
            ]);
        });
    }
}
