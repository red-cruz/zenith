<?php

namespace App\Http\Controllers;

use App\Models\ParentCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParentCategoryController extends Controller
{
    /**
     * show all parent category with its related categories
     */
    public function showAll(): JsonResponse
    {
        return Utils::tryCatch(function (): JsonResponse {
            return response()->json(ParentCategory::with('categories')->get());
        });
    }

    /**
     * show a parent category with its related categories
     */
    public function show(ParentCategory $parentCategory): JsonResponse
    {
        return Utils::tryCatch(function () use ($parentCategory): JsonResponse {
            $parentCategory->categories;
            return response()->json($parentCategory);
        });
    }

    public function create(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'name' => ['required', 'string'],
              'description' => ['required', 'string'],
              'image' => ['nullable', 'file']
            ]);

            $parentCategory = new ParentCategory();
            $parentCategory->name = $validated['name'];
            $parentCategory->description = $validated['description'];
            $parentCategory->saveOrFail();

            return response()->json([
              'message' => 'successfully added a parent category',
              'parentCategory' => $parentCategory
            ]);
        });
    }

    public function update(Request $request): JsonResponse
    {
        return Utils::tryCatch(function () use ($request): JsonResponse {
            $validated = $request->validate([
              'id' => ['required', 'integer', 'exists:parent_categories'],
              'name' => ['required', 'string'],
              'description' => ['required', 'string'],
              'image' => ['nullable', 'file']
            ]);

            $parentCategory = ParentCategory::findOrFail($validated['id']);
            $parentCategory->name = $validated['name'];
            $parentCategory->description = $validated['description'];
            $parentCategory->saveOrFail();

            return response()->json([
              'message' => 'successfully updated a category',
              'parentCategory' => $parentCategory,
            ]);
        });
    }

    public function delete(ParentCategory $parentCategory): JsonResponse
    {
        return Utils::tryCatch(function () use ($parentCategory) {
            $parentCategory->deleteOrFail();

            return response()->json([
              'message' => 'Successfully deleted',
              'parentCategory' => $parentCategory,
            ]);
        });
    }
}
