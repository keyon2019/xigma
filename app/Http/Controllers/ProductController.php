<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilters;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Scopes\VisibleProductsScope;
use App\TopProducts;
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
            return response()->json(
                Product::withoutGlobalScope(VisibleProductsScope::class)
                    ->without('variations')->filter($filters)
                    ->withAvailability()->latest()->paginate(12)
            );
        return view('dashboard.product.index')->with('options', Option::all());
    }

    public function show(Product $product, TopProducts $top)
    {
        return view('website.product.show')
            ->with('product', $product->load('variations.values.option')->load(['comments' => function ($query) {
                return $query->whereApproved(true)->latest();
            }]))
            ->with('topProducts', $top)
            ->with('category', $product->category ? $product->category->withAncestors() : new Category());
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

    public function edit($id)
    {
        $product = Product::withoutGlobalScope(VisibleProductsScope::class)->find($id);
        return view('dashboard.product.edit')->with('product', $product->load('options', 'categories'));
    }

    public function update($id, StoreProductRequest $request)
    {
        $product = Product::withoutGlobalScope(VisibleProductsScope::class)->find($id);
        $product->update($request->validated());
        return response([]);
    }
}
