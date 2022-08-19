<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Product $product, Request $request)
    {
        Gate::authorize('edit-product');
        $product->categories()->attach($request->category_id);
        return response([]);
    }

    public function destroy(Product $product, Request $request)
    {
        Gate::authorize('edit-product');
        $product->categories()->detach($request->category_id);
        return response([]);
    }
}

