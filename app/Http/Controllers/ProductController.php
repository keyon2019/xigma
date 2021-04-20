<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilters;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
//        $this->middleware('admin');
    }

    public function index(ProductFilters $filters, Request $request)
    {
        if ($request->wantsJson())
            return response()->json(Product::filter($filters)->latest()->paginate(10));
        return view('dashboard.product.index');
    }

    public function create()
    {
        return view('dashboard.product.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'price' => 'required|numeric',
            'old_price' => 'numeric',
            'splash' => 'numeric'
        ]);

        $product = Product::create($validated);
        return response()->json(['product' => $product]);
    }

    public function edit(Product $product)
    {
        return view('dashboard.product.edit')->with('product', $product->load('options'));
    }

    public function update(Product $product, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'price' => 'required|numeric',
            'old_price' => 'numeric',
            'splash' => 'numeric'
        ]);

        $product->update($validated);
        return response([]);
    }
}
