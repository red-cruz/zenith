<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Shop $shop, Product $product): JsonResponse
    {
        return response()->json([
          'product' => $product
        ]);
    }
}
