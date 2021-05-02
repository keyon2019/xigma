<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
//        $this->middleware('admin');
    }

    public function store(Product $product, Request $request)
    {
        $product->categories()->attach($request->category_id);
        return response([]);
    }

    public function destroy(Product $product, Request $request)
    {
        $product->categories()->detach($request->category_id);
        return response([]);
    }
}

