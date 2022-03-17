<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function sync()
    {
        return response()->json([
            'products' => Product::without(['variations', 'pictures'])->get()
                ->map(function ($product) {
                return $product->only(['id', 'name']);
            }),
            'variations' => Variation::without(['values'])->get()->map(function ($variation) {
                return $variation->only(['id', 'product_id', 'name', 'price']);
            })
        ]);
    }
}
