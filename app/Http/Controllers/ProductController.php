<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilters;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except('show');
    }

    public function index(ProductFilters $filters, Request $request)
    {
        if ($request->wantsJson())
            return response()->json(Product::without('variations')->filter($filters)->latest()->paginate(12));
        return view('dashboard.product.index');
    }

    public function show(Product $product)
    {
        return view('website.product.show')
            ->with('product', $product->load('variations.values.option')->load('comments'));
    }

    public function create()
    {
        return view('dashboard.product.create');
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json(['product' => $product]);
    }

    public function edit(Product $product)
    {
        return view('dashboard.product.edit')->with('product', $product->load('options', 'categories'));
    }

    public function update(Product $product, StoreProductRequest $request)
    {
        $product->update($request->validated());
        return response([]);
    }
}
